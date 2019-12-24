<script>

export default {
  name: 'Node',

  props: {
    node: {
      type: Object,
    },
  },

  computed: {
    isSelected() {
      return this.$store.getters['selection/isSelected'](this.node.nodeIndex);
    },
  },

  filters: {
    readableNodeType(value) {
      const nodeName = String(value)
        .toLowerCase();

      return nodeName.charAt(0)
        .toUpperCase() + nodeName.slice(1);
    },
  },

  methods: {
    selectNode(e) {
      e.stopPropagation();

      this.$store.dispatch('selection/setNodeSelection', {
        originalEvent: e,
        nodeIndex: this.node.nodeIndex,
      });
    },
  },
};

</script>

<template>
  <li @click="selectNode">
    <span :class="{ selected: isSelected }">
      {{ node.nodeType | readableNodeType }}
    </span>

    <ul>
      <Node
          v-for="(childNode, nodeIndex) in node.children"
          :key="nodeIndex"
          :node="childNode"/>
    </ul>

  </li>
</template>

<style>
  .selected {
    background-color: blue;
    color: white;
  }
</style>
