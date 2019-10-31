<script>

export default {
  data() {
    return {
      isLoading: false,
      currentCollectionId: null,
    };
  },

  computed: {
    entries() {
      return this.$store.getters['entry/entries'];
    },
  },

  created() {
    this.initComponentData();
  },

  watch: {
    $route() {
      if (Number(this.$route.params.id) !== Number(this.currentCollectionId)) {
        this.initComponentData();
      }
    },
  },

  methods: {
    initComponentData() {
      this.isLoading = true;
      this.currentCollectionId = this.$route.params.id;

      this.$store.dispatch('entry/fetchEntries', this.$route.params.id)
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
      <li v-for="entry in entries" :key="entry.id">
        <router-link :to="{ name: 'show-entry', params: { slug: entry.slug } }">
          {{ entry.name }}
        </router-link>
      </li>
    </ul>

    <RouterView/>

  </div>
</template>
