<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
    <div class="header-menu" :class="enableShadow ? 'shadow' : ''">
        <div class="header-menu__content header-menu__mobile">
            <div class="header-menu__mobile__cross" :class="showMenu ? 'header-menu__mobile__cross-focus' : ''" @click="toggleMenu">
                <span class="line-1"></span>
                <span class="line-2"></span>
                <span class="line-3"></span>
            </div>

            <a :href="$url('/')">
                <img class="logo" src="../../../img/general/logo.svg"
                     :alt="$e('locale.logo_alt')">
            </a>

            <notifications-component :notifications="notifications"></notifications-component>
        </div>

        <transition name="menu-mobile">
            <div class="mobile-overlay" v-if="showMenu">
                <img class="cloud cloud-1 cloud-s" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
                <img class="cloud cloud-2 cloud-xs" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
                <img class="cloud cloud-3 cloud-m" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">


                <slot></slot>

                <div class="mobile-overlay__bottom">
                    <a :href="logoutLink" class="logout-link">
                        <img src="../../../img/menu/logout.svg" :alt="$e('locale.logout_alt')">
                        <span>Déconnexion</span>
                    </a>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import NotificationComponent from './NotificationsComponent'

    export default {
        name: 'menu-mobile',
        props: ['enableShadow', 'notifications', 'logoutLink'],
        components: {
            NotificationComponent
        },
        data () {
            return {
                showMenu: false
            }
        },
        methods: {
            toggleMenu () {
                return this.showMenu = !this.showMenu
            }
        }
    }
</script>

<style lang="scss">
    @import "../../../styles/colors";
    @import "../../../styles/ui/clouds";

    .header-menu__mobile {
        padding: 0 2.5rem;

        &__cross {
            position: relative;
            width: 2rem;
            height: 1.8rem;
            cursor: pointer;

            span {
                position: absolute;
                display: block;
                width: 2rem;
                height: .3rem;
                background-color: $main-color;
                transition: all .3s ease;
                transform: translateY(-50%);

                &.line-1 {
                    top: 0;
                }

                &.line-2 {
                    top: 42%;
                }

                &.line-3 {
                    bottom: 0;
                }
            }

            &-focus span {
                &.line-1 {
                    top: 50%;
                    transform: translateY(-50%) rotate(45deg);
                }

                &.line-2 {
                    opacity: 0;
                }

                &.line-3 {
                    top: 50%;
                    transform: translateY(-50%) rotate(-45deg);
                }
            }
        }
    }

    .mobile-overlay {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 100%;
        background-color: rgba($main-color, .9);
        width: 100%;
        height: calc(100vh - 110px);

        .cloud-1 {
            top: 6%;
            left: 13%;
        }

        .cloud-2 {
            top: 10%;
            right: 10%;
        }

        .cloud-3 {
            top: 50%;
            right: -10%;
        }

        &__links {
            margin: -100px 0 0;
            padding: 0;
            list-style-type: none;
            text-align: center;
            text-transform: uppercase;

            li {
                position: relative;

                &::after {
                    position: absolute;
                    left: 50%;
                    bottom: 0;
                    transform: translateX(-50%);
                    content: '';
                    width: 2.5rem;
                    height: .1rem;
                    background-color: $white;
                }

                &:last-of-type::after {
                    display: none;
                }

                a {
                    display: block;
                    padding: 2rem 1rem;
                    color: $white;
                }
            }
        }

        &__bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            bottom: 0;
            padding: 0 2.5rem;
            width: 100%;
            height: 10rem;
            background-color: $light-grey;

            .logout-link {
                display: flex;
                align-items: center;
                text-transform: uppercase;

                img {
                    margin-right: 1rem;
                }
            }
        }
    }

    @import "../../../styles/transitions/menu-mobile-transition";
</style>