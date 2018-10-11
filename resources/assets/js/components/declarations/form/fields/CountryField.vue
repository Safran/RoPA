<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="country-field form-group" :class="classes">
        <p class="country-field__label">{{ data.label }}</p>
        <radio-field v-for="(input , index) in inputs"
                     :key="input.id"
                     :data="data"
                     :input="input"
                     :index="index"
                     :elements="elements"
                     :disabled="readonly || disabled"
                     :readonly="readonly"
                     v-model="selectedOptionValue"
                     :true-value="input.value"
                     :checked="isCheckedByDefault(input)"
        />
        <v-select :data="data"
                  :options="countries"
                  label="name"
                  :multiple="multiple"
                  :disabled="readonly || disabled"
                  :readonly="readonly"
                  v-model="selectedCountryValue"
                  v-show="selectIsShown">
            <template slot="no-options">
                {{ $e('locale.select-empty') }}
            </template>
        </v-select>
    </div>
</template>

<script>
    import RadioField from './RadioField'
    import vSelect from 'vue-select'

    export default {
        name: 'country-field',
        props: {
            value: {
                type: Number | Array,
                required: true
            },
            data: {
                type: Object,
                required: true
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
            RadioField,
            vSelect
        },
        data() {
            return {
                franceid: null,
                countries: [],
                disabled: false,
                selectedCountryValue: null,
                initialValue: this.value,
                selectedOptionValue: this.value,
                inputs: [
                    {
                        label: "France",
                        default: true,
                        value: 1,
                    },
                    {
                        label: "International",
                        default: false,
                        value: 0
                    }
                ],
            }
        },
        watch: {
            selectedCountryValue() {
                let value = parseInt(this.getValue());
                if(value != this.value)
                {
                    this.$emit('input', value);
                }
            },
            selectedOptionValue() {
                let value = parseInt(this.getValue());
                if(value != this.value)
                {
                   this.$emit('input',value);
                }
            },
            value() {
                this.setValue(this.data.answer.value);
            },
        },
        mounted() {
            axios.get(this.$url('/countries/data'), {
                params: {
                    eea: this.data.special.only_eea,
                    except_france: true,
                },
            }).then(response => {
                this.countries = response.data.data;
                this.franceid = response.data.meta.France;
                this.setValue(this.data.answer.value);
            });
        },
        computed: {
            selectIsShown() {
                return this.selectedOptionValue !== this.franceid;
            },
            multiple() {
                return this.data.special.multiple === "1";
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
                if (this.franceid !== null) {
                    if ((input.value === this.franceid)) {
                        return this.selectedOptionValue === this.franceid;
                    } else {
                        return this.selectedOptionValue !== this.franceid;
                    }
                }
                return false;
            },
            getValue() {
                let value = this.value;//data.answer.value;
                if (this.selectedOptionValue === this.franceid) {
                    value = this.franceid;
                } else {
                    if (!this.multiple) {
                        value = this.selectedCountryValue !== null && this.selectedCountryValue.id !== undefined ? this.selectedCountryValue.id : value;
                    } else {
                        value = [];
                        _.forEach(this.selectedCountryValue, function (country) {
                            value.push(country.id);
                        });
                    }
                }
                return value;
            },
            setValue(value) {
                let selected = null,
                    multiple = this.multiple;
                if (value != this.franceid) {
                    if (this.multiple) {
                        selected = [];
                    }
                    _.forEach(this.countries, function (country) {
                        if (multiple) {
                            if (_.find(value, function (s) {
                                return s === country.id
                            })) {
                                selected.push(country);
                            }
                        } else {
                            if (country.id === value) {
                                selected = country;
                            }
                        }
                    });
                    this.selectedCountryValue = selected;
                    this.inputs[0].value = this.franceid;
                    this.selectedOptionValue = 0;
                } else {
                    this.inputs[0].value = this.franceid;
                    this.selectedOptionValue = this.franceid;
                    this.initialValue = this.franceid;
                }
            }
        },
    }
</script>

<style lang="scss">
    .country-field {
    }
</style>
