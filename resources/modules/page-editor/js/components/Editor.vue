<script>

import Vue from 'vue';
import Toolbar from './Toolbar.vue';
import { collectDomNodes } from '../dom';
import LocalEditor from './LocalEditor.vue';
import SidebarLeft from './SidebarLeft.vue';
import SidebarRight from './SidebarRight.vue';
import event, { DOM_REPAINT } from '../services/event';
import { getIframeDocument, replaceIframePlaceholder, wrapPageIntoIframe } from '../iframe';

const StoreActions = [
  'asset/fetchAssets',
  'page/fetchPages',
];

export default {
  components: {
    Toolbar,
    LocalEditor,
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
      const iframeDoc = getIframeDocument(iframe);
      const { body } = iframeDoc;

      // eslint-disable-next-line no-new
      new Vue({
        el: body.querySelector('#local-app'),
        store: this.$store,
        template: '<LocalEditor />',
        components: { LocalEditor },
        created() {
          this.$store.dispatch('dom/collectNodes', collectDomNodes(iframeDoc));

          event.$emit(DOM_REPAINT);
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
      <!-- sidebar-left -->
      <SidebarLeft/>

      <div ref="iframePlaceholder">
        <!-- ... -->
      </div>

      <!-- sidebar-right -->
      <SidebarRight/>
    </div>

  </div>
</template>
