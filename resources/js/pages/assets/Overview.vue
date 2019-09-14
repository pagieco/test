<script>

import { mapActions } from 'vuex';
import {
  Page,
} from '../../../focus-ui/src/components';

export default {
  components: {
    Page,
  },

  mounted() {
    this.initializeComponentState();
  },

  methods: {
    ...mapActions({
      fetchAssets: 'asset/fetchAssets',
    }),

    initializeComponentState() {
      this.fetchAssets();
    },
  },
};

</script>

<template>
  <Page title="Assets" full-width>



  </Page>
</template>
