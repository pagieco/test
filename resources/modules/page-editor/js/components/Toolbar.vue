<script>

import { serialize } from '../dom';
import http from '../services/http';
import { getConfig } from '../config';
import { getIframeDocument } from '../iframe';

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
  },
};

</script>

<template>
  <div id="toolbar">

    <div>
      <button @click="togglePreviewMode">Preview Page</button>
    </div>

    <div>
      <button>Desktop</button>
      <button>Tablet</button>
      <button>Mobile Landscape</button>
      <button>Mobile Portrait</button>
    </div>

    <div>
      <button @click="openPage">Open Page</button>
      <button @click="publish">Publish</button>
    </div>

  </div>
</template>
