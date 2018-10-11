<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="validation-switch" :class="classes" @click="toggleIsValidate">
        <img src="@/img/form/validation-switch/unlock.svg" v-if="isValidate" :alt="$e('locale.valid_title')">
        <img src="@/img/form/validation-switch/lock.svg" v-if="!isValidate" :alt="$e('locale.invalid_title')">

        <span class="validation-switch__cursor"></span>
    </div>
</template>

<script>
    export default {
        name: "validation-switch",
        props: {
            value: {
                required: true
            },
            disabled: {
                type: Boolean,
                default: false
            },
            supervisable: {
                type: Boolean,
                default: false,
            },
            readonly: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                isValidate: this.value !== null,
            };
        },
        computed: {
            classes() {
                return [
                    {'is-disabled': this.disabled || this.$parent.data.answer.id === false},
                    {'is-valid': this.value !== null},
                    {'is-readonly': this.readonly},
                    {'is-supervisable': this.supervisable}
                ];
            },
        },
        watch: {
            value() {
                this.isValidate = this.value !== null;
            }
        },
        created() {
            this.$emit('input', this.value);
        },
        methods: {
            toggleIsValidate (e) {
                if( !this.disabled && !this.readonly  &&
                    (window.App.user.role === 'admin' ||
                    (window.App.user.role === 'lawyer' && !this.readonly))
                )
                {
                    axios.put(this.$url('/answers/' + this.$parent.data.answer.id),
                        {valide:(this.value === null)}).then(response => {
                        this.isValidate = !this.isValidate;
                        this.$emit('updateprogress', response.data.data.progress);
                        if(response.data.meta.needRefresh)
                        {
                            this.$emit('refresh');
                        }
                        this.$emit('input', response.data.data.validated_at ? response.data.data.validated_at.date : null);
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                        flash(this.errors);
                    });
                }
            },
        },
    }
</script>

<style lang="scss">
    @import '../../../../styles/colors';
    @import '../../../../styles/variables';
    @import '../../../../styles/mixins';
    @import '../../../../styles/transitions/fade-transition';

    .validation-switch {
        position: relative;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 0 1rem;
        width: 6rem;
        min-width: 6rem;
        height: 2.5rem;
        border-radius: 1.5rem;
        background-color: $main-color;
        cursor: pointer;
        transition: all .3s ease;

        @include mobile {
            margin-right: 1rem;
        }

        &__cursor {
            position: absolute;
            top: 50%;
            left: .5rem;
            transform: translateY(-50%);
            transition: all .3s ease;
            width: 1.8rem;
            height: 70%;
            border-radius: 50%;
            background-color: $white;
        }

    }

    .validation-switch.is-readonly.is-supervisable {
        background-color: $red;
        cursor: not-allowed;
    }
    .validation-switch.is-readonly {
        cursor: not-allowed;
    }

    .is-valid {
        justify-content: flex-start;
        background-color: $grey;

        & span {
            left: calc(100% - 2.3rem);
        }
    }

</style>