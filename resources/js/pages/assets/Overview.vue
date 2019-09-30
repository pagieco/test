<script>

import { mapGetters, mapActions } from 'vuex';

export default {
  computed: {
    ...mapGetters({
      folders: 'asset/folders',
      assets: 'asset/assets',
    }),
  },

  mounted() {
    this.init();
  },

  methods: {
    ...mapActions({
      fetchFolders: 'asset/fetchFolders',
      fetchAssets: 'asset/fetchAssets',
    }),

    init() {
      this.fetchFolders();
      this.fetchAssets();
    },
  },
};

</script>

<template>
  <div class="flex h-full">

    <div class="flex-shrink-0 w-64">
      <div class="py-8">
        <div class="flex justify-between items-center px-8">
          <h4 class="text-xs text-gray-700 uppercase font-bold tracking-widest">Folders</h4>
          <button class="appearance-none bg-green-500 text-white px-4 py-1 rounded text-xs">Add</button>
        </div>

        <ul class="mt-3">
          <li v-for="folder in folders" :key="folder.id">
            <a class="py-2 px-4 block hover:bg-gray-100" href="#">
              {{ folder.name }}
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="flex-grow flex p-8 bg-gray-100">
      <div class="w-full">
        <div class="flex flex-wrap">
          <div v-for="asset in assets" :key="asset.id" class="w-1/6 border bg-white mb-4 mr-4 rounded">
            <img :src="asset.thumb_url" alt="">
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
