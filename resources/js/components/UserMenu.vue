<script>

export default {
  props: {
    name: {
      type: String,
      required: true,
    },
  },
};

</script>

<template>
  <div class="user-menu">
    <div class="user-menu__user-name">
      {{ name }}
    </div>
  </div>
</template>
