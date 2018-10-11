<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <declarations-form :formItems="formItems" v-if="formItems !== null" @reload="reload"></declarations-form>
</template>

<script>
    import DeclarationsForm from './form/DeclarationsForm'

    export default {
        name: 'new-declaration',
        props: ['url'],
        data() {
            return {
                formItems: null,
            }
        },
        components: {
            DeclarationsForm
        },
        mounted() {
            axios.get(this.url).then(response => this.formItems = response.data.pages)
        },
        methods: {
            reload(items) {
                let formItems = this.formItems;

                _.forEach(items, function (answer) {
                    _.forEach(formItems, function (page) {
                        let element = _.find(page.elements, function (element) {
                            return element.id === answer.element.id;
                        });
                        if (element !== undefined && answer.answer !== null && answer.answer !== undefined) {
                           element.answer.value = answer.answer;
                        }
                    });
                });
            },
        }
    }
</script>

<style scoped>

</style>