<script>

import { mapGetters } from 'vuex';
import { Page, Card, DataTable } from '../../components';

export default {
  components: { Page, Card, DataTable },

  metaInfo: {
    title: 'Profiles',
  },

  watch: {
    $route: 'initComponent',
  },

  data() {
    return {
      loading: false,
    };
  },

  computed: {
    profiles() {
      return this.$store.getters['profile/profiles'].map((profile) => {
        return [
          `${profile.first_name} ${profile.last_name}`,
          profile.email,
        ];
      });
    },
  },

  mounted() {
    this.initComponent();
  },

  methods: {
    initComponent() {
      this.loading = true;

      this.$store.dispatch('profile/fetchProfiles')
        .then(() => {
          this.loading = false;
        });
    },
  },
};

</script>

<template>
  <Page title="Profiles">

    <span v-if="loading">loading...</span>

    <Card>
      <DataTable :rows="profiles"
                 :columnContentTypes="['text', 'text']"
                 :headings="['Name', 'Email']" />
    </Card>

<!--
    <ul>
      <li v-for="event in profileEvents" :key="event.id">
        {{ event.event_type }}
      </li>
    </ul>

    <Card sectioned>
      <ul>
        <li v-for="profile in profiles" :key="profile.id">
          <div>
            <span>{{ profile.first_name }} {{ profile.last_name }}</span>
            <span>{{ profile.email }}</span>
          </div>

          <span>
            <button @click="openProfile(profile.id)">
              {{ profile.id }} - {{ profile.profile_id }}
            </button>
          </span>
        </li>
      </ul>
    </Card>
    -->

  </Page>
</template>
