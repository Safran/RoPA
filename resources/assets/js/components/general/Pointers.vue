<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="indicators-wrap">
        <div class="indicator pointer indicator-validate"
             :class="[-1 === this.activeStep ? 'indicator-focus' : '']"
             v-if="progressValues['global'] === 100"
              @click="click(-1)" :key="-1"></div>
        <div class="indicator pointer"
             :class="classes(item, index)"
             v-for="(item, index) in data"
             v-model="progressValues"
             @click="click(index)"
             :key="item.id"></div>
    </div>
</template>

<script>
    export default {
        name: "Pointers",
        props: {
            data: {
                type: Array,
                required: true,
            },
            activeStep: {
                type: Number,
                required: true,
            },
            progressValues: {
                type: Object,
                required: false,
            }
        },
        mounted() {
            this.value = this.progressValues;
        },
        methods: {
            click(item) {
                this.$emit('click', {index: item});
            },
            classes(item, index) {
                return [index === this.activeStep ? 'indicator-focus' : '',
                    this.progressValues[item.id] === 100 ? 'indicator-validate' : ''];
            }
        },
        watch: {
            progressValues() {
                this.value = this.progressValues;
            },
        },
    }
</script>

<style scoped>

</style>