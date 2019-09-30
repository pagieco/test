<script>

import { mapActions, mapGetters } from 'vuex';
import {
  Card,
  Page,
  EmptyState,
  ResourceList,
  ResourceListItem,
} from '../../../focus-ui/src/components';

export default {
  /**
   * The child components.
   */
  components: {
    Card,
    Page,
    EmptyState,
    ResourceList,
    ResourceListItem,
  },

  /**
   * The page's meta-info.
   */
  metaInfo: {
    title: 'Pages',
  },

  data() {
    return {
      loadingPages: false,
    };
  },

  computed: {
    ...mapGetters({
      pages: 'page/pages',
    }),
  },

  mounted() {
    this.initializeComponentState();
  },

  methods: {
    ...mapActions({
      fetchPages: 'page/fetchPages',
    }),

    initializeComponentState() {
      this.loadingPages = true;

      this.fetchPages().then(() => {
        this.loadingPages = false;
      });
    },
  },
};

</script>

<template>
  <Page title="Pages">

    <div v-if="loadingPages">
      loading...
    </div>

    <div v-if="!loadingPages">
      <EmptyState v-if="!pages" image="http://pagie.local:13833/img/upload-assets.svg"
                  :action="{ content: 'Add transfer' }"
                  heading="Manage your inventory transfers">
        <p>Track and receive your incoming inventory from suppliers.</p>
      </EmptyState>

      <Card v-if="pages">
        <ResourceList selectable
                      :resource-name="{ singular: 'page', plural: 'pages' }"
                      :items="pages">
          <template v-slot:default="item">
            <ResourceListItem v-bind="{ ...item }">
              {{ item }}
            </ResourceListItem>
          </template>
        </ResourceList>
      </Card>
    </div>

  </Page>
</template>
