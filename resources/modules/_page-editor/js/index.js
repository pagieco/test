import Vue from 'vue';
import store from './state/store';
import Editor from './components/Editor.vue';

// eslint-disable-next-line no-new
new Vue({
  el: '#app',
  store,
  components: { Editor },
  template: '<Editor />',
});
