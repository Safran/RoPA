<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="text-field form-group" :class="classes">
        <label class="text-field__label" :for="data.name">{{ data.label }}</label>
        <div class="text-field__container">
            <input type="text"
                   class="text-field__input"
                   :id="data.name"
                   :name="data.name"
                   :disabled="disabled"
                   :readonly="readonly"
                   :placeholder="data.placeholder"
                   :required="data.field_required"
                   v-model="model"
                   @input="updateValue($event.target.value)"
                   @keydown.enter="onKeydownEnter"
                   @keydown="onKeydown"
                   @focus="onFocus"
                   @blur="onBlur"
            >

            <transition name="tips">
                <div class="text-field__tips-content" v-show="showTips" v-html="data.tips"></div>
            </transition>

            <div class="text-field__tips" v-if="data.tips">
                <img src="@/img/form/infos.svg"
                     :alt="$e('locale.infos_alt')"
                     class="text-field__tips-button"
                     @mouseover="tipsHover"
                     @mouseleave="tipsLeave">
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'text-field',
        props: {
            data: {
                required: true,
            },
            editMode: {
                type: Boolean,
                default: false,
            },
            value:
            {
                required:  true
            },
            elements: {
                type: Array,
                required: true,
            },
            readonly: {
                type: Boolean,
                default: false
            },
            invalid: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                isActive: false,
                isTouched: false,
                showTips: false,
                disabled: false,
                model: this.editMode ? this.data.answer.value : '',
            }
        },
        components: {

        },
        computed: {
            classes() {
                return [
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                    {'is-active': this.isActive},
                    {'is-invalid': this.invalid},
                    {'is-touched': this.isTouched},
                ]
            },
        },
        watch: {
            value() {
                this.model = this.value;
            }
        },
        methods: {
            tipsHover() {
                this.showTips = true;
            },
            tipsLeave() {
                this.showTips = false;
            },
            updateValue(value) {
                this.$emit('input', value);
            },
            onKeydown(e) {
                this.$emit('keydown', e);
            },
            onKeydownEnter(e) {
                this.$emit('keydown-enter', e);
            },
            onFocus(e) {
                this.isActive = true;
                this.$emit('focus', e);
            },
            onBlur(e) {
                this.isActive = false;
                this.$emit('blur', e);
                if (!this.isTouched) {
                    this.isTouched = true;
                    this.$emit('touch');
                }
            },
        }
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/variables';
    @import '../../../../../styles/mixins';
    @import '../../../../../styles/transitions/tips-transition';

    .text-field {
        &__container {
            position: relative;
            display: flex;

            .text-field__tips {
                display: flex;
                justify-content: flex-end;
                align-items: flex-start;
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
                    bottom: 0.8rem;
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
                        right: -0.75rem;
                        bottom: 0.5rem;
                        width: 0;
                        height: 0;
                        border-style: solid;
                        border-width: 5px 0 5px 8px;
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
