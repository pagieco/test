<script>

import { Avatar, Popover } from '../..';

export default {
  /**
   * The child components.
   */
  components: {
    Avatar,
    Popover,
  },

  /**
   * The component's properties.
   */
  props: {
    name: {
      type: String,
      required: true,
    },

    detail: {
      type: String,
    },
  },

  /**
   * The component's data.
   */
  data() {
    return {
      showDropdown: false,
    };
  },

  /**
   * The components methods.
   */
  methods: {
    toggleDropdown() {
      this.$refs.popover.toggle(document.getElementById('user-menuBtn'));
    },
  },
};

</script>

<template>
  <div class="relative">
    <button class="flex items-center" @click.prevent="toggleDropdown" id="user-menuBtn">
      <Avatar small :name="name" />
      <div class="ml-2 text-left" id="button">
        <div>{{ name }}</div>
        <div v-if="detail">{{ detail }}</div>
      </div>
    </button>

    <Popover ref="popover" placement="bottom-end">
      <div class="w-64 text-gray-800 text-sm bg-white rounded shadow">
        <ul>
          <li class="border-b">
            <a href="#" class="block p-2">My profile</a>
          </li>
          <li>
            <a href="#" class="block p-2">Sign-out</a>
          </li>
        </ul>
      </div>
    </Popover>

  </div>
</template>
