import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      styleRule: 'style/styleRule',
      selectionSet: 'selection/selectionSet',
    }),
  },

  methods: {
    hasStyleValue(prop) {
      return !!this.getStyleProp(prop);
    },

    getStyleProp(prop) {
      return this.styleRule(this.selectionSet, prop);
    },
  },
};
