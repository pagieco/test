<script>

import Highlighter from './Highlighter.vue';
import ContextMenu from './ContextMenu.vue';

export default {
  components: { Highlighter, ContextMenu },
};

</script>

<template>
  <div id="local-editor">
    <Highlighter />
    <ContextMenu />
  </div>
</template>
