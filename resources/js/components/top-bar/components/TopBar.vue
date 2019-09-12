<script>

import UserMenu from './UserMenu.vue';
import SearchField from './SearchField.vue';

export default {
  components: {
    UserMenu,
    SearchField,
  },
};

</script>

<template>
  <header class="text-white px-4 h-16 flex items-center justify-between">
    <div class="w-1/4">
      <SearchField />
    </div>

    <div>

      <UserMenu />

    </div>
  </header>
</template>
