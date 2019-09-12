<script>

export default {
  props: {
    title: {
      type: String,
      required: true,
    },
  },
};

</script>

<template>
  <div class="py-8 mx-auto w-full max-w-6xl">
    <div class="p-4 pb-8">
      {{ title }}
    </div>
  </div>
</template>
