/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


import Vue from 'vue'
import Vuex from 'vuex'
import device from './modules/device'

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    device
  }
})
