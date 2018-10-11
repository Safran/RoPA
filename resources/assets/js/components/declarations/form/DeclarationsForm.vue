<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div>
        <div class="declarations-form">
            <modal :name="'save-model'" class="modal" v-if="editMode" @before-open="saveCommentData">
                <div class="modal__content">
                    <h2>{{ $e('locale.comment-templates.add-title')}}</h2>
                    <input type="text" :placeholder="$e('locale.comment-templates.title-placeholder')"
                           v-model="commentModel.title">
                    <button class="btn-primary" @click="saveCommentModel">{{ $e('locale.comment-templates.save-button')
                        }}
                    </button>
                </div>
            </modal>

            <sidebar-component v-if="!editMode"/>
            <div class="declarations-form__text" :class="editMode ? 'no-padding' : ''">
                <pointers v-if="editMode" :data="formItems" :activeStep="activeStep" :progressValues="progressValues"
                          @click="goToStep($event.index)"></pointers>

                <div class="alert alert-validation text-center"
                     v-if="editMode && progressValues['global'] === 100 && !validated && canValidate">

                    <p v-html="$e('locale.validation-disclaimer')"></p>
                    <br/>
                    <button class="btn-primary btn-validation" @click="validate">{{ $e('locale.validation-button')}}
                    </button>
                </div>
                <h1 :class="editMode ? 'no-margin-bottom' : ''">{{ activeStep + 1 }}/<span
                        class="declarations-form__text-length">{{ formItems.length }}</span> {{
                    formItems[activeStep] !== undefined ? formItems[activeStep].title : $e('locale.recap-page-title')}}
                </h1>
                <form id="declarations-form__form" :class="editMode ? 'pb' : ''" @submit.prevent="" action=""
                      method="post" novalidate>
                    <div :key="-1" v-show="-1 === activeStep" v-if="editMode && progressValues['global'] === 100">
                        <div class="form-group form-group__edit form-recap"
                             v-if="item.value"
                             v-for="(item, index) in recapItems">

                            <div class="form-recap__label">{{ item.label }}</div>
                            <div class="form-recap__value" v-html="item.value"></div>

                        </div>
                    </div>

                    <div v-for="(page, index) in formItems" :key="page.id" v-show="index === activeStep">
                        <div v-if="page.disclaimer != ''" v-html="page.disclaimer"
                             class="declarations-form__form__disclaimer"
                             :class="editMode ? 'declarations-form__form__disclaimer-edit' : ''"></div>

                        <field v-for="input in page.elements"
                               :key="input.id"
                               :data="input"
                               :supervisable="supervisable"
                               :errors="errors"
                               :elements="page.elements"
                               :value="input.answer.value"
                               v-model="input.answer.value"
                               :editMode="editMode"
                               @refresh="refresh"
                               @reload="reload"
                               :ref="input.name"
                               v-if="input.type != 'model' || !editMode"
                               @updateprogress="updateProgress($event)"
                        />
                    </div>
                    <div class="alert alert-archivate text-center"
                         v-if="editMode && progressValues['global'] === 100 && validated && ! archived && isAdmin">

                        <p v-html="$e('locale.archivate-disclaimer')"></p>
                        <br/>
                        <button class="btn-primary btn-archivate" @click="archivate">{{ $e('locale.archivate-button')}}
                        </button>
                    </div>
                </form>

                <div class="actions" :class="actionsClasses">
                    <button class="btn-secondary" @click="decreaseactiveStep"
                            v-if="activeStep > 0 || (validated && activeStep >=0)">{{ $e('locale.previous-button') }}
                    </button>

                    <button v-if="editMode && !archived" class="btn-primary" @click="saveForm">{{
                        $e('locale.validation-button') }}
                    </button>

                    <button v-if="!(archived && (activeStep === (formItems.length - 1)))" class="btn-primary"
                            @click="increaseactiveStep">{{ activeStep < (formItems.length - 1) ?
                        $e('locale.next-button') :
                        $e('locale.finished-button') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="model-actions" v-if="isAdmin && !editMode && activeStep < formItems.length">
            <input type="text" :placeholder="$e('locale.save-model-placeholder')" v-model="modelname"/>
            <button class="btn-chevron" @click="saveModel" :disabled="modelname.length === 0">{{
                $e('locale.save-model-button') }}
            </button>
        </div>
        <loading
                :show="loading"
                :overlay="true"
                :label="$e('locale.processing')">
        </loading>
    </div>
</template>

<script>
    import SidebarComponent from '../../layouts/SidebarComponent'
    import Field from './Field'
    import Pointers from '../../general/Pointers'
    import loading from 'vue-full-loading'

    export default {
        name: 'declarations-form',
        props: {
            formItems: {
                type: Array,
                required: true,
            },
            editMode: {
                type: Boolean,
                default: false,
            },
            owner: {
                type: String,
                required: false,
            },
            supervisable: {
                type: Boolean,
                default: false,
            },
            progressValues: {
                type: Object,
            },
            id: {
                type: Number,
            },
            validated: {
                type: Boolean,
                default: false,
            },
            archived: {
                type: Boolean,
                default: false,
            },
        },
        components: {
            SidebarComponent,
            Field,
            Pointers,
            loading
        },
        data() {
            return {
                activeStep: 0,
                errors: false,
                modelname: '',
                users: [],
                companies: [],
                countries: [],
                recapItems: [],
                commentModel: {},
                loading: false,
            }
        },
        mounted() {
            if (this.editMode) {
                if (this.progressValues['global'] === 100 && this.activeStep === 0) {
                    this.activeStep = -1;

                    this.loadRecap();


                } else if (this.progressValues['global'] !== 100 && this.activeStep === -1) {
                    this.activeStep = 0;
                }
            } else {
                this.activeStep = 0;
            }
        },
        methods: {
            saveCommentData(event) {
                this.commentModel.id = event.params.id;
                this.commentModel.body = event.params.body;
            },
            saveCommentModel() {
                this.loading = true;
                axios.post(this.$url('/commenttemplates/' + this.commentModel.id), {
                    title: this.commentModel.title,
                    body: this.commentModel.body
                }).then((response) => {
                    let id = this.commentModel.id,
                        theelement = undefined;
                    _.forEach(this.formItems, function (page) {
                        theelement = _.find(page.elements, function (element) {
                            return (element.id === id);
                        });
                        if (theelement) return false;
                    });
                    if (theelement) {
                        theelement.commenttemplates.push({
                            id: response.data.id,
                            title: response.data.title,
                            body: response.data.body
                        });
                        this.$modal.hide('save-model');
                    }
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                });
            },
            saveModel() {
                this.loading = true;
                let datas = this.getTouchedData();
                datas.__title = this.modelname;
                axios.post(this.$url('/statementtemplates'), datas).then(response => {
                    //flash(response);
                    this.$emit('refresh');
                    this.loading = false;
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    flash(this.errors);
                    this.loading = false;
                });
            },
            validate() {
                if (this.id) {
                    this.loading = true;
                    axios.put(this.$url('/statements/' + this.id + '/validate'))
                        .then(response => {
                            this.$emit('refresh');
                            this.loading = false;
                        }).catch(error => {
                        this.errors = error.response.data.errors;
                        flash(this.errors, 'warning');
                        this.loading = false;
                    });
                }
            },
            archivate() {
                if (this.id) {
                    //window.Pace.options.ajax = false;
                    this.loading = true;
                    axios.put(this.$url('/statements/' + this.id + '/archivate'))
                        .then(response => {
                            this.$emit('refresh');
                            this.loading = false;
                        }).catch(error => {
                        this.errors = error.response.data.errors;
                        flash(this.errors);
                        this.loading = false;
                    });
                }
            },
            increaseactiveStep() {
                if (this.activeStep >= (this.formItems.length - 1)) {
                    this.saveForm();
                } else {
                    window.scrollTo(0, 0);
                    this.activeStep++;
                }
            },
            decreaseactiveStep() {
                window.scrollTo(0, 0);
                this.activeStep--;
            },
            goToStep(index) {
                this.activeStep = index;
            },
            updateProgress(value) {
                this.$emit('updateprogress', value);
            },
            refresh() {
                this.$emit('refresh');
            },
            reload(elements) {
                this.$emit('reload', elements);
            },
            loadRecap() {
                let load = function ([users, companies, countries]) {
                    this.recapItems = this.formatCNIL(users, companies, countries);
                };
                load = load.bind(this);
                Promise.all([this.getUsers(), this.getCompanies(), this.getCountries()]).then(load);
            },
            saveForm() {
                //window.Pace.options.ajax = false;
                this.loading = true;
                window.scrollTo(0, 0);
                let data = this.getData();
                /**
                 for (let pair of data.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }
                 */
                if (this.editMode) {
                    data.append('_method', 'PUT');
                    axios.post(this.$url('/statements/' + this.$parent.response.id + '/update'), data, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                        this.$emit('refresh');
                        flash(this.$e('locale.statement-saved'));
                        this.loading = false;
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                        //flash(this.errors, 'error');
                        this.switchToFirstPageWithError();
                        this.loading = false;
                    });
                } else {
                    axios.post(this.$url('/statements'), data, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                        flash(this.$e('locale.statement-created'));
                        window.location.href = this.$url('/statements/' + response.data.id + '/edit');
                        this.loading = false;
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                        //flash(this.errors, 'error');
                        this.switchToFirstPageWithError();
                        this.loading = false;
                    });
                }
            },
            switchToFirstPageWithError() {
                // Find
                let pages = [],
                    items = this.formItems,
                    i = 0;
                _.forEach(this.errors, function (error, name) {
                    _.forEach(items, function (page) {
                        let element = _.find(page.elements, element => element.name === name);
                        if (element) {
                            pages.push(i);
                        }
                        i++;
                    });
                });
                this.activeStep = _.min(pages);
            },
            getTouchedData() {
                let data = {};
                let form = this;
                _.forEach(this.formItems, function (page) {
                    _.forEach(page.elements, function (element) {
                        if (element.answer.value !== element.answer.original) {
                            switch (element.type) {
                                case 'static' :
                                case 'model':
                                    // Do Nothing
                                    break;
                                case 'file':
                                    // TODO
                                    break;
                                case 'range':
                                    // TODO
                                    break;
                                case 'list':
                                case 'text':
                                case 'textarea':
                                case 'radio':
                                case 'check':
                                case 'datepicker':
                                case 'username':
                                case 'company':
                                case 'country':
                                case 'type':
                                default:
                                    data[element.name] = element.answer.value;
                                    break;
                            }
                        }
                    });
                });
                return data;
            },
            getData() {
                let data = new FormData();
                let form = this;

                _.forEach(form.formItems, function (page) {
                    _.forEach(page.elements, function (element) {
                        switch (element.type) {
                            case 'static' :
                            case 'model':
                                // Do Nothing
                                break;
                            case 'range':
                                // TODO
                                break;
                            case 'file':
                                data.append(element.name, element.answer.value instanceof File ? element.answer.value : serialize(null));
                                break;
                            case 'company':
                                if (element.answer.value > 0) {
                                    data.append(element.name, serialize(element.answer.value));
                                }
                                break;
                            case 'textarea':
                                data.append(element.name, serialize(nl2br(element.answer.value)));
                                break;
                            case 'list':
                            case 'text':
                            case 'radio':
                            case 'check':
                            case 'datepicker':
                            case 'username':
                            case 'country':
                            case 'type':
                            default:
                                data.append(element.name, serialize(element.answer.value));
                                break;
                        }
                    });
                });
                return data;
            },
            formatCNIL: function (users, companies, countries) {
                let cnil = [], vm = this;
                if (users.length > 0) {
                    users = users[0];
                }

                _.forEach(this.formItems, function (page) {
                        _.forEach(page.elements, function (element) {
                                if (element.cnil_required) {
                                    let answer = element.answer.value;
                                    if (element.type === 'radiogroup') {
                                        answer = _.find(element.special, function (option) {
                                            return option.value === answer
                                        });
                                        answer = answer !== undefined ? answer.label : '';
                                    } else if (element.type === 'checkboxgroup') {
                                        let answers = answer;
                                        answer = _.filter(element.special, function (option) {
                                            return (_.indexOf(answers, option.value) >= 0);
                                        });
                                        let $text = '';
                                        _.forEach(answer, function (a) {
                                            // console.log(a);
                                            if (a !== undefined) {
                                                $text += a.label + ', ';
                                            }
                                        });
                                        answer = $text.substring(0, $text.length - 2);
                                    } else if (element.type === 'country') {
                                        _.forEach(countries.data.data, function (country) {
                                            if (country.id === answer) {
                                                answer = country.name;
                                            }
                                        });
                                    } else if (element.type === 'type') {
                                        // console.log(element);
                                    } else if (element.type === 'datepicker') {
                                        answer = new Date(answer).toLocaleDateString(window.App.locale);

                                    } else if (element.type === 'company') {
                                        _.forEach(companies.data, function (company) {
                                            if (company.id === answer) {
                                                answer = company.name;
                                            }
                                        });
                                    } else if (element.type === 'username') {
                                        //console.log(users.data);
                                        _.forEach(users.data, function (user) {
                                            if (user.id === answer) {
                                                answer = user.name;
                                            }
                                        });
                                    } else if (element.type === 'file') {
                                        if (answer !== undefined && answer.name !== undefined) {
                                            let tmp = answer;
                                            answer = '<a href="' + tmp.link + '" class="fieldvalue__file" target="_blank">';
                                            if (tmp.mime !== undefined) {
                                                answer += '<img src="/images/form/attachments/type_' + tmp.mime + '.svg">';
                                            }
                                            answer += '<span>' + tmp.name + '</span></a>';

                                        } else {
                                            answer = '';
                                        }
                                    }

                                    let el = {
                                        label: element.label,
                                        value: answer,
                                    };
                                    cnil.push(el);
                                }
                            }
                        );
                    }
                )
                ;
                return cnil;
            },
            getUser: function (id) {
                return axios.get(vm.$url('/users/search') + '?i=' + id);
            }
            ,
            getUsers: function () {
                //return [];//axios.get(this.$url('/users/data'));
                let users = [], vm = this;
                _.forEach(this.formItems, function (page) {
                    _.forEach(page.elements, function (element) {
                            if (element.cnil_required && element.type === 'username') {
                                users.push(axios.get(vm.$url('/users/search') + '?i=' + element.answer.value));
                            }
                        }
                    );
                });
                return Promise.all(users);
            }
            ,
            getCompanies: function () {
                return axios.get(this.$url('/companies/data'));
            }
            ,
            getCountries: function () {
                return axios.get(this.$url('/countries/data'));
            }
            ,
        },
        computed: {
            actionsClasses() {
                return {
                    'actions__ml': this.editMode,
                    'align-right': (this.activeStep === 0 && !this.editMode) || (this.archived && this.activeStep === -1),
                }
            }
            ,
            isAdmin: function () {
                return window.App.user.role === 'admin';
            }
            ,
            canValidate: function () {
                return (window.App.user.full_name === this.owner);
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../styles/variables';
    @import '../../../../styles/colors';
    @import '../../../../styles/mixins';
    @import '../../../../styles/ui/clouds';
    @import '../../../../styles/ui/indicators';

    .modal {
        &__content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            height: 100%;

            h2 {
                margin: 0;
                @include fontSize(18);
            }

            input {
                margin: 3rem 0;
                width: 52%
            }
        }
    }

    .form-recap {
        margin-top: 2rem;
        &__label {
            @include fontSize(14);
            color: $dark-grey;
        }
        &__value {
            @include fontSize(14);
        }
    }

    .pb {
        padding-bottom: 10rem;
    }

    .declarations-form {
        display: flex;
        min-height: 65vh;

        .alert-archivate {
            color: $white;
            margin-top: 10rem;
        }

        .alert-validation {
            color: $white;
            margin-top: 1rem;
        }

        .alert-validation {
            background-color: $green;
            border-color: $darker-green;
        }

        .alert-archivate {
            background-color: $lighter-red;
            border-color: $red;
        }

        .btn-validation {
            color: $white;
            background-color: $darker-green;
        }

        .btn-archivate {
            color: $white;
            background-color: $red;
        }

        .no-padding {
            padding: 0;
        }

        &__text {
            z-index: 1;
            position: relative;
            padding-bottom: $big-content-space;
            padding-left: 6.5rem;
            width: 100%;
            background-color: $white;

            @include mobile {
                padding-left: 0;
            }

            h1 {
                margin-left: 2.8rem;
                margin-bottom: $big-content-space;

                @include mobile {
                    margin-left: 0;
                    margin-bottom: $medium-content-space;
                }

                &.no-margin-bottom {
                    margin-bottom: 0;
                }
            }

            &-length {
                color: $main-color;
            }

            .actions {
                position: absolute;
                bottom: 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: calc(100% - 9rem);

                @include mobile {
                    margin-left: 7rem;
                }
            }

            .actions__ml {
                margin-left: 9rem;
            }

            .align-right {
                justify-content: flex-end;
            }
        }

        &__form {
            &__disclaimer {
                text-align: justify;
                line-height: 2.1rem;

                &-edit {
                    margin: $small-content-space;
                }
            }
        }
    }

    .model-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: $small-content-space;
        margin-left: 16.5rem;
        width: calc(100% - 16.5rem);

        @include mobile {
            float: inherit;
            flex-direction: column;

            input {
                margin-bottom: 1.5rem;
            }

            .btn-primary {
                margin: 0 auto;
                width: 100%;
            }
        }

        input {
            margin-right: 3rem;
        }

        button {
            width: 35rem;
            @include fontSize(13);
        }
    }
</style>
