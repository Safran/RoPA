<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="username-field form-group" :class="classes">
        <label class="username-field__label" :for="data.name">{{ data.label }}</label>

        <v-select :data="data"
                  :options="users"
                  label="name"
                  :filterable="false"
                  @search="onSearch"
                  :disabled="disabled || readonly"
                  v-model="selectedUsernameValue">
            <template slot="no-options">
                {{ $e('locale.select-empty') }}
            </template>
            <template slot="option" slot-scope="option">
                <div class="d-center">
                    {{ option.name }}
                </div>
            </template>
            <template slot="selected-option" slot-scope="option">
                <div class="selected d-center">
                    {{ option.name }}
                </div>
            </template>
        </v-select>
    </div>
</template>

<script>
    import vSelect from 'vue-select'

    export default {
        name: 'username-field',
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
            readonly: {
                type: Boolean,
                default: false
            },
            editMode: {
                type: Boolean,
                default: false,
            }
        },
        components: {
            vSelect
        },
        data() {
            return {
                users: [],
                selectedValue: this.value,
                selectedUsernameValue: null,
                initialValue: this.value,
                disabled: false,
            }
        },
        computed: {
            userid: function () {
                return window.App.user.id;
            },
            classes() {
                return [
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ]
            },
        },
        mounted() {
            axios.get(this.$url('/users/search') + '?i='+ this.value).then(response => {
                this.users = response.data;
                let selected = null,
                    searching = null;
                if ((this.data.answer.value === undefined) || !this.editMode) {
                    searching = this.userid;
                } else {
                    searching = this.data.answer.value;
                }
                this.selectedUsernameValue = searching;
                _.forEach(this.users, function (user) {
                    if (user.id === searching) {
                        selected = user;
                    }
                });
                this.selectedUsernameValue = selected;
            });

        },
        methods: {
            onSearch(search, loading) {
                loading(true);
                this.search(loading, search, this);
            },
            search: _.debounce((loading, search, vm) => {
                axios.get(vm.$url('/users/search') + '?q='+ `${escape(search)}`).then(response => {
                    vm.users = response.data;
                    loading(false);
                });
            }, 350)
        },
        watch: {
            selectedValue() {
                this.$emit('input', this.selectedValue);
            },
            selectedUsernameValue() {
                this.selectedValue = this.selectedUsernameValue !== null ? this.selectedUsernameValue.id : null;
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

    .username-field {
        .d-center {
            display: flex;
            align-items: center;
        }
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
