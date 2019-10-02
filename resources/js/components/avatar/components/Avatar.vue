<script>

import getInitials from '../utils/getInitials';

export default {
  props: {
    /**
     * Accessible label for the avatar image.
     */
    accessibilityLabel: {
      type: String,
    },

    /**
     * The source of the avatar image.
     */
    src: {
      type: String,
    },

    /**
     * The user's name.
     */
    name: {
      type: String,
      required: true,
    },
  },

  computed: {
    initials() {
      return getInitials(this.name);
    },
  },
};

</script>

<template>
  <div class="rounded-full h-8 w-8 flex items-center justify-center bg-white relative overflow-hidden">
    <span v-if="!src && name" class="absolute">
      {{ initials }}
    </span>

    <img role="presentation" v-if="src" :src="src" />
  </div>
</template>
