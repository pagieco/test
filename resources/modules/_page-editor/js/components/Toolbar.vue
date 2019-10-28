<script>

import { mapGetters } from 'vuex';
import { getIframeDocument } from '../iframe';
import { serialize } from '../dom';

export default {
  computed: {
    ...mapGetters({
      pages: 'page/pages',
    }),
  },

  methods: {
    publish() {
      const root = getIframeDocument().querySelector('body');

      console.log(serialize(root));
    },
  },
};

</script>

<template>
  <div class="toolbar">
    <button @click="publish">Publish</button>

    <label>
      Page:
      <select>
        <option v-for="page in pages" :key="page.id" :value="page.id">{{ page.name }}</option>
      </select>
    </label>

  </div>
</template>
