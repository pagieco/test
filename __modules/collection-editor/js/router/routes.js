import Entries from './views/Entries.vue';
import Overview from './views/Overview.vue';
import ShowEntry from './views/ShowEntry.vue';

export default [
  {
    path: '/',
    component: Overview,
    name: 'overview',
    children: [
      {
        path: '/:id',
        component: Entries,
        name: 'collection-entries',
        children: [
          {
            path: '/:id/:slug',
            component: ShowEntry,
            name: 'show-entry',
          },
        ],
      },
    ],
  },
];
