<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="radiogroup-field form-group" :class="classes">
        <div class="radiogroup-field__container">
            <p v-if="data.label" class="radiogroup-field__label">{{ data.label }}</p>
            <transition name="tips">
                <div class="radiogroup-field__tips-content" v-show="showTips" v-html="data.tips"></div>
            </transition>

            <div class="radiogroup-field__tips" v-if="data.tips">
                <img src="@/img/form/infos.svg"
                     :alt="$e('locale.infos_alt')"
                     class="radiogroup-field__tips-button"
                     @mouseover="tipsHover"
                     @mouseleave="tipsLeave">
            </div>
        </div>
        <radio-field
                v-model="selectedValue"
                v-for="(input , index) in data.special"
                :key="input.id"
                :data="data"
                :input="input"
                :index="index"
                :disabled="disabled"
                :readonly="readonly"
                :true-value="input.value"
                :checked="isCheckedByDefault(input)"
        >{{ input.label }}
        </radio-field>
    </div>
</template>

<script>
    import RadioField from './RadioField'

    export default {
        name: 'radiogroup-field',
        props: {
            data:
                {
                    type: Object,
                    required: true
                },
            value:
                {
                    required:  true
                },
            error: String,
            elements: Array,
            invalid: {
                type: Boolean,
                default: false
            },
            readonly: {
                type: Boolean,
                default: false
            },
        },
        components: {
            RadioField
        },
        data() {
            return {
                isActive: false,
                initialValue: this.value,
                selectedValue: this.value,
                disabled: false,
                showTips: false,
            };
        },
        watch: {
            selectedValue() {
                this.$emit('input', this.selectedValue);
                this.$emit('change', this.selectedValue);
            },
            value() {
                this.selectedValue = this.value;
            }
        },
        computed: {
            classes() {
                return [
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ]
            },
        },
        methods: {
            reset() {
                this.$emit('input', this.initialValue);
            },
            isCheckedByDefault(input) {
                return this.initialValue == input.value ||
                    (this.initialValue == "" && input.default);
            },
            tipsHover() {
                this.showTips = true;
            },
            tipsLeave() {
                this.showTips = false;
            },
        },

    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/variables';
    @import '../../../../../styles/mixins';
    @import '../../../../../styles/transitions/tips-transition';

    .radiogroup-field {
        &__container {
            position: relative;
            display: flex;

            .radiogroup-field__tips {
                display: flex;
                justify-content: flex-end;
                align-items: flex-end;
                width: 4rem;

                &-button {
                    $button-size: 2.2rem;
                    cursor: pointer;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-right: 0.2rem;
                    width: $button-size;
                    height: $button-size;
                }

                &-content {
                    position: absolute;
                    right: 3.8rem;
                    bottom: 2.8rem;
                    padding: 0.5rem 1.5rem;
                    max-width: 28rem;
                    transition: all .3s ease;
                    border-radius: 3px;
                    background-color: $main-color;
                    color: $white;
                    @include fontSize(10);

                    &::after {
                        content: '';
                        position: absolute;
                        right: 0.5rem;
                        top: 0.5rem;
                        width: 0;
                        height: 0;
                        border-style: solid;
                        border-width: 0 5px 5px 8px;
                        border-color: transparent transparent transparent $main-color;
                    }
                }
            }
        }
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
