<script>

import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      selectionSet: 'selection/selectionSet',
    }),
  },
};

</script>

<template>
  <div class="sidebar sidebar--right">
    sidebar right
    {{ selectionSet }}
  </div>
</template>
