<script>

export default {
  computed: {
    entries() {
      return this.$store.getters['collection/collection'];
    },
  },
};

</script>

<template>
  <div>
    {{ entries }}
  </div>
</template>
