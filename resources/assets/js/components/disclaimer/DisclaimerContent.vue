<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="disclaimer-content">
        <div v-if="activeStep === index"
             v-for="(page, index) in pages"
             :key="page.id" v-html="page"
             class="disclaimer-page__text-item">
        </div>

        <div class="disclaimer-page__text__bottom-stuff">
            <div class="indicators-wrap">
                <div v-for="(indicator, index) in pages.length"
                     :key="indicator.id"
                     class="indicator"
                     :class="activeStep === index ? 'indicator-current' : ''"></div>
            </div>
            <a class="btn-primary" href="#" @click="increaseactiveStep">{{ activeStep < pages.length - 1 ? $e('locale.next-button') : $e('locale.finished-button') }}</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'disclaimer-content',
        props: ['pages'],
        data () {
            return {
                activeStep: 0
            }
        },
        methods: {
            increaseactiveStep () {
                if (this.activeStep < this.pages.length - 1) {
                    this.activeStep ++
                } else {
                    axios.post(this.$url('/statements/disclaimer')).then((response) => {
                        window.location = response.data.redirect
                    })
                }
            }
        }
    }
</script>

<style lang="scss">
    @import "./../../../styles/colors";

    .disclaimer-content {
        .indicator-current {
            background-color: $main-color;
        }
    }
</style>