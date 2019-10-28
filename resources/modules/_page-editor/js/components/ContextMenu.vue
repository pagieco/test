<script>

export default {
  data() {
    return {
      showContextMenu: false,
    };
  },
};

</script>

<template>
  <div class="context-menu" v-if="showContextMenu">
    <ul>
      <li>
        <a href="#">Duplicate</a>
      </li>
      <li>
        <a href="#">Remove</a>
      </li>
    </ul>
  </div>
</template>
