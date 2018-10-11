/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


// Inits
import {fullPath} from "./plugins/utils";

import lang from 'lang.js';
import store from './store/index'
import DeviceInfosPlugin from './plugins/DeviceInfos'
import vClickOutside from 'v-click-outside'
import moment from "moment";
import VueMomentJS from "vue-momentjs";
import vmodal from 'vue-js-modal';
import serialize from './serialize';


const Lang = new lang({
    locale: window.App.locale,
    fallback: 'fr',
    messages: window.App.messages,
});

export default Lang;

window._ = require('lodash');
window.Vue = require('vue');
window.axios = require('axios');
window.Lang = Lang;
window.serialize = serialize;
window.nl2br = function(str) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br>');
};

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

window.axios.defaults.baseURL = window.App.baseURL;

window.events = new Vue();

window.flash = function(message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

let access = require('./access');

Vue.prototype.allow = function(...params) {
    if (!window.App.signedIn) return false;

    if (typeof params[0] === 'string') {
        return access[params[0]](params[1]);
    }

    return params[0](window.App.user);
};

Vue.prototype.$e = function(key, number, replacements, locale) {
    // console.log('translate [' + key + '] => ' + Lang.get(key, number, replacements, locale));
    return Lang.get(key, number, replacements, locale);
};

Vue.prototype.$c = function(key, replacements, locale) {
    return Lang.choice(key, replacements, locale);
};

Vue.prototype.$url = function(path) {
    return fullPath(path);
};

Vue.use(DeviceInfosPlugin, {store});
Vue.use(vClickOutside);
Vue.use(VueMomentJS, moment);
Vue.use(vmodal);

/**
 * Components
 */
Vue.component("progress-bar", require("@/js/components/general/ProgressBar"));
Vue.component("new-declaration", require("@/js/components/declarations/NewDeclaration"));
Vue.component("edit-declaration", require("@/js/components/declarations/EditDeclaration"));
Vue.component("flash", require("@/js/components/general/Flash"));
Vue.component("notifications-component", require("@/js/components/menu/NotificationsComponent"));
Vue.component("statements-component", require("@/js/components/statements/StatementsComponent"));
Vue.component("disclaimer-content", require("@/js/components/disclaimer/DisclaimerContent"));
Vue.component("menu-mobile", require("@/js/components/menu/MenuMobile"));

/**
 * Vue app
 */
new Vue({
    el: '#app',
    store,
    data() {
        return {
            enableShadow: false,
            loading: true,
        }
    },
    mounted() {
        let _ = this;
        document.addEventListener('scroll', _.showShadow);
        this.loading = false;
    },
    beforeDestroy() {
        let _ = this;
        document.removeEventListener('scroll', _.showShadow);
    },
    methods: {
        showShadow() {
            this.enableShadow = (window.pageYOffset > 25);
        },
    },
    computed: {
        classes() {
           return [
               {'loading': this.loading},
           ];
        },
    },
});

