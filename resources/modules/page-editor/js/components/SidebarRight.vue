<script>

import { mapGetters } from 'vuex';
import StyleProp from '../mixins/StyleProp';

export default {
  mixins: [StyleProp],

  computed: {
    ...mapGetters({
      selectionSet: 'selection/selectionSet',
    }),

    value() {
      return this.getStyleProp('background-color');
    },
  },
};

</script>

<template>
  <div class="sidebar sidebar--right" v-if="selectionSet.length">
    {{ selectionSet }}

    <input type="text"
           v-style-prop="'background-color'"
           :value="value"/>
  </div>
</template>
