<template>
  <q-layout view="lHh Lpr lFf">
    <q-header>
      <navigation-bar />
      <left-drower />
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
    <user-dialogs />
  </q-layout>
</template>

<script>
import { defineComponent } from "vue";

import NavigationBar from "src/components/header/NavigationBar.vue";
import LeftDrower from "src/components/layout/LeftDrower.vue";
import UserDialogs from "src/components/users/UserDialogs.vue";

export default defineComponent({
  name: "MainLayout",
  components: {
    NavigationBar,
    LeftDrower,
    UserDialogs,
  }
});
</script>
