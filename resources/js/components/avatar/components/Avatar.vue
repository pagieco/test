<script>

import getInitials from '../utils/get-initials';

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

    /**
     * Changes the size of the avatar.
     */
    small: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    classList() {
      return [
        'avatar',
        { 'avatar--small': this.small },
      ];
    },

    initials() {
      const initials = getInitials(this.name);

      return this.small
        ? initials.substr(0, 1)
        : initials;
    },
  },
};

</script>

<template>
  <div class="bg-white rounded-full text-black text-sm flex items-center justify-center"
       :class="classList"
       :aria-label="accessibilityLabel || name">

    <span v-if="!src && name">
      {{ initials }}
    </span>

    <img role="presentation" v-if="src" :src="src" />
  </div>
</template>
