<script>

import Sidebar from './shared/Sidebar.vue';
import {
  TopBar,
} from './components';

export default {
  components: {
    TopBar,
    Sidebar,
  },

  metaInfo: {
    titleTemplate(title) {
      // eslint-disable-next-line no-param-reassign
      title = typeof title === 'function' ? title(this.$store) : title;

      return title ? `${title} | ${this.appConfig.app.title}` : this.appConfig.app.title;
    },
  },
};

</script>

<template>
  <div id="app" class="min-h-screen flex">
    <div class="flex-shrink-0 w-64 bg-gray-800 flex">
      <Sidebar />
    </div>

    <div class="flex-grow flex flex-col">
      <div class="relative shadow-md bg-green-700 flex-shrink-0">
        <TopBar :user-menu="{
          name: appConfig.user.name,
          detail: 'Wildcats',
        }" />
      </div>

      <div class="flex-grow flex flex-col">
        <div class="flex-grow">
          <!--
            Even when routes use the same component, treat them
            as distict and create the component again.
          -->
          <RouterView :key="$route.fullPath" />
        </div>
      </div>
    </div>
  </div>
</template>
