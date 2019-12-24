<script>

import { forOwn } from 'lodash';
import { mapGetters } from 'vuex';
import { getNodePosition } from '../dom';
import { bindResizeEventHandlers } from '../highlighter';
import event, { HIGHLIGHTER_RECALCPOS } from '../services/event';

export default {
  computed: {
    ...mapGetters({
      selectionSet: 'selection/selectionSet',
    }),
  },

  mounted() {
    bindResizeEventHandlers();

    event.$on(HIGHLIGHTER_RECALCPOS, () => {
      this.repositionHighlighters();
    });
  },

  methods: {
    getPosition(index) {
      return getNodePosition(index);
    },

    repositionHighlighters() {
      [...this.$el.querySelectorAll('.highlighter__element')].forEach((el) => {
        forOwn(this.getPosition(el.dataset.index), (value, key) => {
          el.style[key] = value;
        });
      });
    },

    handleResize(e, currentHandle) {
      this.$store.dispatch('highlighter/startResizing', {
        currentHandle,
        startPosition: { x: e.clientX, y: e.clientY },
      });
    },
  },
};

</script>

<template>

  <div class="highlighter">
    <div class="highlighter__element"
         v-for="index in selectionSet"
         :style="getPosition(index)"
         :data-index="index"
         :key="index">
      <div class="highlighter__resize--width" @mousedown="e => handleResize(e, 'width')"></div>
      <div class="highlighter__resize--height" @mousedown="e => handleResize(e, 'height')"></div>
    </div>
  </div>

</template>
