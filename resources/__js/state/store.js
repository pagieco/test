import Vue from 'vue';
import Vuex from 'vuex';
import dispatchActionForAllModules from './utils/dispatch-action-for-all-modules';
import modules from './modules';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules,
  strict: true,
});

export default store;

// Automatically run the `init` action for every module if one exists.
dispatchActionForAllModules('init');
