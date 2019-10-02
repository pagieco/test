<script>

import {
  ApplicationFrame,
  TopBar,
} from './components';

import Sidebar from './layout/Sidebar.vue';

export default {
  components: {
    Sidebar,
    TopBar,
    ApplicationFrame,
  },
};

</script>

<template>
  <application-frame>
    <template v-slot:navigation>
      <Sidebar />
    </template>

    <template v-slot:top-bar>
      <TopBar />
    </template>

    <RouterView :key="$route.fullPath" />
  </application-frame>
</template>
