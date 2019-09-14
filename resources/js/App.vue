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
          <NavigationItem label="Dashboard" :to="{ name: 'dashboard' }" />
        </NavigationSection>

        <NavigationSection title="Content">
          <NavigationItem label="Assets" :to="{ name: 'assets' }" />
          <NavigationItem label="Pages" />
          <NavigationItem label="Collections" />
        </NavigationSection>

        <NavigationSection title="Engagement">
          <NavigationItem label="Forms" />
          <NavigationItem label="Emails" />
          <NavigationItem label="Profiles" />
          <NavigationItem label="Automation" />
        </NavigationSection>

        <NavigationSection title="Management">
          <NavigationItem label="Domains" />
          <NavigationItem label="Workflows" />
          <NavigationItem label="Settings" />
        </NavigationSection>
      </Navigation>
    </template>

    <RouterView :key="$route.fullPath" />
  </Frame>
</template>
