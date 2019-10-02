<script>

export default {
  computed: {
    hasNavigation() {
      return this.$slots.navigation !== undefined;
    },

    hasTopBar() {
      return this.$slots['top-bar'] !== undefined;
    },
  },
};

</script>

<template>
  <div class="flex bg-gray-200 h-screen w-screen">

    <div class="flex-shrink-0 w-64 bg-sapphire-500 text-white flex flex-col justify-between" v-if="hasNavigation">
      <slot name="navigation" />
    </div>

    <div class="flex-grow flex flex-col overflow-scroll" v-if="hasTopBar">
      <slot name="top-bar" />

      <div class="flex flex-grow">
        <slot />
      </div>
    </div>

  </div>
</template>
