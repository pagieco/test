<script>

import { mapGetters } from 'vuex';
import { getNodePosition } from '../dom';

export default {
  computed: {
    ...mapGetters({
      selectionSet: 'selection/selectionSet',
    }),
  },

  methods: {
    getPosition(nodeId) {
      return getNodePosition(nodeId);
    },
  },
};

</script>

<template>

  <div class="highlighter">
    <div class="highlighter__element"
         v-for="nodeId in selectionSet"
         :style="getPosition(nodeId)"
         :key="nodeId">
    </div>
  </div>

</template>
