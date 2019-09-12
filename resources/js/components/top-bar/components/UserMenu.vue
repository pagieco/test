<script>

import { Avatar, Popover } from '../..';

export default {
  components: {
    Avatar,
    Popover,
  },

  data() {
    return {
      showDropdown: false,
    };
  },

  methods: {
    toggleDropdown(e) {
      this.$refs.popover.toggle(e.target);
      // this.showDropdown = !this.showDropdown;
    },
  },
};

</script>

<template>
  <div class="relative">
    <button class="flex items-center" @click.prevent.stop="toggleDropdown">
      <Avatar small name="Jelle Spekken" />
      <div class="ml-2 text-left" id="button">
        <div>Jelle Spekken</div>
        <div>Wildcats</div>
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
