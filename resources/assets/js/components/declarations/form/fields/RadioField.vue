<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="radio-field" :class="classes">
        <input
                type="radio"
                :checked="isChecked"

                :id="`${data.name}-${index}`"
                :name="data.name"
                :value="trueValue"
                :disabled="disabled || readonly"
                @change="onChange"
                @click="toggleCheck"
        />
        <label class="radio-group__labelsingle" :for="`${data.name}-${index}`">{{ input.label }}</label>
    </div>
</template>

<script>
    export default {
        name: 'radio-field',
        props: {
            data: {
                type: Object,
                required: true,
            },
            input: {
                type: Object,
                required: true,
            },
            index: Number,
            value: {
                required: true,
            },
            trueValue: {
                type: [Number, String],
                required: true,
            },
            checked: {
                type: Boolean,
                default: false,
            },
            readonly: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                initialValue: this.value,
                disabled: false,
            }
        },
        computed: {
            isChecked() {
                return /** TODO:check (String(this.value).length > 0) && */(this.value == this.input.value);
            },
            classes() {
                return [
                    {'is-checked': this.isChecked},
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ];
            },
        },
        created() {
            if (this.checked) {
                this.$emit('input', this.input.value);
            }
        },
        methods: {
            toggleCheck() {
                if(!this.readonly && !this.disabled)
                {
                    this.$emit('input', this.input.value);
                }
            },
            onChange(e) {
                if(!this.readonly && !this.disabled)
                {
                    this.$emit('change', this.isChecked, e);
                }
            }
        }

    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/mixins';

    .radio-field {
        display: flex;
        justify-content: flex-start;
        align-items: center;

        &:first-of-type {
            margin-top: 0.6rem;
        }

        input[type='radio'] {
            display: none;

            &:not(:checked) + label:before,
            &:checked + label:before {
                content: '';
                position: absolute;
                left: 0;
                top: 1.5rem;
                transform: translateY(-50%);
                width: 1.7rem;
                height: 1.7rem;
                border: 0.2rem solid $main-color;
                border-radius: 50%;
            }

            &:not(:checked) + label:after,
            &:checked + label:after {
                content: '';
                position: absolute;
                top: 1rem;
                left: 0.5rem;
                width: 1.1rem;
                height: 1.1rem;
                border-radius: 50%;
                background-color: $main-color;
                transition: all .2s;
            }

            &:not(:checked) + label:after {
                opacity: 0;
                transform: scale(0);
            }

            &:checked + label:after {
                opacity: 1;
                transform: scale(1);
            }
        }

        label {
            position: relative;
            padding-left: 3.2rem;
            line-height: 3rem;
            @include fontSize(14);
            cursor: pointer;
        }
    }
</style>
