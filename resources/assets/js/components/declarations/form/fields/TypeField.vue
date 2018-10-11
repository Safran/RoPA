<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="type-field form-group">
        <p class="type-field__label">{{ data.label }}</p>
        <radio-field
                v-for="(input , index) in inputs"
                :key="input.id"
                :data="data"
                :input="input"
                :index="index"
                :disabled="disabled"
                :readonly="readonly"
                v-model="data.answer.value"
                :true-value="input.value"
                :checked="isCheckedByDefault(input)"
        />
        <p class="type-field__label" v-show="textInputIsShown">{{ $e('locale.customer.label') }}</p>
        <input type="text"
               v-model="internalValue"
               :disabled="disabled || readonly"
               :placeholder="$e('locale.customer.placeholder')"
               v-show="textInputIsShown" />
    </div>
</template>

<script>
    import RadioField from './RadioField'

    export default {
        name: 'type-field',
        props: {
            data: {
                type: Object,
                required: true,
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
        },
        components: {
            RadioField
        },
        data() {
            return {
                initialValue: this.value,
                internalValue: this.value,
                disabled: false,
                inputs: [
                    {
                        label: this.$e('locale.customer.safran-label'),
                        default: true,
                        value: "company"
                    },
                    {
                        label: this.$e('locale.customer.customer-label'),
                        default: false,
                        value: ""
                    }
                ],
            }
        },
        watch: {
            internalValue() {
                this.$emit('input', this.internalValue);
                this.$emit('change', this.internalValue);
            },
            value() {
                this.internalValue = this.value;
                if(this.value !== "company")
                {
                    this.inputs[1].value = this.value;
                } else {
                    this.inputs[1].value = "";
                }
            },
        },
        mounted() {
            if(this.value !== "company")
            {
                this.inputs[1].value = this.value;
            } else {
                this.inputs[1].value = "";
            }
        },
        computed: {
            textInputIsShown() {
                return this.internalValue !== "company";
            },
            classes() {
                return [
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ]
            },
        },
        methods: {
            isCheckedByDefault(input) {
                return this.initialValue == input.value ||
                    (this.initialValue == "" && input.default);
            },
        }
    }
</script>
