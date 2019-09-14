<script>

export default {
  /**
   * The component's properties.
   */
  props: {
    title: {
      type: String,
      required: true,
    },
  },
};

</script>

<template>
  <div class="px-4 py-8 mx-auto w-full max-w-6xl">
    <div class="pt-4 pb-8">
      {{ title }}
    </div>

    <slot />
  </div>
</template>
