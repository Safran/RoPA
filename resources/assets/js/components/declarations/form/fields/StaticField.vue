<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="static-field form-group" v-html="data.special"></div>
</template>

<script>
    export default {
        name: 'static-field',
        props: {
            data: {
                required: true,
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/variables';
    @import '../../../../../styles/mixins';
    @import '../../../../../styles/transitions/tips-transition';

    .declarations-form  .form-group__edit.static-field    {
        margin-left: 9rem;
    }
</style>