<script>

import Highlighter from './Highlighter.vue';
import InlineEditor from './InlineEditor.vue';

export default {
  components: {
    Highlighter,
    InlineEditor,
  },

  computed: {
    inlineEditorEnabled() {
      return this.$store.getters['editingMode/enabled'];
    },
  },
};

</script>

<template>
  <div class="skip-collection">
    <Highlighter/>
    <InlineEditor v-show="inlineEditorEnabled"/>
  </div>
</template>
