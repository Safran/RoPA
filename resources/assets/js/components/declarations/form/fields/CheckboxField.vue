<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <label :for="`${data.name}-${index}`" class="checkbox-field" :class="classes">
        <input class="checkbox-field__input"
               type="checkbox"

               :id="`${data.name}-${index}`"
               :checked.prop="isChecked"
               :name="data.name"
               :value="submittedValue"
               :disabled="readonly || disabled"

               @change="onChange"
               @click="onClick">

        <div class="checkbox__checkmark">
            <div class="checkbox__focus-ring"></div>
        </div>

        <div class="checkbox__label">
            {{ input.label }}
        </div>
    </label>
</template>

<script>
    import {looseEqual} from "../../../../plugins/utils";

    export default {
        name: "checkbox-field",
        props: {
            data: {
                type: Object,
                required: true,
            },
            submittedValue: {
                type: String,
                default: 'on',
            },
            input: {
                type: Object,
                required: true,
            },
            index: Number,
            value: {
                required: true
            },
            trueValue: {
                default: true
            },
            falseValue: {
                default: false
            },
            checked: {
                type: Boolean,
                default: false
            },
            readonly: {
                type: Boolean,
                default: false
            },
        },
        computed: {
            classes() {
                return [
                    {'is-checked': this.isChecked},
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ];
            }
        },
        data() {
            return {
                isChecked: looseEqual(this.value, this.trueValue) || this.checked,
                disabled: false,
            };
        },
        watch: {
            value() {
                this.isChecked = looseEqual(this.value, this.trueValue);
            }
        },
        created() {
            this.$emit('input', this.isChecked ? this.trueValue : this.falseValue);
        },
        methods: {
            onClick(e) {
                this.isChecked = e.target.checked;
                this.$emit('input', e.target.checked ? this.trueValue : this.falseValue);
            },
            onChange(e) {
                this.isChecked = e.target.checked;
                this.$emit('change', this.isChecked ? this.trueValue : this.falseValue, e);
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/mixins';

    label.checkbox-field {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        margin: 0 0 rem-calc(8px);
        position: relative;

        &:first-of-type {
            margin-top: 0.6rem;
        }

        .checkbox-field__input {
            position: absolute;
            opacity: 0;
            body[modality="keyboard"] &:focus + .checkbox__checkmark {
                .checkbox__focus-ring {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        }

        input[type='checkbox'] {
            display: none;
        }


        &:not(.is-checked):hover,
        &:not(.is-checked) {
            .checkbox__checkmark::before {
                border-color: $main-color;
            }
        }

        &.is-checked:hover,
        &.is-checked {
            .checkbox__checkmark::before {
                background-color: darken($main-color, 5%);
                border-color: darken($main-color, 5%);
            }
        }
        &.is-checked {
            .checkbox__checkmark::after {
                border-bottom: 0.2rem solid white;
                border-right: 0.2rem solid white;
                opacity: 1;
            }
            .checkbox__checkmark::before {
                background-color: $main-color;
                border-color: $main-color;
            }
            .checkbox__focus-ring {
                background-color: rgba($main-color, 0.18);
            }
        }

        .checkbox__label {
            margin-left: rem-calc(15px);
            line-height: 3rem;
            @include fontSize(14);
            cursor: pointer;
        }

        .checkbox__checkmark {
            background-color: $white;
            cursor: pointer;
            flex-shrink: 0;
            height: 1.7rem;
            position: relative;
            width: 1.7rem;
            top: 6px;

            &::before {
                border-radius: 0.2rem;
                border: 0.2rem solid $main-color;
                box-sizing: border-box;
                content: "";
                display: block;
                height: 100%;
                left: 0;
                position: absolute;
                top: 0;
                transition: all 0.3s ease;
                width: 100%;
            }
            &::after {
                bottom: rem-calc(8px);
                box-sizing: border-box;
                content: "";
                display: block;
                height: rem-calc(21px);
                top: 47%;
                left: rem-calc(10px);
                opacity: 0;
                position: absolute;
                transform: translateY(-50%) rotate(45deg);
                transition-delay: 0.1s;
                transition: opacity 0.3s ease;
                width: rem-calc(10px);
            }
        }
        .checkbox__focus-ring {
            border-radius: 50%;
            height: 0.7rem;
            margin-left: -(0.2rem - 3.57rem) / 2;
            margin-top: -(0.2rem - 3.57rem) / 2;
            opacity: 0;
            position: absolute;
            transform: scale(0);
            transition-duration: 0.15s;
            transition-property: opacity, transform;
            transition-timing-function: ease-out;
            width: 0.7rem;
            background-color: rgba(black, 0.12);
        }
    }

    .checkbox-field__input {
        position: absolute;
        opacity: 0;
        body[modality="keyboard"] &:focus + .checkbox__checkmark {
            .checkbox__focus-ring {
                opacity: 1;
                transform: scale(1);
            }
        }
    }

</style>