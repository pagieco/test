<script>

import { mapGetters } from 'vuex';
import { getIframeDocument } from '../iframe';
import event, { HIGHLIGHTER_RECALCPOS, IFRAME_LOADED } from '../services/event';
import { getNodePosition } from '../dom';

export default {
  data() {
    return {
      // ...
    };
  },

  computed: {
    ...mapGetters({
      selectionSet: 'selection/selectionSet',
    }),
  },

  mounted() {
    this.bindEventHandlers();
  },

  methods: {
    bindEventHandlers() {
      event.$on(IFRAME_LOADED, () => {
        getIframeDocument().body.addEventListener('click', () => {
          this.$store.dispatch('selection.deselectAllNodes');
        });
      });

      event.$on(HIGHLIGHTER_RECALCPOS, () => {
        this.$nextTick(() => {
          // ...
        });
      });
    },

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
         :key="nodeId"
         :style="getPosition(nodeId)">
      <!-- ... -->
    </div>
  </div>
</template>

<style>
  .highlighter {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    pointer-events: none;
  }

  .highlighter__element {
    position: absolute;
    pointer-events: none;
    border: 1px solid #007bff;
  }
</style>
