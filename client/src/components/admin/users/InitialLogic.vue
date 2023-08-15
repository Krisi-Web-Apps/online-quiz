<template></template>

<script>
import { CategoryStore } from 'src/stores/category';
import { EnvStore } from 'src/stores/env';
import { UserStore } from 'src/stores/user';
import { useRoute } from 'vue-router';

export default {
  setup() {
    const user = UserStore();
    const env = EnvStore();
    const category = CategoryStore();
    const route = useRoute();

    const token = JSON.parse(localStorage.getItem("token"));

    if (!token) {
      user.logout();
      env.dialogs.users.login = true;
      return;
    }

    function getTranslations() {
      if (route.name == "categories") {
        category.item.lang = user.me.lang;
        category.getItems();
      }
    }

    user.afterLogin(token);
    user.getUser(getTranslations);
  }
};
</script>
