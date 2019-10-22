<script>

import Header from './Header.vue';
import { wrapPageIntoIframe } from '../iframe';

export default {
  components: { Header },

  data() {
    return {
      loading: false,
    };
  },

  mounted() {
    this.loading = true;

    this.moveIframeIntoCanvasContainer();
  },

  methods: {
    moveIframeIntoCanvasContainer() {
      wrapPageIntoIframe('.canvas-container');
    },
  },
};

</script>

<template>
  <div>
    <Header />

    <div class="canvas-container"></div>

    <div class="property-editor">
      <RouterView :key="$route.fullPath" />
    </div>
  </div>
</template>
