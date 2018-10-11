/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


/**
 * @DeviceInfos
 */

const throttle = require('lodash.throttle');

const DeviceInfos = {};

DeviceInfos.install = (Vue, options) => {
  const store = options.store;

  store.commit('checkBreakpoints');

  window.addEventListener('resize', throttle(() => {
    store.commit('checkBreakpoints')
  }, 100));

  /*
  * Useful computed to get current layout
  */
  Vue.mixin({
    computed: {
      getTablet () {
        return this.$store.getters.getTablet
      },
      getMobile () {
        return this.$store.getters.getMobile
      }
    }
  })
};

export default DeviceInfos;
