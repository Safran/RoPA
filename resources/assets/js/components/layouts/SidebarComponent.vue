<!--
    This file is part of the Record of processing activities project.
    Its original location is https://github.com/Safran/RoPA
    
    SPDX-License-Identifier: GPL-3.0-only
  -->


<template>
  <aside class="sidebar-component" v-if="!getTablet">
    <img class="cloud cloud-1 cloud-l" src="../../../img/general/cloud.svg" :alt="$e('locale.cloud_alt')">
    <img class="plane" src="../../../img/general/plane.svg" :alt="$e('locale.plane_alt')">
  </aside>
</template>

<script>
  export default {
    name: 'sidebar-component'
  }
</script>

<style lang="scss">
  @import './../../../styles/_colors';
  @import './../../../styles/ui/clouds';

  .sidebar-component {
    position: relative;
    min-width: 10rem;
    max-width: 10rem;
    margin-top: 8rem;
    background-color: $main-color;

    .cloud-1 {
      z-index: 2;
      top: -6rem;
      right: -6rem;
    }

    .plane {
      position: absolute;
      top: 0;
      left: -4rem;
    }
  }
</style>
