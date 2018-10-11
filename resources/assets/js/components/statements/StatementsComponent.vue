<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div>
        <div class="filters-group">
            <div class="filters-group__item">
                <div class="form-group">
                    <label for="search">{{ $e('locale.search.label') }}</label>
                    <input v-model="search" id="search" :placeholder="$e('locale.search.placeholder')">
                </div>
            </div>
            <slot></slot>
        </div>
        <table class="statements-desktop" v-if="!getMobile && (filteredStatements.length > 0)">
            <tbody>
            <tr v-for="statement in filteredStatements" class="statements-desktop__row">
                <td>{{ statement.date }}</td>
                <td>{{ statement.main_country.name }}</td>
                <td>
                    <a :href="statement.link" class="bold">{{statement.name}}</a>
                </td>
                <td class="bold">{{statement.owner.full_name}} / {{statement.author.full_name}}</td>
                <td>
                    <progress-bar v-if="!statement.validated" :progress-value="statement.progress.global"></progress-bar>
                    <span v-else-if="statement.validated && !statement.archived" class="validated-text">{{ validatedText }}</span>
                    <span v-else class="archived-text">{{ archivedText }}</span>
                </td>
                <td class="action">
                    <a :href="statement.link" class="btn-more"></a>
                    <a :href="statement.duplicatelink" class="btn-duplicate" v-if="statement.duplicatelink"></a>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-if="getMobile && filteredStatements.length > 0"  class="statements-mobile__item" v-for="statement in filteredStatements">
            <div class="date">
                <p>{{ statement.date }}</p>
            </div>
            <div class="country">
                <p>{{ statement.main_country.name }}</p>
            </div>
            <div class="title">
                <p class="bold">{{ statement.name }}</p>
            </div>
            <div class="author">
                <p>{{ statement.owner.full_name }} / {{ statement.author.full_name }}</p>
            </div>
            <progress-bar v-if="!statement.validated" :progress-value="statement.progress.global"></progress-bar>
            <span v-else-if="statement.validated && !statement.archived" class="validated-text">{{ validatedText }}</span>
            <span v-else class="archived-text">{{ archivedText }}</span>
            <div class="action">
                <a :href="statement.link" class="btn-primary">{{ buttonText }}</a>
            </div>
        </div>
        <slot name="no-content" v-if="filteredStatements.length === 0"></slot>
    </div>
</template>

<script>
    import ProgressBar from '../general/ProgressBar'

    export default {
        name: 'statements-component',
        props: {
            data: {
                type: Array,
                required: true,
            },
            validatedText: String,
            archivedText: String,
            buttonText: String
        },
        components: {
            ProgressBar,
        },
        data () {
            return {
                search: '',
                statements: this.data,
            }
        },
        computed: {
            filteredStatements() {
                return this.statements.filter(statement => {
                    return statement.name.toLowerCase().includes(this.search.toLowerCase())
                        || statement.owner.full_name.toLowerCase().includes(this.search.toLowerCase())
                        || statement.author.full_name.toLowerCase().includes(this.search.toLowerCase())
                });
            }
        }
    }
</script>

<style lang="scss">
    @import "../../../styles/colors";
    @import "../../../styles/variables";
    @import "../../../styles/mixins";

    .filters-group {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;

        @include mobile {
            flex-direction: column;
            align-items: flex-start;
        }

        &__item {
            padding: 0 1rem;
            width: 100%;

            @include mobile {
                padding: 0;
            }

            &:first-of-type {
                padding-left: 0;
            }

            &:last-of-type {
                padding-right: 0;
                text-align: center;

                @include mobile {
                    margin-top: 1.5rem;
                    width: inherit;
                }
            }
        }

        &__small {
            width: 6rem;
        }
    }

    .statements-desktop {
        width: 100%;
        display: table;
        table-layout: auto;
        border-collapse: collapse;

        &__row {
            height: 4rem;
            border-bottom: 0.1rem solid $light-grey;
            transition: all .3s ease;

            &:last-of-type {
                border: none;
            }

            &:hover {
                background-color: $light-grey;
            }

            td {
                padding: 0 .6rem;
                display: table-cell;

                &:first-of-type {
                    padding-left: 0;
                }

                &:last-of-type {
                    padding-right: 0;
                }
            }

            .progress-wrap {
                margin: 0 auto;
                width: 15rem;
                height: 1.35rem;
            }

            .btn-more {
                margin: 0 auto;
                display: inline-block;
            }

            .btn-duplicate {
                position: relative;
                display: inline-block;
                width: 3rem;
                height: 3rem;
                border-radius: 3px;
                color: $white;
                background-color: $main-color;
                cursor: pointer;

                &::after {
                    content: '';
                    position: absolute;
                    display: inline-block;
                    width: 24px;
                    height: 24px;
                    top: 3px;
                    right: 3px;
                    background: url("../../../img/form/duplicate.png") 0 0 no-repeat;
                }

                &:hover {
                    color: $white;
                    opacity: .8;
                }
            }
        }
    }

    .statements-mobile__item {
        .progress-wrap {
            width: 100%;
            margin: .4rem 0;
        }

        .action {
            .btn-primary {
                display: block;
                margin-top: 1rem;
                padding-top: 0.6rem;
                padding-bottom: 0.6rem;
                width: 100%;
                text-align: center;
            }
        }
    }
</style>

