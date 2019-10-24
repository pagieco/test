<script>

import { mapGetters } from 'vuex';
import http from '../services/http';
import { serialize } from '../dom';
import { getIframeDocument } from '../iframe';

export default {
  computed: {
    ...mapGetters({
      pages: 'page/pages',
    }),
  },

  methods: {
    publish() {
      const rootNode = getIframeDocument().querySelector('body');
      const pageId = window.location.pathname.split('/')[3];

      http.post(`/pages/${pageId}/publish`, {
        dom: serialize(rootNode),
        css: this.$store.getters['style/rules'],
      });
    },

    openPage(e) {
      window.location = `/app/page-designer/${e.target.value}`;
    },
  },
};

</script>

<template>
  <header>
    <div>
      <button @click="publish">Publish changes</button>
    </div>

    <select @change="openPage">
      <option v-for="page in pages" :key="page.id">{{ page.name }}</option>
    </select>
  </header>
</template>
