<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div v-if="response !== null" class="declaration">
        <div class="show-declaration__header text-center">
            <div class="show-declaration__header-angles" v-if="!getTablet">
                <img class="angle angle-right" src="../../../img/general/angle.svg" :alt="$e('locale.angle_alt')">
                <img class="angle angle-left" src="../../../img/general/angle.svg" :alt="$e('locale.angle_alt')">
            </div>

            <div v-if="!getTablet" class="show-declaration__header-img-container">
                <img class="cloud cloud-1 cloud-l" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
                <img class="cloud cloud-2 cloud-m" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
                <img class="cloud cloud-3 cloud-m" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
                <img class="cloud cloud-4 cloud-s" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
                <img class="plane" src="../../../img/general/plane.svg" :alt="$e('locale.plane_alt')">
                <img class="cloud cloud-5 cloud-l" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
            </div>
            <div class="show-declaration__header-text">
                <p>{{ response.date }} - {{ response.company }} - {{ response.main_country }}</p>
                <ul>
                    <li v-if="isAdmin" id="creatorinput">
                        {{ $e('locale.author_label') }}
                        <autocomplete
                                :url="$url('/users/search')"
                                anchor="name"
                                :min="3"
                                :debounce="500"
                                label="company"
                                :initValue="response.author"
                                :on-select="getUsers">
                        </autocomplete>
                    </li>
                    <li v-if="(response.owner !== response.author) && !isAdmin">{{ $e('locale.author_title', {author: response.author}) }}
                    </li>
                    <li v-if="response.owner">{{ $e('locale.owner_title', { owner: response.owner})}}</li>
                    <li v-if="response.supervisor_id && !canEditSupervisor">{{ $e('locale.supervisor_title',
                        {supervisor: response.supervisor}) }}
                    </li>
                    <li v-if="canEditSupervisor" id="supervisor">
                        {{ $e('locale.supervisor_label') }}
                        <form @submit.prevent="">
                            <select name="lawyers" id="laywers" @change="changeSupervisor" v-model="newsupervisor">
                                <option value="undefined">{{ $e('locale.select-a-supervisor')}}</option>
                                <option v-for="lawyer in lawyers" :value="lawyer"
                                        :selected="(lawyer.id === response.supervisor_id)">{{ lawyer.name }}
                                </option>
                            </select>
                        </form>
                    </li>
                </ul>
                <h1>{{ response.project }}</h1>
                <progress-bar :progressValue="progressValues.global"
                              @updateprogress="updateProgress($event)"
                              :show-value="true"
                              v-if="!response.validated"/>
                <div class="declaration-validated" v-if="response.validated">{{ $e('locale.validated-statement')}}</div>
            </div>

            <div class="show-declaration__header-export" @click="exportForm">
                <img src="../../../img/general/export.svg" :alt="$e('locale.export_alt')">
            </div>
        </div>
        <div class="small-container">
            <declarations-form :formItems="formItems"
                               :editMode="true"
                               :owner="response.owner"
                               :validated="response.validated"
                               :archived="response.archived"
                               :supervisable="allow('supervized', response)"
                               :progressValues="progressValues"
                               :id="response.id"
                               ref="form"
                               @updateprogress="updateProgress($event)"
                               @refresh="refresh"
                               @reset="reset"/>
        </div>
    </div>
</template>

<script>
    import ProgressBar from '../general/ProgressBar';
    import DeclarationsForm from './form/DeclarationsForm';
    import VSelect from 'vue-select';
    import Autocomplete from 'vue2-autocomplete-js';


    export default {
        name: 'edit-declaration',
        props: ['url'],
        components: {
            ProgressBar,
            DeclarationsForm,
            VSelect,
            Autocomplete,
        },
        data() {
            return {
                response: null,
                formItems: null,
                progressValues: null,
                lawyers: [],
                newsupervisor: null,
                lock: false,
            }
        },
        computed: {
            canEditSupervisor: function () {
                return (this.response !== null) && ((this.response.supervisor_id.length === 0 && window.App.user.role === 'lawyer') ||
                    window.App.user.role === 'admin');
            },
            isAdmin: function () {
                return window.App.user.role === 'admin';
            },
        },
        mounted() {
            this.refresh();
        },
        methods: {
            exportForm() {
                window.location.href = this.$url('/statements/' + this.response.id + '/csv');
            },
            updateProgress(value) {
                this.progressValues = value;
            },
            reset() {

            },
            refresh() {
                axios.get(this.url).then(response => {
                    this.response = response.data;

                    // Load lawyers
                    if (this.canEditSupervisor && this.lawyers.length === 0) {
                        axios.get(this.$url('/users/data'), {params: {role: 'minlawyer'}}).then(data => {
                            this.lock = true;
                            this.lawyers = data.data;
                            this.newsupervisor = _.find(this.lawyers, function (lawyer) {
                                return lawyer.id === response.data.supervisor_id;
                            });
                            this.lock = false;
                        });
                    }
                    this.formItems = response.data.pages;
                    this.progressValues = response.data.progress;
                    if(this.$refs.form)
                    {
                        this.$refs.form.loadRecap();
                    }

                }).catch(error => {
                    console.log(error);
                    alert(error);
                });
            },
            changeSupervisor(event) {
                if (this.canEditSupervisor && (this.newsupervisor.id !== this.response.supervisor_id)) {
                    axios.put(this.$url('/statements/' + this.response.id + '/supervise'), {
                        id: this.newsupervisor.id,
                    }).then(data => {
                        this.$refs.form.saveForm();
                    }).catch(error => {
                        console.log(error);
                    });
                }
            },
            getUsers(obj) {
                if (window.App.user.role === 'admin') {
                    axios.put(this.$url('/statements/' + this.response.id + '/creator'), {
                        id: obj.id,
                    }).then(data => {
                        this.$refs.form.saveForm();
                    }).catch(error => {
                        console.log(error);
                    });
                }
            }
        }
    }
</script>

<style lang="scss">
    @import '../../../styles/colors';
    @import '../../../styles/mixins';
    @import '../../../styles/variables';
    @import '../../../styles/ui/clouds';

    #laywers {
        color: $white;
        border-bottom-color: $white;
        background-color: $main-color;
        appearance: none;
    }

    .show-declaration {
        .small-container {
            min-height: inherit;

            &:last-of-type {
                padding-top: $small-content-space;
            }
        }

        &__header {
            position: relative;
            padding: 2.5rem 0;
            width: 100vw;
            min-height: 16rem;
            color: $white;
            background-color: $main-color;

            &-angles {
                .angle {
                    position: absolute;
                }

                .angle-left {
                    left: 0;
                    bottom: -5rem;
                    transform: rotate(180deg);
                }

                .angle-right {
                    right: 0;
                    top: -5rem;
                }
            }

            &-img-container {
                z-index: 0;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;

                .cloud-1 {
                    top: 2.5rem;
                    left: 6rem;
                }

                .cloud-2 {
                    left: 26rem;
                    bottom: -40%;
                    transform: translateY(-50%);
                }

                .cloud-3 {
                    top: 3rem;
                    right: 20rem;
                }

                .cloud-4 {
                    top: 6rem;
                    right: 4rem;
                }

                .plane {
                    position: absolute;
                    top: 6rem;
                    right: -14rem;
                    max-width: 35rem;
                }

                .cloud-5 {
                    top: 45rem;
                    right: -5.5rem;
                }
            }

            &-text {
                margin: 0 auto;
                max-width: $small-container-width;

                @include custom-break($small-container-width) {
                    padding: 0 2.5rem;
                }

                .dropdown-menu {
                    li {
                        @include fontSize(12)
                    }
                }
            }

            p, li {
                letter-spacing: 0.1rem;
                @include fontSize(12)
            }

            ul {
                margin: 1rem 0 0;
                padding: 0;
                list-style-type: none;

                li {
                    position: relative;
                    margin: 0 1rem;
                    display: inline-block;

                    &::before {
                        content: '-';
                        position: absolute;
                        top: 50%;
                        left: -1.2rem;
                        transform: translate(-50%, -50%);
                    }

                    &:first-of-type {
                        margin-left: 0;

                        &::before {
                            display: none;
                        }
                    }

                    &:last-of-type {
                        margin-right: 0;
                    }
                }
            }

            .progress-wrap {
                margin: 0 auto;
                max-width: 20rem;
            }

            &-export {
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                left: 50%;
                bottom: 0;
                transform: translate(-50%, 50%);
                width: 4.5rem;
                height: 4.5rem;
                border-radius: 50%;
                background-color: $main-color;
                cursor: pointer;
            }
        }
    }

    #supervisorselector {
        max-width: 500px;
        margin: 0 auto;
        .dropdown-toggle {
            background: $main-color;
            border-color: $white;
        }
        .selected-tag {
            color: $white;
            background-color: $main-color;
            .close {
                color: $white;
                opacity: .5;
            }
        }
        &.dropdown.open .dropdown-toggle,
        &.dropdown.open .dropdown-menu,
        &.dropdown.open .open-indicator:before {
            border-color: $white;
            opacity: .5;
        }
        .active a {
            background: rgba(50, 50, 50, .1);
            color: $white;
        }
        .dropdown-toggle .clear {
            color: $white;
            opacity: .5;
        }
        .dropdown-toggle .open-indicator:before {
            border-color: $white;
            opacity: .5;
        }

        &.dropdown li {
            border-bottom: 1px solid rgba($grey, .1);
            &:last-child {
                border-bottom: none;
            }
        }

        &.dropdown li a {
            padding: 10px 20px;
            display: inline-flex;
            width: 100%;
            align-items: center;
            font-size: 1.5em;
            .octicon {
                font-size: 1.5em;
                width: 1.5em;
            }
        }
        &.dropdown .highlight a,
        &.dropdown li:hover a {
            background: $darker-main-color;
            color: $white;
        }
    }

    #creatorinput {
        input {
            color: $white;
            border-bottom-color: $white;
            width: 100%;
        }

        .autocomplete-wrapper {
            position: relative;
            margin: 0 1rem;
            display: inline-block;
        }

        .transition, .autocomplete,
        .showAll-transition,
        .autocomplete ul,
        .autocomplete ul li a {
            transition: all 0.3s ease-out;
            -moz-transition: all 0.3s ease-out;
            -webkit-transition: all 0.3s ease-out;
            -o-transition: all 0.3s ease-out;
        }

        .autocomplete ul {
            position: absolute;
            list-style: none;
            background: $main-color;
            padding: 10px 0;
            margin: 0;
            margin-top: 10px;
            border: $darker-main-color;
            z-index: 100;
        }

        .autocomplete ul:before {
            content: "";
            display: block;
            position: absolute;
            height: 0;
            width: 0;
            border: 10px solid transparent;
            border-bottom: 10px solid $grey;
            left: 46%;
            top: -20px
        }

        .autocomplete ul li a {
            text-decoration: none;
            display: block;
            background: $main-color;
            color: $white;
            padding: 5px;
            padding-left: 10px;
            font-size: 0.9em;
        }

        .autocomplete {
            li {
                border-bottom: 1px solid $darker-main-color;
            }
            li:last-child {
                border-bottom: none;
                margin: 0 1rem;
            }
            .autocomplete-anchor-text {
                font-weight: normal
            }

            .autocomplete-anchor-label {
                font-size: 0.7em;
                font-style: italic;
            }
            li::before {
                content: none;
            }
        }

        .autocomplete ul li a:hover,
        .autocomplete ul li.focus-list a {
            color: $white;
            background: $darker-main-color;
        }

        .autocomplete ul li a span, /*backwards compat*/
        .autocomplete ul li a .autocomplete-anchor-label {
            display: block;
            margin-top: 3px;
            color: $grey;
        }

        .autocomplete ul li a:hover .autocomplete-anchor-label,
        .autocomplete ul li.focus-list a span, /*backwards compat*/
        .autocomplete ul li a:hover .autocomplete-anchor-label,
        .autocomplete ul li.focus-list a span { /*backwards compat*/
            color: $white;
        }
    }

    #supervisor {
        form {
            position: relative;
            margin: 0 1rem;
            margin-right: 1rem;
            display: inline-block;
        }
    }
</style>
