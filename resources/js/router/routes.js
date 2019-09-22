export default [
  {
    name: 'dashboard',
    path: '/',
    component: () => import('../pages/Dashboard.vue'),
  },

  // Asset routes...
  {
    name: 'assets',
    path: '/assets',
    component: () => import('../pages/assets/Overview.vue'),
  },

  // Page routes...
  {
    name: 'pages',
    path: '/pages',
    component: () => import('../pages/pages/Overview.vue'),
  },

  // Collection routes...
  {
    name: 'collections',
    path: '/collections',
    component: () => import('../pages/collections/Overview.vue'),
  },

  // Form routes...
  {
    name: 'forms',
    path: '/forms',
    component: () => import('../pages/forms/Overview.vue'),
  },

  // Email routes...
  {
    name: 'emails',
    path: '/emails',
    component: () => import('../pages/emails/Overview.vue'),
  },

  // Profile routes...
  {
    name: 'profiles',
    path: '/profiles',
    component: () => import('../pages/profiles/Overview.vue'),
  },

  // Automation routes..
  {
    name: 'automations',
    path: '/automations',
    component: () => import('../pages/automations/Overview.vue'),
  },

  // Domain routes...
  {
    name: 'domains',
    path: '/domains',
    component: () => import('../pages/domains/Overview.vue'),
  },

  // Workflow routes...
  {
    name: 'workflows',
    path: '/workflows',
    component: () => import('../pages/workflows/Overview.vue'),
  },
];
