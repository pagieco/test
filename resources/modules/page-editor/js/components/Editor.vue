<script>

import { wrapPageIntoIframe } from '../iframe';

export default {
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
    <div class="canvas-container"></div>
    <div class="property-editor">
      <RouterView :key="$route.fullPath" />
    </div>
  </div>
</template>
