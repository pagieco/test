<script>

import { serialize } from '../dom';
import { getIframeDocument } from '../iframe';

export default {
  methods: {
    publish() {
      const rootNode = getIframeDocument().querySelector('body');

      const serialized = serialize(rootNode);

      console.log(serialized);
    },
  },
};

</script>

<template>
  <div>
    <button @click="publish">Publish changes</button>
  </div>
</template>
