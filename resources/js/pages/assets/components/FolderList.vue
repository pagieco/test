<script>

export default {
  props: {
    folders: {
      type: Array,
      required: true,
    },
  },
};

</script>

<template>
  <div>
    <ul>
      <li v-for="folder in folders" :key="folder.id">
        <a href="#">{{ folder.name }}</a>
      </li>
    </ul>
  </div>
</template>
