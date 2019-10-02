<script>

import { Avatar } from '../../avatar';

export default {
  components: {
    Avatar,
  },

  props: {
    name: {
      type: String,
      required: true,
    },

    picture: {
      type: String,
    },
  },
};

</script>

<template>
  <div class="flex items-center">
    <Avatar :name="name" :src="picture" />

    <div class="ml-2">
      {{ name }}
    </div>
  </div>
</template>
