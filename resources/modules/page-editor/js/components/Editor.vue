<script>

import Vue from 'vue';
import Toolbar from './Toolbar.vue';
import { collectDomNodes } from '../dom';
import LocalEditor from './LocalEditor.vue';
import SidebarLeft from './SidebarLeft.vue';
import SidebarRight from './SidebarRight.vue';
import { getIframeDocument, replaceIframePlaceholder, wrapPageIntoIframe } from '../iframe';

const StoreActions = [
  'asset/fetchAssets',
  'page/fetchPages',
];

export default {
  components: {
    Toolbar,
    SidebarLeft,
    SidebarRight,
  },

  async mounted() {
    replaceIframePlaceholder(this.$refs.iframePlaceholder);

    const iframe = await wrapPageIntoIframe();

    this.createLocalVueInstance(iframe);

    Promise.all(StoreActions.map(action => this.$store.dispatch(action)))
      .then(() => {
        this.removeLoadingOverlay();
      });
  },

  methods: {
    async createLocalVueInstance(iframe) {
      const iframeDocument = getIframeDocument(iframe);

      // eslint-disable-next-line no-new
      new Vue({
        el: iframeDocument.body.querySelector('#local-app'),
        store: this.$store,
        components: { LocalEditor },
        template: '<LocalEditor />',
        created() {
          this.$store.dispatch('dom/collectNodes', collectDomNodes());
        },
      });
    },

    removeLoadingOverlay() {
      document.getElementById('loading-overlay')
        .remove();
    },
  },
};

</script>

<template>
  <div id="editor">

    <Toolbar/>

    <div class="canvas-wrapper">
      <SidebarLeft />

      <div ref="iframePlaceholder">
        <!-- ... -->
      </div>

      <SidebarRight />
    </div>

  </div>
</template>
