/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


const state = {
  viewport: {
    width: window.innerWidth,
    height: window.innerHeight
  },
  breakpoints: {
    tablet: 1080,
    mobile: 600
  },
  isTablet: false,
  isMobile: false
};

/**
 * Getters
 */
const getters = {
  getTablet: state => state.isTablet,
  getMobile: state => state.isMobile
};

/**
 * Actions
 */
const actions = {

};

/**
 * Mutations
 */
const mutations = {
  /*
  * Check if user is on tablet or mobile
  */
  checkBreakpoints (state) {
    state.isTablet = window.innerWidth <= state.breakpoints.tablet;
    state.isMobile = window.innerWidth <= state.breakpoints.mobile;
  }
};

module.exports = {
  state,
  getters,
  actions,
  mutations
};
