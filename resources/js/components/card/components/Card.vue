<script>

import CardSection from './CardSection.vue';

export default {
  components: {
    CardSection,
  },

  props: {
    /**
     * Indicates that the card is interactive.
     */
    interactive: {
      type: Boolean,
      default: false,
    },

    /**
     * Auto wrap content in section.
     */
    sectioned: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    classList() {
      return [
        'bg-white', 'rounded', 'shadow', 'border', 'border-transparent',
        { 'cursor-pointer': this.interactive },
        { 'hover:border-sapphire-500': this.interactive },
      ];
    },
  },

  render(h) {
    return h('div', { class: this.classList }, [
      h(this.sectioned ? CardSection : 'div', [
        this.$slots.default,
      ]),
    ]);
  },
};

</script>
