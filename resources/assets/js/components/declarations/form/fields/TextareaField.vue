<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="textarea-field form-group" :class="classes">
        <p class="username-group__label">{{ data.label }}</p>
        <div class="textarea-field__container">
        <textarea :name="data.name"
                  :id="data.name"
                  :disabled="disabled"
                  :readonly="readonly"
                  :placeholder="data.placeholder"
                  :required="data.field_required"
                  @input="updateValue($event.target.value)"
                  @keydown.enter="onKeydownEnter"
                  @keydown="onKeydown"
                  @blur="onBlur"
                  @change="onChange"
                  @focus="onFocus"
                  v-model="model"
        ></textarea>
            <transition name="tips">
                <div class="textarea-field__tips-content" v-show="showTips" v-html="data.tips"></div>
            </transition>

            <div class="textarea-field__tips" v-if="data.tips">
                <img src="@/img/form/infos.svg"
                     :alt="$e('locale.infos_alt')"
                     class="textarea-field__tips-button"
                     @mouseover="tipsHover"
                     @mouseleave="tipsLeave">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'textarea-field',
        props: {
            data: {
                required: true,
            },
            editMode: {
                type: Boolean,
                default: false,
            },
            elements: {
                type: Array,
                required: true,
            },
            readonly: {
                type: Boolean,
                default: false
            },
            value:
            {
                required: true
            },
            invalid: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                showTips: false,
                disabled: false,
                isActive: false,
                isTouched: false,
                model: this.editMode ? this.data.answer.value : '',
            }
        },
        created() {
            if (this.value === null) {
                this.updateValue('');
            }
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
            onChange(e) {
                this.$emit('change', this.value, e);
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

    .textarea-field {
        &__container {
            position: relative;
            display: flex;

            .textarea-field__tips {
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
            textarea {
                margin-top: 1rem;
                width: 100%;
                height: 10rem;
                resize: none;
                border: none;
                border-bottom: 0.1rem solid $grey;
                font-family: 'Helvetica-thin-font', sans-serif;
                @include fontSize(14);
                outline: none;

                &:focus {
                    border-bottom-color: $purple;
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
