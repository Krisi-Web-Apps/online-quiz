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
import NavigationBar from "src/components/admin/header/NavigationBar.vue";
import LeftDrower from "src/components/admin/layout/LeftDrower.vue";
import UserDialogs from "src/components/admin/users/UserDialogs.vue";

export default {
  components: {
    NavigationBar,
    LeftDrower,
    UserDialogs,
  },
};
</script>
