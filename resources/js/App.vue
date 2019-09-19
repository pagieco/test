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
          <NavigationItem icon="newspaper" label="Pages" />
          <NavigationItem icon="database" label="Collections" />
        </NavigationSection>

        <NavigationSection title="Engagement">
          <NavigationItem icon="align-left" label="Forms" />
          <NavigationItem icon="envelope" label="Emails" />
          <NavigationItem icon="users" label="Profiles" />
          <NavigationItem icon="reply-all" label="Automation" />
        </NavigationSection>

        <NavigationSection title="Management">
          <NavigationItem icon="globe" label="Domains" />
          <NavigationItem icon="code-branch" label="Workflows" />
          <NavigationItem icon="cog" label="Settings" />
        </NavigationSection>
      </Navigation>
    </template>

    <RouterView :key="$route.fullPath" />
  </Frame>
</template>
