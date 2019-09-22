<script>

import {
  Frame,
  TopBar,
  Navigation,
  NavigationItem,
  NavigationSection,
} from '../focus-ui/src';

export default {
  components: {
    Frame,
    TopBar,
    Navigation,
    NavigationItem,
    NavigationSection,
  },
};

</script>

<template>
  <Frame>
    <template v-slot:top-bar>
      <TopBar :user-menu="{
        name: appConfig.user.name,
        detail: appConfig.project.name,
      }" />
    </template>

    <template v-slot:navigation>
      <Navigation>
        <NavigationSection>
          <NavigationItem icon="home" label="Dashboard" :to="{ name: 'dashboard' }" />
        </NavigationSection>

        <NavigationSection title="Content">
          <NavigationItem icon="images" label="Assets" :to="{ name: 'assets' }" />
          <NavigationItem icon="newspaper" label="Pages" :to="{ name: 'pages' }" />
          <NavigationItem icon="database" label="Collections" :to="{ name: 'collections' }" />
        </NavigationSection>

        <NavigationSection title="Engagement">
          <NavigationItem icon="align-left" label="Forms" :to="{ name: 'forms' }" />
          <NavigationItem icon="envelope" label="Emails" :to="{ name: 'emails' }" />
          <NavigationItem icon="users" label="Profiles" :to="{ name: 'profiles' }" />
          <NavigationItem icon="reply-all" label="Automation" :to="{ name: 'automations' }" />
        </NavigationSection>

        <NavigationSection title="Management">
          <NavigationItem icon="globe" label="Domains" :to="{ name: 'domains' }" />
          <NavigationItem icon="code-branch" label="Workflows" :to="{ name: 'workflows' }" />
          <NavigationItem icon="cog" label="Settings" :to="{ name: 'settings' }" />
        </NavigationSection>
      </Navigation>
    </template>

    <RouterView :key="$route.fullPath" />
  </Frame>
</template>
