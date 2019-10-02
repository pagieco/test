<script>

import { find } from 'lodash';
import http from '../services/http';

export default {
  data() {
    return {
      currentProject: window.appConfig.project,
      userProjects: window.appConfig.user.projects,
      menuOpen: false,
    };
  },

  methods: {
    switchProject(id) {
      const project = find(this.userProjects, p => p.id === id);

      http.post(project.links.switch).then(() => {
        window.location.reload();
      });
    },

    toggleMenu() {
      this.menuOpen = !this.menuOpen;
    },
  },
};

</script>

<template>
  <div class="px-6 py-6">
    <div class="relative">
      <a class="appearance-none block text-white border rounded p-2 cursor-pointer" @click="toggleMenu">
        {{ currentProject.name }}
      </a>

      <div class="absolute bg-white w-full rounded shadow mt-1 overflow-hidden" v-if="menuOpen">
        <ul>
          <li v-for="project in userProjects" :key="project.id">
            <a @click="switchProject(project.id)" class="cursor-pointer p-2 block hover:bg-gray-100">
              {{ project.name }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
