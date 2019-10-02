<script>

import {
  Card,
  CardSection,
} from '../../../components';

export default {
  components: {
    Card,
    CardSection,
  },

  props: {
    assets: {
      type: Array,
      required: true,
    },
  },
};

</script>

<template>
  <div class="flex flex-wrap -ml-4">
    <div class="w-1/6 p-4" v-for="asset in assets" :key="asset.id">

      <Card interactive>
        <div class="flex justify-center relative">
          <div class="absolute top-0 right-0 mr-4 mt-4 bg-gray-700 text-white rounded px-1 text-xs">
            {{ asset.extension.toUpperCase() }}
          </div>

          <img :src="asset.thumb_url"/>
        </div>

        <CardSection>
          {{ asset.filename }}
        </CardSection>
      </Card>

    </div>
  </div>
</template>
