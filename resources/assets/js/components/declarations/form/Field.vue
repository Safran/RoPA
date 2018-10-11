<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <transition name="fade">
        <div v-show="isShown" :class="classes">
            <div :class="editMode ? 'field-group' : ''">
                <validation-switch v-model="data.answer.validated_at"
                                   v-if="editMode && data.type !== 'model' && data.type !== 'static'"
                                   :supervisable="supervisable"
                                   :readonly="(data.field_required || data.cnil_required) && !(supervisable && data.answer.id !== null && data.answer.value !== null && data.answer.value !== '' )"
                                   @updateprogress="updateProgress($event)"
                                   @refresh="refresh"></validation-switch>

                <component :key="data.id"
                           :class="editMode ? 'form-group__edit' : ''"
                           :is="`${data.type}-field`"
                           :data="data"
                           :readonly="editMode && (data.answer.validated_at !== null) && data.answer.validated_at !== false"
                           :elements="elements"
                           :value="data.answer.value"
                           v-model="data.answer.value"
                           :editMode="editMode"
                           @reload="reload"
                           @updateprogress="updateProgress($event)"/>
            </div>
            <div v-if="errors && errors[data.name]" v-text="$e(errors[data.name][0])"
                 class="error-message"></div>
            <comments v-if="editMode && data.type !== 'model' && data.type !== 'static'"
                      v-model="data.answer.comments"
                      :data="data"
                      :readonly="editMode && (data.answer.validated_at !== null) && data.answer.validated_at !== false"></comments>
        </div>
    </transition>
</template>

<script>
    import componentsList from '@/js/components/declarations/form/componentsList';
    import ValidationSwitch from '@/js/components/declarations/form/ValidationSwitch';
    import Comments from '@/js/components/declarations/form/Comments';

    export default {
        name: "field",
        props: {
            data: {
                type: Object,
                required: true,
            },
            supervisable: {
                type: Boolean,
                default: false,
            },
            elements: {
                type: Array,
                required: true,
            },
            invalid: {
                type: Boolean,
                default: false,
            },
            editMode: {
                type: Boolean,
                default: false,
            },
            errors: {
                type: Boolean | Object,
                default: false,
            },
        },
        components: {
            componentsList,
            ValidationSwitch,
            Comments,
        },
        data() {
            return {
                internalelements: this.elements,
                disabled: false,
                initialValue: this.data.answer.value,
            };
        },
        methods: {
            findTargetByName(name) {
                return _.find(this.internalelements, element => element.name === name);
            },
            updateValue(value) {
                this.$emit('input', value);
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
            reset() {
                this.updateValue(this.initialValue);
            },
        },
        computed: {
            classes() {
                return [
                    {'has-error': this.errors !== false && this.errors[this.data.name]},
                    {'is-disabled': this.disabled},
                    {'is-required': this.data.field_required},
                    {'is-edit': this.editMode},
                    {'is-new': !this.editMode},
                    {'is-validate': this.editMode && this.data.answer.validated_at !== null && this.data.answer.validated_at !== false},
                ];
            },
            isShown: function () {
                // By default, if no rules are set, it can be shown
                if (this.data.rules.length == 0) return true;

                for (const key in this.data.rules) {
                    let rule = this.data.rules[key],
                        target = this.findTargetByName(rule.element.name);
                    if (target !== undefined) {
                        let value = JSON.parse(JSON.stringify(target.answer.value));
                        if(Array.isArray(value))
                        {
                            if (value.indexOf(rule.value) >= 0) {
                                return true;
                            }
                        } else {
                            if (value === rule.value) {
                                return true;
                            }
                        }
                    }
                }
                this.reset();
                return false;
            },
        },
    }
</script>

<style lang="scss">
    @import './../../../../styles/_colors';
    @import './../../../../styles/variables';
    @import './../../../../styles/mixins';

    .has-error .field-group input,
    .has-error .field-group select,
    .has-error .field-group textarea {
        border-bottom: 1px solid $red;
    }

    .has-error .error-message {
        color: $red;
        font-style: italic;
    }

    .is-edit .error-message {
        margin-left: 9rem;
    }

    .error-message {
        padding: 1.5rem 0 .3rem 3.5rem;
        border-left: 0.3rem solid $red;
        font-size: 10px;
    }

    .has-error {
        .form-group__edit {
            border-left-color: $red;
        }
    }

    .is-required p[class$=__label]:after,
    .is-required label[class$=__label]:after {
        content: " *";
        color: $red;
        position: absolute;
    }

    .is-validate {
        .form-group__edit {
            color: $grey;
            border-left-color: $grey;

            @include mobile {
                padding-left: 2rem;
            }

            input {
                color: $grey;
            }

            input[type="radio"]:not(:checked) + label:before,
            input[type="radio"]:checked + label:before {
                border-color: $grey;
            }

            input[type="radio"]:not(:checked) + label:after,
            input[type="radio"]:checked + label:after {
                background-color: $grey;
            }

            .v-select.disabled .dropdown-toggle,
            .v-select.disabled .dropdown-toggle .clear,
            .v-select.disabled .dropdown-toggle input,
            .v-select.disabled .open-indicator,
            .v-select.disabled .selected-tag .close {
                background-color: transparent;
            }

            .v-select.disabled span {
                color: $grey;
            }
        }
    }

    .field-group {
        display: flex;
        align-items: center;
    }

    .declarations-form {
        .has-error {
            .form-group {
                margin-bottom: 0;
            }
        }
    }
</style>