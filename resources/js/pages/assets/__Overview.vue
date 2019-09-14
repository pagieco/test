<script>

import { mapActions } from 'vuex';
import {
  Page,
  Spinner,
} from '../../components';

export default {
  /**
   * The child components.
   */
  components: {
    Page,
    Spinner,
  },

  /**
   * The page's meta-info.
   */
  metaInfo: {
    title: 'Assets',
  },

  /**
   * Prepare the component.
   */
  mounted() {
    return this.loadComponentData();
  },

  /**
   * The component's methods.
   */
  methods: {
    ...mapActions({
      fetchAssets: 'asset/fetchAssets',
    }),

    loadComponentData() {
      this.fetchAssets();
    },
  },
};

</script>

<template>
  <Page title="Assets">

    <Spinner />

  </Page>
</template>
