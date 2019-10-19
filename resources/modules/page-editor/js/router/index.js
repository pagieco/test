import Vue from 'vue';
import VueRouter from 'vue-router';

import RootPanel from './panels/RootPanel.vue';
import BackgroundPanel from './panels/BackgroundPanel.vue';

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: '/', name: 'root-panel', component: RootPanel },
    { path: '/background', name: 'background-panel', component: BackgroundPanel },
  ],
});
