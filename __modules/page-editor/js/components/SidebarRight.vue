<script>

import { mapGetters } from 'vuex';
import StyleProp from '../mixins/StyleProp';
import ElementSelector from './inputs/ElementSelector.vue';

export default {
  mixins: [StyleProp],

  components: { ElementSelector },

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

    <ElementSelector/>

    <input type="text"
           v-style-prop="'background-color'"
           :value="value"/>
  </div>
</template>
