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
      wrapPageIntoIframe('.canvas-container').then(() => {
        Promise.all([
          this.$store.dispatch('asset/fetchAssets'),
          this.$store.dispatch('page/fetchPages'),
        ]).then(() => {
          this.loading = false;
        });
      });
    },
  },
};

</script>

<template>
  <div id="editor">
    <div id="loading-overlay" v-show="loading">
      loading...
    </div>

    <Header />

    <div id="canvas">
      <div class="canvas-container"></div>

      <div class="property-editor">
        <RouterView :key="$route.fullPath" />
      </div>
    </div>
  </div>
</template>
