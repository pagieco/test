<script>

import { serialize } from '../dom';
import Node from './DomTree/Node.vue';
import { getIframeDocument } from '../iframe';
import event, { DOM_REPAINT } from '../services/event';

export default {
  components: {
    Node,
  },

  data() {
    return {
      dom: {},
    };
  },

  mounted() {
    event.$on(DOM_REPAINT, () => {
      this.dom = serialize(getIframeDocument().body);
    });
  },
};

</script>

<template>
  <div class="sidebar sidebar--left">
    <ul>
      <Node :node="dom"/>
    </ul>
  </div>
</template>
