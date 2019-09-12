<script>

export default {
  // ...
};

</script>

<template>
  <div class="flex flex-col flex-grow">

    <div class="text-white h-16 px-4 flex items-center">
      App Title
    </div>

    <div class="flex flex-col flex-grow bg-gray-200 border-r p-4">
      <ul class="mb-6">
        <li>
          <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
        </li>
      </ul>

      <ul class="mb-6">
        <li class="uppercase font-bold text-xs text-gray-500">
          <span>Content</span>
        </li>

        <li>
          <router-link :to="{ name: 'assets' }">Assets</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'pages' }">Pages</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'collections' }">Collections</router-link>
        </li>
      </ul>

      <ul class="mb-6">
        <li class="uppercase font-bold text-xs text-gray-500">
          <span>Engagement</span>
        </li>

        <li>
          <router-link :to="{ name: 'forms' }">Forms</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'emails' }">Emails</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'profiles' }">Profiles</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'automations' }">Automation</router-link>
        </li>
      </ul>

      <ul class="mb-6">
        <li class="uppercase font-bold text-xs text-gray-500">
          <span>Management</span>
        </li>

        <li>
          <router-link :to="{ name: 'domains' }">Domains</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'workflows' }">Workflows</router-link>
        </li>
        <li>
          <router-link :to="{ name: 'workflows' }">Settings</router-link>
        </li>
      </ul>

    </div>
  </div>
</template>
