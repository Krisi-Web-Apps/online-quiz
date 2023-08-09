<template></template>

<script>
import { EnvStore } from 'src/stores/env';
import { UserStore } from 'src/stores/user';

export default {
  setup() {
    const user = UserStore();
    const env = EnvStore();

    const token = JSON.parse(localStorage.getItem("token"));

    if (!token) {
      user.logout();
      env.dialogs.users.login = true;
    }

    user.afterLogin(token);
    user.getUser();
  }
};
</script>
