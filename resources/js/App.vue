<script>

import UserMenu from './components/UserMenu.vue';

export default {
  components: {
    UserMenu,
  },
};

</script>

<template>
  <div class="text-gray-900 antialiased">
    <div class="min-h-screen flex bg-gray-200">
      <div class="flex-shrink-0 w-64 bg-sapphire-500 flex justify-between flex-col">

        <div>
          <div class="px-6 py-6">
            <ul class="mt-3 text-white">
              <li class="mt-3">
                <router-link :to="{ name: 'dashboard' }" class="block">Dashboard</router-link>
              </li>
            </ul>
          </div>

          <div class="px-6 py-6">
            <h4 class="text-xs text-sapphire-400 uppercase font-bold tracking-widest">Content</h4>

            <ul class="mt-3 text-white">
              <li class="mt-3">
                <router-link :to="{ name: 'assets' }" class="block">Assets</router-link>
              </li>
              <li class="mt-3">
                <router-link :to="{ name: 'pages' }" class="block">Pages</router-link>
              </li>
              <li class="mt-3">
                <router-link :to="{ name: 'collections' }" class="block">Collections</router-link>
              </li>
            </ul>
          </div>

          <div class="px-6 py-6">
            <h4 class="text-xs text-sapphire-400 uppercase font-bold tracking-widest">Engagement</h4>

            <ul class="mt-3 text-white">
              <li class="mt-3">
                <router-link :to="{ name: 'forms' }" class="block">Forms</router-link>
              </li>
              <li class="mt-3">
                <router-link :to="{ name: 'emails' }" class="block">Emails</router-link>
              </li>
              <li class="mt-3">
                <router-link :to="{ name: 'profiles' }" class="block">Profiles</router-link>
              </li>
              <li class="mt-3">
                <router-link :to="{ name: 'automations' }" class="block">Automations</router-link>
              </li>
            </ul>
          </div>
        </div>

        <div class="bottom text-white">
          <div class="px-6 py-6">
            <h4 class="text-xs text-sapphire-400 uppercase font-bold tracking-widest">Management</h4>

            <ul class="mt-3 text-white">
              <li class="mt-3">
                <router-link :to="{ name: 'domains' }" class="block">Domains</router-link>
              </li>
              <li class="mt-3">
                <router-link :to="{ name: 'workflows' }" class="block">Workflows</router-link>
              </li>
              <li class="mt-3">
                <router-link :to="{ name: 'settings' }" class="block">Settings</router-link>
              </li>
            </ul>
          </div>

          <div class="px-6 py-6">
            <UserMenu :name="appConfig.user.name" />
          </div>
        </div>

      </div>

      <div class="flex-grow flex flex-col">
        <div class="relative bg-white flex-shink-0">

          <div class="flex justify-between items-center h-16 px-12">
            header
          </div>

        </div>
        <div class="flex-grow flex flex-col">
          <div class="flex-grow">

            <RouterView :key="$route.fullPath" />

          </div>
        </div>
      </div>
    </div>
  </div>
</template>
