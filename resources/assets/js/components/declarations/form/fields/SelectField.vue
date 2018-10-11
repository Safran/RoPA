<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="select-field">
        <select :id="data.name" v-model="value" :input="onChange">
            <option v-for="option in options"
                    :key="option.id"
                    :value="option.id"
                    :selected="isOptionSelected(option.id)"

            >{{ option.name }}
            </option>
        </select>
    </div>
</template>

<script>
    import {looseEqual} from "../../../../plugins/utils";

    export default {
        name: 'select-field',
        props: {
            data: {
                type: Object,
                required: true,
            },
            options: {
                type: Array,
            },
            value: {
                required:true
            },
        },
        methods: {
            isOptionSelected(id) {
                return looseEqual(this.value, id);
            },
            onChange: function() {
                this.$emit('input',  this.value);
            },
        },
        watch: {
            value()
            {
                this.$emit('change', this.value);
                this.$emit('selected', this.value);
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/mixins';

    .select-field {
        position: relative;

        select {
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

        &::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 1.5rem;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-color: transparent transparent transparent $grey;
        }
    }

</style>
