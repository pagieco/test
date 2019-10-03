<script>

export default {
  props: {
    title: {
      type: String,
      required: true,
    },
  },

  computed: {
    hasNavigation() {
      return this.$slots.navigation !== undefined;
    },
  },
};

</script>

<template>
  <div class="flex w-full">

    <div class="flex w-full">
      <div class="w-64 flex-shrink-0" v-if="hasNavigation">
        <slot name="navigation" />
      </div>

      <div class="flex-grow bg-gray-100">
        <div :class="!hasNavigation ? `max-w-5xl mx-auto` : ''">
          <div class="m-8">
            <h1 class="text-2xl mb-8">{{ title }}</h1>

            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
