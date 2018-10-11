<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="model-field form-group">
        <label class="model-field__label">{{ data.label }}</label>
        <v-select :options="templates"
                  label="title"
                  :reset-on-options-change="true"
                  ref="templateselect"
                  v-model="selectedModelValue"
                  class="model-field__select">
            <template slot="no-options">
                {{ $e('locale.select-empty') }}
            </template>
        </v-select>
        <button class="btn-chevron" :disabled="selectedModelValue === null"
                @click="loadTemplate">{{ $e('locale.apply-model-button') }}</button><br  v-if="isAdmin" />
        <button class="btn-chevron" :disabled="selectedModelValue === null" v-if="isAdmin"
                @click="deleteTemplate">{{ $e('locale.delete-model-button') }}</button>
    </div>
</template>

<script>
    import vSelect from 'vue-select'

    export default {
        name: 'model-field',
        props: {
            data: {
                type: Object,
                required: true,
            },
            elements: {
                type: Array,
                required: true,
            },
        },
        components: {
            vSelect
        },
        data() {
            return {
                templates: [],
                selectedModelValue: null,
            }
        },
        mounted() {
            axios.get(this.$url('/statementtemplates/data')).then(response => {
                this.templates = response.data;
            });
        },
        methods: {
            loadTemplate: function () {
                if (this.selectedModelValue !== null) {
                    axios.get(this.$url('/statementtemplates/' + this.selectedModelValue.id + '/answers')).then(response => {
                        this.$emit('reload', response.data.answers);
                    });
                }
            },
            deleteTemplate: function () {
                if (this.selectedModelValue !== null) {
                    axios.delete(this.$url('/statementtemplates/' + this.selectedModelValue.id + '/delete')).then(response => {
                        _.remove(this.templates, {
                            id: this.selectedModelValue.id
                        });
                        this.$refs.templateselect.search = ' ';
                        this.selectedModelValue = null;
                        this.$refs.templateselect.search = '';
                    });
                }
            },
        },
        computed: {

            isAdmin: function () {
                return window.App.user.role === 'admin';
            },
        }
    }
</script>

<style lang="scss">
    .model-field {
        &__select {
            margin: 1rem 0;
        }
    }
</style>
