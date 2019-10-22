import Vue from 'vue';
import router from './router';
import store from './state/store';
import Editor from './components/Editor.vue';
import { collectDomNodes, getDomNodeSelector } from './dom';

require('./directives');

// eslint-disable-next-line no-new
new Vue({
  el: '#editor-wrapper',
  store,
  router,
  created() {
    const collectedDomNodes = collectDomNodes(getDomNodeSelector(), document);

    this.$store.dispatch('dom/collectNodes', collectedDomNodes);
  },
  components: { Editor },
  template: '<Editor />',
});
