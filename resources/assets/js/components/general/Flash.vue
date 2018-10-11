<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div :class="classes" v-show="show" v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: this.message,
                level: 'success',
                show: false
            }
        },
        computed: {
            classes() {
                let defaults = ['alert', 'flash'];
                if (this.level === 'success') defaults.push('alert-success');
                if (this.level === 'warning') defaults.push('alert-warning');
                if (this.level === 'danger') defaults.push('alert-danger');
                return defaults;
            }
        },
        created() {
            if (this.message) {
                this.flash();
            }
            window.events.$on(
                'flash',
                data => this.flash(data)
            );
        },
        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message;
                    this.level = data.level;
                }
                this.show = true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 6000);
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import './../../../styles/_variables';
    @import './../../../styles/_colors';
    @import './../../../styles/_mixins';

    .flash {
        position: relative;
        z-index: 1;
        border: none;
        text-align: center;
        width: 500px;
        top: 15rem;
        margin: 0 auto;
        border-left: 3px solid transparent;
    }

    .alert-success {
        color: $white;
        background-color: $green;
        border-color: $darker-green;
    }

    .alert-warning {
        color: $white;
        background-color: $purple;
        border-color: $darker-purple;
    }

    .alert-danger {
        color: $white;
        background-color: $red;
        border-color: $darker-red;
    }
</style>