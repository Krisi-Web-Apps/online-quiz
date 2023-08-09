<template></template>

<script>
import { EnvStore } from 'src/stores/env';
import { TranslationStore } from 'src/stores/translation';
import { UserStore } from 'src/stores/user';

export default {
  setup() {
    const user = UserStore();
    const env = EnvStore();
    const translation = TranslationStore();

    const token = JSON.parse(localStorage.getItem("token"));

    if (!token) {
      user.logout();
      env.dialogs.users.login = true;
      return;
    }

    function getTranslations() {
      translation.getItemsByUserLang(user.lang);
    }

    user.afterLogin(token);
    user.getUser(getTranslations);
  }
};
</script>
