<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="progress-wrap">
        <div class="progress-bar" ref="progressBar"></div>
    </div>
</template>

<script>
    import TweenMax from 'gsap';

    export default {
        name: 'progress-bar',
        props: {
            progressValue: {
                type: [Number, String],
                required: true
            },
            showValue: {
                type: Boolean,
                default: false,
            },
        },
        mounted() {
            this.setValue(this.progressValue);
        },
        watch: {
            progressValue() {
                this.setValue(this.progressValue);
            }
        },
        methods: {
            setValue(value) {
                this.$nextTick(() => {
                    if (this.$refs.progressBar) {
                           TweenMax.to(this.$refs.progressBar, 1.3, {width: `${value}%`})
                    }
                })
            }
        },
        computed: {
            progress() {
                return Math.ceil(this.progressValue) + ' %';
            }
        },
    }
</script>

<style lang="scss">

    @import './../../../styles/colors';
    @import './../../../styles/mixins';
    @import './../../../styles/variables';

    .progress-wrap {
        width: 100%;
        height: 1.1rem;
        background-color: $pb-wrap-color;
    }

    .progress-bar {
        width: 0;
        height: 100%;
        background-color: $green;
    }
</style>
