<script>

import StyleProp from '../../mixins/StyleProp';

export default {
  mixins: [StyleProp],

  props: {
    id: {
      type: String,
      required: true,
    },

    styleProp: {
      type: String,
      required: true,
    },

    defaultValue: {
      type: String,
      default: 'auto',
    },
  },

  computed: {
    value() {
      return this.getStyleProp(this.styleProp) || this.defaultValue;
    },

    classList() {
      return [
        { 'text-gray-400': ! this.hasStyleValue(this.styleProp) },
      ];
    },
  },

  methods: {
    test() {
      if (! this.hasStyleValue(this.styleProp)) {
        this.$el.select();
      }
    },
  },
};

</script>

<template>
  <input type="text"
         class="px-1 py-1 border block rounded w-full text-xs focus:outline-none focus:border-blue-500"
         v-style-prop="styleProp"
         @focus="test"
         :class="classList"
         :id="`f-${id}`"
         :value="value" />
</template>
