<script>

import { mapActions, mapGetters } from 'vuex';
import {
  Card,
  Page,
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
    ResourceList,
    ResourceListItem,
  },

  /**
   * The page's meta-info.
   */
  metaInfo: {
    title: 'Workflows',
  },

  computed: {
    ...mapGetters({
      workflows: 'workflow/workflows',
    }),
  },

  mounted() {
    this.initializeComponentState();
  },

  methods: {
    ...mapActions({
      fetchWorkflows: 'workflow/fetchWorkflows',
    }),

    initializeComponentState() {
      this.fetchWorkflows();
    },
  },
};

</script>

<template>
  <Page title="Workflows">

    <Card>
      <ResourceList selectable
                    :resource-name="{ singular: 'workflow', plural: 'workflows' }"
                    :items="workflows">
        <template v-slot:default="item">
          <ResourceListItem v-bind="{ ...item }">
            {{ item }}
          </ResourceListItem>
        </template>
      </ResourceList>
    </Card>

  </Page>
</template>
