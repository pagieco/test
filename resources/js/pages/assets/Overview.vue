<script>

import { mapActions, mapGetters } from 'vuex';
import { Card, Page, ResourceList, ResourceListItem, TextStyle, } from '../../../focus-ui/src/components';

export default {
  components: {
    Page,
    Card,
    TextStyle,
    ResourceList,
    ResourceListItem,
  },

  mounted() {
    this.initializeComponentState();
  },

  computed: {
    ...mapGetters({
      assets: 'asset/assets',
    }),
  },

  methods: {
    ...mapActions({
      fetchAssets: 'asset/fetchAssets',
      sortAssets: 'asset/sortAssets',
    }),

    initializeComponentState() {
      this.fetchAssets();
    },

    onSort({ direction }) {
      this.sortAssets(direction);
    },
  },
};

</script>

<template>
  <Page title="Assets" full-width>

    <Card>
      <ResourceList
          selectable
          @sort="onSort"
          :items="assets"
          :sort-options="[
            { label: 'Newest update', 'direction': 'desc' },
            { label: 'Oldest update', 'direction': 'asc' },
          ]"
          :resource-name="{ singular: 'asset', plural: 'assets' }">
        <template v-slot:default="item">
          <ResourceListItem v-bind="{ ...item }">
            <img :src="item.thumb_path" alt="">
            <TextStyle variation="strong">{{ item.filename }}</TextStyle>
          </ResourceListItem>
        </template>
      </ResourceList>
    </Card>

  </Page>
</template>
