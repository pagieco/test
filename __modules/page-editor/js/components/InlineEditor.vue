<script>

import { mapGetters } from 'vuex';
import { getNodePosition } from '../dom';

export default {
  computed: {
    ...mapGetters({
      editingIndex: 'editingMode/editingNodeIndex',
    }),
  },

  methods: {
    closeEditor(e) {
      e.stopPropagation();

      this.$store.dispatch('editingMode/disable');
    },

    getPosition(index) {
      return index ? getNodePosition(index) : {};
    },
  },
};

</script>

<template>
  <div class="test" :style="getPosition(editingIndex)">
    <button @click="closeEditor">Close editor</button>
    inline editor.
  </div>
</template>
