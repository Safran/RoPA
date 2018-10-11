
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


// Inits
window._ = require('lodash');

window.Vue = require('vue');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Tools
const $DOC = $(document);
const $BODY = $('body');

$DOC.tooltip({
    selector: '[data-tooltip=true]',
    container: 'body'
});

$DOC.ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
});

if (typeof $.fn.animsition !== 'undefined') {
    $BODY.animsition({
        inClass: 'fade-in',
        outClass: 'fade-out',
        inDuration: 800,
        outDuration: 500,
        loading: true,
        loadingClass: 'loader-overlay',
        loadingParentElement: 'html',
        loadingInner: `
      <div class="loader-content">
        <div class="loader-page">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>`,
        onLoadEvent: true
    });
}

// Lang part
$('ul.select-lang').each(function () {
    var list = $(this),
        select = document.createElement('select');

    select.setAttribute('class', 'custom-select small text-primary border-primary');
    $(select).insertBefore($(this).hide());
    $('>li a', this).each(function () {
        var target = $(this).attr('target'),
            option = $(document.createElement('option'))
                .appendTo(select)
                .val(this.href)
                .attr('selected', (this.getAttribute('class') == 'active'))
                .html($(this).html())
                .click(function () {
                    window.location.href = $(this).val();
                });
    });
    list.remove();
});


// Vue app
import Vue from 'vue'

import store from './store/index'
import DeviceInfosPlugin from './plugins/DeviceInfos'

Vue.use(DeviceInfosPlugin, {store});

new Vue({
    el: '#app',
    store,
    components: {
    },
    data () {
        return {
            enableShadow: false
        }
    },
    mounted () {
        let _ = this;
        document.addEventListener('scroll', _.showShadow)
    },
    beforeDestroy () {
        let _ = this;
        document.removeEventListener('scroll', _.showShadow)
    },
    methods: {
        showShadow () {
            this.enableShadow = (window.pageYOffset > 25)
        }
    }
});
