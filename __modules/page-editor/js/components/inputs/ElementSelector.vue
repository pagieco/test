<script>

export default {
  computed: {
    selectionSet() {
      return this.$store.getters['selection/selectionSet'];
    },

    getElementSelector() {
      return this.$store.getters['dom/selector'](this.selectionSet);
    },
  },

  methods: {
    setElementSelector(e) {
      this.$store.dispatch('dom/setSelector', {
        selectionSet: this.selectionSet,
        selector: e.target.value,
      });
    },
  },
};

</script>

<template>
  <div>
    <label>
      Element selector:
      <input type="text" @input="setElementSelector" :value="getElementSelector"/>
    </label>
  </div>
</template>
