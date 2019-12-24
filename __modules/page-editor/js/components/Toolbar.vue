<script>

import { serialize } from '../dom';
import http from '../services/http';
import { getConfig } from '../config';
import { getIframeDocument } from '../iframe';
import event, { HIGHLIGHTER_RECALCPOS } from '../services/event';

export default {
  methods: {
    publish() {
      http.post(`/pages/${getConfig('pageId')}/publish`, {
        dom: serialize(getIframeDocument().body),
        css: this.$store.getters['style/rules'],
      });
    },

    openPage() {
      // ...
    },

    togglePreviewMode() {
      // ...
    },

    setCanvasSize(size) {
      this.$store.dispatch('style/setMediaQuery', size);

      this.$nextTick(() => {
        event.$emit(HIGHLIGHTER_RECALCPOS);
      });
    },
  },
};

</script>

<template>
  <div id="toolbar">

    <div>
      <button @click="togglePreviewMode">Preview Page</button>
    </div>

    <div>
      <button @click="setCanvasSize('desktop')">Desktop</button>
      <button @click="setCanvasSize('tablet')">Tablet</button>
      <button @click="setCanvasSize('mobile_landscape')">Mobile Landscape</button>
      <button @click="setCanvasSize('mobile_portrait')">Mobile Portrait</button>
    </div>

    <div>
      <button @click="openPage">Open Page</button>
      <button @click="publish">Publish</button>
    </div>

  </div>
</template>
