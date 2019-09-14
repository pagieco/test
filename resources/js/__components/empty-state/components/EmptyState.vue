<script>

export default {
  /**
   * The component's properties.
   */
  props: {
    heading: {
      type: String,
    },
  },
};

</script>

<template>
  <div class="flex mx-auto">
    <div class="w-1/3 pt-12">
      <h3 class="text-3xl">No assets</h3>

      <button>Upload assets</button>
    </div>
    <div class="w-2/3">
      <img src="/img/upload-assets.svg" class="-ml-16">
    </div>
  </div>
</template>
