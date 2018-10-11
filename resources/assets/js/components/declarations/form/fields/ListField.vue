<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="list-field form-group" :class="classes">
        <label class="list-field__label" :for="data.name">{{ data.label }}</label>
        <ul class="list-field-list">
            <li class="list-field-item" v-for="element in data.answer.value">
                <span class="list-field-item__text">{{ element }}</span>
                <span @click="deleteElement(element)" class="list-field-item__meta list-field-item__action">
                    <img src="./../../../../../img/form/trash.svg" :alt="$e('locale.delete-element-button')" />
                </span>
            </li>
        </ul>
        <div class="list-field-add">
            <form action="#" @submit.prevent="createElement()">
                <input v-model="element" type="text" name="element" class="form-control" autofocus>
                <button type="submit" :disabled="element.length === 0" class="btn-chevron">{{
                    $e('locale.create-element-list-button')}}
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'list-field',
        props: {
            data: {
                required: true,
            },
            editMode: {
                type: Boolean,
                default: false,
            },
            elements: {
                type: Array,
                required: true,
            },
            readonly: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                disabled: false,
                element: '',
            }
        },
        components: {},
        computed: {
            classes() {
                return [
                    {'is-disabled': this.disabled},
                    {'is-readonly': this.readonly},
                ]
            },
        },
        methods: {
            createElement: function () {
                let el = this.element;
                this.data.answer.value.push(el);
                this.element = '';
            },
            deleteElement: function (val) {
                this.data.answer.value = this.data.answer.value.filter(function (el) {
                    return el !== val;
                });
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../../styles/colors';
    @import '../../../../../styles/variables';
    @import '../../../../../styles/mixins';

    .list-field {
    }

    .list-field__label {
        margin-bottom: 5px;
    }

    .list-field-add {
        margin-top: 10px;
    }

    .list-field-add form {
        display: flex;
        width: calc(100% - 16.5rem);
    }

    .list-field-add input {
        margin-right: 3rem;
    }

    .list-field-add button {
        padding: 0;
        position: relative;
        border: none;
    }

    $mdc-list-divider-color-on-light-bg: rgba(0, 0, 0, .12) !default;
    $mdc-list-divider-color-on-dark-bg: rgba(255, 255, 255, .2) !default;
    $mdc-list-side-padding: 16px;
    $mdc-list-text-offset: 72px;

    ul.list-field-list {
        max-width: 600px;
        border: 1px solid rgba(0, 0, 0, .1);
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        font-size: 1rem;
        font-weight: 400;
        letter-spacing: .00937em;
        text-decoration: inherit;
        text-transform: inherit;
        color: $black;
        margin: 0;
        padding: 8px 0;
        line-height: 1.5rem;
        list-style-type: none;
    }

    .list-field-item {
        display: flex;
        position: relative;
        align-items: center;
        justify-content: flex-start;
        height: 48px;
        padding: 0 16px;
        overflow: hidden;
        border-bottom: 1px solid #f1f1f1;

        &:focus {
            outline: none;
        }
    }

    .list-field-item--selected,
    .list-field-item--activated {
        color: $main-color;
    }

    .list-field-item__text {
        display: block;
    }

    .list-field-item__meta {
        margin-left: auto;
        margin-right: 0;
    }

    .list-field-item__action {
        cursor: pointer;
        width: 1rem;
        height: 1rem;
        transition: all .3s ease;

        &:hover {
            transform: scale(1.2)
        }
    }
</style>
