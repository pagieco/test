import Vue from 'vue';
import Vuex from 'vuex';
import TestComponent from './components/TestComponent.vue';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    count: 100,
  },
  getters: {
    count(state) {
      return state.count;
    },
  },
  mutations: {
    increment(state) {
      state.count++;
    },
  },
});

function createIframe() {
  return new Promise((resolve) => {
    const iframe = document.createElement('iframe');

    iframe.addEventListener('load', () => {
      resolve(iframe);
    });

    document.body.appendChild(iframe);
  });
}

createIframe().then((iframe) => {
  const { body } = iframe.contentDocument;

  new Vue({
    store,
    el: '#editor-wrapper',
    components: { TestComponent },
    template: '<TestComponent />',
  });

  new Vue({
    el: body,
    store,
    render(h) {
      return h('div', this.$store.getters.count);
    },
  });
});
