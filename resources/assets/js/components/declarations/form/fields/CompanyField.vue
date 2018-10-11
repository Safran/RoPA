<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="company-field form-group" :class="classes">
        <p class="company-field__label">{{ data.label }}</p>

        <v-select :data="data"
                  :options="companies"
                  label="name"
                  :disabled="readonly || disabled"
                  v-model="selectedCompanyValue"><template slot="no-options">
            {{ $e('locale.select-empty') }}
        </template></v-select>
    </div>
</template>

<script>
    import vSelect from 'vue-select'

    export default {
        name: 'company-field',
        props: {
            data: {
                type: Object,
                required: true
            },
            value: {
                required: true
            },
            elements: {
                type: Array,
                required: true,
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
        components: {
            vSelect
        },
        data() {
            return {
                companies: [],
                selectedValue: this.value,
                selectedCompanyValue: null,
                initialValue: this.value,
                disabled: false,
            }
        },
        computed: {
            companyid: function () {
                return window.App.user.company_id;
            },
            classes() {
                return [
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ]
            },

        },
        mounted() {
            axios.get(this.$url('/companies/data')).then(response => {
                this.companies = response.data;
                let selected = null,
                    searching = null;
                if((this.data.answer.value === undefined) || ! this.editMode)
                {
                    searching = undefined; //this.companyid;
                } else {
                    searching = this.data.answer.value;
                }
                this.selectedCompanyValue = searching;
                _.forEach(this.companies, function (company) {
                    if(company.id === searching)
                    {
                        selected = company;
                    }
                });
                this.selectedCompanyValue = selected;
            })
        },

        watch: {
            selectedValue() {
                this.$emit('input', this.selectedValue);
                this.$emit('change', this.selectedValue);
            },
            selectedCompanyValue() {
                this.selectedValue = this.selectedCompanyValue !== null ? this.selectedCompanyValue.id : null;
            },
            value() {
                this.selectedValue = this.value;
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/mixins';
    .company-field {
        .v-select .dropdown-toggle {
            padding-right: 2.5rem;
            width: 100%;
            height: 3rem;
            border: none;
            border-bottom: 0.1rem solid $grey;
            background-color: $white;
            font-family: 'Helvetica-thin-font', sans-serif;
            @include fontSize(14);
            -webkit-appearance: none;
            -webkit-border-radius: 0px;
            outline: none;
        }
    }
</style>
