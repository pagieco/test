<script>

import { mapGetters, mapActions } from 'vuex';
import {
  Page,
} from '../../components';
import AssetList from './components/AssetList.vue';
import FolderList from './components/FolderList.vue';

export default {
  components: {
    Page,
    AssetList,
    FolderList,
  },

  metaInfo: {
    title: 'Assets',
  },

  watch: {
    $route: 'init',
  },

  data() {
    return {
      loading: false,
    };
  },

  computed: {
    ...mapGetters({
      assets: 'asset/assets',
      folders: 'asset/folders',
    }),
  },

  mounted() {
    this.init();
  },

  methods: {
    ...mapActions({
      fetchAssets: 'asset/fetchAssets',
      fetchFolders: 'asset/fetchFolders',
    }),

    init() {
      this.$store.dispatch('asset/clearAssets');
      this.$store.dispatch('asset/clearFolders');

      this.loading = true;

      Promise.all([
        this.$store.dispatch('asset/fetchFolders'),
        this.$store.dispatch('asset/fetchAssets'),
      ]).then(() => {
        this.loading = false;
      });
    },
  },
};

</script>

<template>
  <Page title="Assets">

    <template v-slot:navigation>
      <span v-if="loading">loading...</span>
      <FolderList :folders="folders" />
    </template>

    <span v-if="loading">loading...</span>
    <AssetList :assets="assets" v-if="!loading" />

  </Page>
</template>
