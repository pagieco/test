<script>

export default {
  props: {
    content: {
      type: String,
      required: true,
    },
  },
};

</script>

<template>
  <div class="data-table__footer">
    {{ content }}
  </div>
</template>
