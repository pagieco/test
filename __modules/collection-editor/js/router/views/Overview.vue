<script>

export default {
  data() {
    return {
      isLoading: false,
    };
  },

  computed: {
    collections() {
      return this.$store.getters['collection/collections'];
    },
  },

  created() {
    this.initComponentData();
  },

  methods: {
    initComponentData() {
      this.isLoading = true;

      this.$store.dispatch('collection/fetchCollections')
        .then(() => {
          this.isLoading = false;
        });
    },
  },
};

</script>

<template>
  <div>

    <ul>
      <li v-for="collection in collections" :key="collection.id">
        <router-link :to="{ name: 'collection-entries', params: { id: collection.id } }">
          {{ collection.name }}
        </router-link>
      </li>
    </ul>

    <RouterView/>

  </div>
</template>
