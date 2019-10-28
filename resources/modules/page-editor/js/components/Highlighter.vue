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
    getPosition(index) {
      return getNodePosition(index);
    },
  },
};

</script>

<template>

  <div class="highlighter">
    <div class="highlighter__element"
         v-for="index in selectionSet"
         :style="getPosition(index)"
         :key="index">
    </div>
  </div>

</template>
