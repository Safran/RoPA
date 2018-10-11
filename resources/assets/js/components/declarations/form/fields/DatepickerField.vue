<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="datepicker-field form-group">
        <label class="text-group__label" :for="data.name">{{ data.label }}</label>
        <datepicker class="text-group__input"
               :id="data.name"
               ref="datepicker"
               :name="data.name"
               :language="locales[locale]"
               :disabled="disabled"
               :readonly="readonly"
               v-model="model"
               :required="data.field_required"
               @input="updateValue"></datepicker>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import {en, fr} from 'vuejs-datepicker/dist/locale';

    export default {
        name: 'datepicker-field',
        components: {
            Datepicker,
        },
        props: {
            data: {
                type: Object,
                required: true
            },
            editMode: {
                type: Boolean,
                default: false,
            },
            readonly: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                disabled: false,
                locale: window.App.locale,
                locales: {'en': en, 'fr': fr},
                model: this.editMode ? this.data.answer.value : '',
            }
        },
        mounted() {
            Date.prototype.toDateInputValue = (function () {
                let local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0, 10);
            });

            if (this.editMode) {
                if (this.data.answer.value) {
                    this.model = new Date(this.data.answer.value).toDateInputValue();
                } else {
                    this.model = '';
                }
            } else {
                if (this.data.special.default_to_now) {
                    this.model = new Date().toDateInputValue();
                } else {
                    this.model = '';
                }
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
            updateValue() {
                let value = new Date(this.model).toDateInputValue();
                this.$emit('input', value);
            },
        },
        watch: {
            value() {
                this.model = new Date(this.data.answer.value).toDateInputValue();
            },
        },
    }
</script>

<style lang="scss">
    .datepicker-field {
    }
</style>
