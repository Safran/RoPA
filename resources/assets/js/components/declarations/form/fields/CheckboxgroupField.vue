<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="checkboxgroup-field form-group" :class="classes">
        <div class="checkboxgroup-field__container">
        <p v-if="data.label" class="checkboxgroup-field__label">{{ data.label }}</p>

        <transition name="tips">
            <div class="checkboxgroup-field__tips-content" v-show="showTips" v-html="data.tips"></div>
        </transition>

        <div class="checkboxgroup-field__tips" v-if="data.tips">
            <img src="@/img/form/infos.svg"
                 :alt="$e('locale.infos_alt')"
                 class="checkboxgroup-field__tips-button"
                 @mouseover="tipsHover"
                 @mouseleave="tipsLeave">
        </div>
    </div>

        <checkbox-field
                v-for="(input , index) in data.special"
                v-model="checkboxValues[index]"
                :key="input.id"
                :data="data"
                :input="input"
                :index="index"
                :ref="input.value"
                :disabled="readonly || disabled"
                :readonly="readonly"
                :checked="isCheckedByDefault(input)"
                @change="onChange(arguments, input)"
        >

        </checkbox-field>
    </div>
</template>

<script>
    import CheckboxField from './CheckboxField'
    import {looseEqual, looseIndexOf} from "../../../../plugins/utils";

    export default {
        name: 'checkboxgroup-field',
        props: {
            data:
                {
                    type: Object,
                    required: true
                },
            value: {
                type: Array,
                required: true
            },

            elements: {
                type: Array,
                required: true,
            },
            error: String,
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
            CheckboxField
        },
        data() {
            return {
                ignoreChange: false,
                checkboxValues: [],
                initialValue: JSON.parse(JSON.stringify(this.value)),
                disabled: false,
                showTips: false,
            };
        },
        watch: {
            value() {
                let value = this.value;
                _.forEach(this.$refs, function(child)
                {
                    let index = child[0].input.value,
                    actual = child[0].value;
                    let newvalue  = (looseIndexOf(value, index) >= 0);
                    // console.log("old value[" + actual + "] to new value[" + newvalue + "]");
                    if(!looseEqual(newvalue, actual))
                    {
                        // console.log("swaping");
                        child[0].$emit('input', newvalue);
                    }
                });
            },
        },
        methods: {
            isCheckedByDefault(input) {
                return looseIndexOf(this.initialValue, input.value) > -1;
            },
            onChange(args, input) {
                if (this.ignoreChange) {
                    return;
                }
                const checked = args[0];
                const e = args[1];
                let value = [];
                const inputValue = input.value;
                const i = looseIndexOf(this.value, inputValue);
                if (checked && i < 0) {
                    value = this.value.concat(inputValue);
                }
                if (!checked && i > -1) {
                    value = this.value.slice(0, i).concat(this.value.slice(i + 1));
                }
                this.$emit('input', value);
                this.$emit('change', value, e);
            },
            tipsHover() {
                this.showTips = true;
            },
            tipsLeave() {
                this.showTips = false;
            },
        },
        computed: {
            classes() {
                return [
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ]
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/variables';
    @import '../../../../../styles/mixins';
    @import '../../../../../styles/transitions/tips-transition';

    .checkboxgroup-field {
        &__container {
            position: relative;
            display: flex;

            .checkboxgroup-field__tips {
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
                        bottom: -0.5rem;
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
