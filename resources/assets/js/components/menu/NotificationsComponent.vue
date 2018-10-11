<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="notifications">
        <div class="notifications-bell" @click="toggleDropdown">
            <img src="../../../img/menu/bell.svg" :alt="$e('locale.bell_alt')">
            <span class="badge badge-pill badge-danger up" v-if="notifs.length > 0">{{ notifs.length }}</span>
        </div>

        <transition name="fade">
            <div class="notifications-dropdown" v-if="showDropdown && !getMobile" v-click-outside="hideDropdown">
                <div class="notifications-dropdown__wrapper">
                    <transition-group name="fade" mode="out-in" v-if="notifs.length > 0">
                        <div class="notifications-dropdown__item" v-for="(notification, index) in notifs" :key="notification.id">
                            <div class="cross" @click="markAsRead(index, notification.id)">
                                <span class="cross__line-1"></span>
                                <span class="cross__line-2"></span>
                            </div>
                            <span>{{ notification.date }}</span>
                            <p class="bold" @click="showNotification(index, notification.id, notification.link)">{{ notification.title }}</p>
                        </div>
                    </transition-group>
                    <div class="notifications-dropdown__item" v-else>
                        <p class="bold">{{ $e('locale.no-notification') }}</p>
                    </div>
                </div>
            </div>

            <div class="notifications-dropdown notifications-dropdown__mobile" v-if="showDropdown && getMobile" v-click-outside="hideDropdown">
                <div class="notifications-dropdown__wrapper notifications-dropdown__wrapper__mobile">
                    <transition-group name="fade" mode="out-in" v-if="notifs.length > 0">
                        <div class="notifications-dropdown__item" v-for="(notification, index) in notifs" :key="notification.id">
                            <div class="cross" @click="markAsRead(index, notification.id)">
                                <span class="cross__line-1"></span>
                                <span class="cross__line-2"></span>
                            </div>
                            <span>{{ notification.date }}</span>
                            <p class="bold" @click="showNotification(index, notification.id, notification.link)">{{ notification.title }}</p>
                        </div>
                    </transition-group>
                    <div class="notifications-dropdown__item" v-else>
                        <p class="bold">{{ $e('locale.no-notification') }}</p>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'notifications-component',
        props: ['notifications'],
        data () {
            return {
                showDropdown: false,
                notifs: this.notifications,
                canClick: true
            }
        },
        methods: {
            toggleDropdown () {
                this.showDropdown = !this.showDropdown
            },
            hideDropdown () {
                this.showDropdown = false
            },
            showNotification (index, id, link) {
                if (this.canClick) {
                    this.canClick = false;
                    axios.put('/notifications/' + id)
                        .then(() => {
                            if (link) {
                                window.location.href = link
                            } else {
                                this.deleteNotification(index);
                                this.canClick = true
                            }
                        })
                }
            },
            markAsRead (index, id) {
                if (this.canClick) {
                    this.canClick = false;
                    axios.put('/notifications/' + id)
                        .then(() => {
                            this.deleteNotification(index);
                            this.canClick = true
                        })
                }
            },
            deleteNotification (index) {
                this.$delete(this.notifs, index)
            }
        }
    }
</script>

<style lang="scss">
    @import "./../../../styles/transitions/fade-transition";
    @import "./../../../styles/colors";

    .notifications {
        position: relative;
        letter-spacing: 0;

        &-bell {
            cursor: pointer;
        }

        &-dropdown {
            z-index: 999;
            position: absolute;
            top: 5.6rem;
            right: -2rem;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.09);
            border: 0.1rem solid $lighter-main-color;

            &__mobile {
                top: 5.4rem;
            }

            &:after, &:before {
                bottom: 100%;
                left: calc(100% - 4.4rem);
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
            }

            &:after {
                border-color: rgba(136, 183, 213, 0);
                border-bottom-color: $white;
                border-width: 15px;
                margin-left: -15px;
            }
            &:before {
                border-color: rgba(194, 225, 245, 0);
                border-bottom-color: $main-color;
                border-width: 16px;
                margin-left: -16px;
            }

            &__mobile {
                width: 100vw;
                right: -2.5rem;
                border-right: none;
                border-left: none;
                border-bottom: none;
            }

            &__wrapper {
                padding: 2.4rem;
                width: 33rem;
                height: 100%;
                overflow-y: auto;
                max-height: 35rem;

                &__mobile {
                    width: 100%;
                    max-height: inherit;
                    height: calc(100vh - 11.2rem);
                }
            }

            &__item {
                position: relative;
                padding: 0.2rem 1rem;
                margin: 0 0 3rem;
                border-left: 0.3rem solid $main-color;
                word-break: break-word;
                font-family: 'Helvetica-thin-font', sans-serif;
                transition: all .3s ease;

                &::after {
                    content: '';
                    position: absolute;
                    bottom: -1.4rem;
                    width: 96%;
                    height: 0.1rem;
                    background-color: $grey;
                }

                &:last-of-type {
                    margin-bottom: 0;
                    &::after {
                        display: none;
                    }
                }

                .cross {
                    position: absolute;
                    top: -0.4rem;
                    right: 0;
                    padding: 0.4rem;
                    width: 2.5rem;
                    height: 2.5rem;
                    cursor: pointer;

                    &__line-1, &__line-2 {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%) rotate(-45deg);
                        width: 55%;
                        height: 0.1rem;
                        background-color: $black;
                    }

                    &__line-2 {
                        transform: translate(-50%, -50%) rotate(45deg);
                    }
                }

                span, p {
                    color: $text-color;
                }

                span {
                    margin-bottom: 0.3rem;
                }

                p {
                    text-transform: none;
                    cursor: pointer;
                }
            }
        }
    }
</style>