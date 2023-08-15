<template>
  <q-toolbar>
    <div class="container">
      <div class="flex">
        <q-toolbar-title>
          <span>{{ $t("online_quiz") }}</span>
          <q-btn
            icon="menu"
            flat
            fab-mini
            @click="env.layout.leftDrower = !env.layout.leftDrower"
            class="q-ml-md"
            v-if="user.isLoggedIn"
          />
        </q-toolbar-title>
        <div v-if="user.isLoggedIn">
          <q-btn
            icon="person"
            :label="$t('profile')"
            flat
            no-caps
            @click="$router.push({ name: 'profile' })"
          />
          <q-btn
            icon="logout"
            :label="$t('logout')"
            flat
            no-caps
            @click="logout"
          />
        </div>
        <div v-else>
          <q-btn
            icon="person"
            :label="$t('register')"
            flat
            no-caps
            @click="registerOpen"
          />
          <q-btn
            icon="login"
            :label="$t('login')"
            flat
            no-caps
            @click="loginOpen"
          />
        </div>
      </div>
    </div>
  </q-toolbar>
</template>

<script>
import { useRouter } from "vue-router";

import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";

export default {
  name: "NavigationBar",
  setup() {
    const env = EnvStore();
    const user = UserStore();
    const router = useRouter();

    return { env, user, router };
  },
  methods: {
    registerOpen() {
      this.env.dialogs.users.register = true;
    },
    loginOpen() {
      this.env.dialogs.users.login = true;
    },
    logout() {
      this.user.logout();
      this.router.push({ name: "home" }).then(() => {
        this.env.dialogs.users.login = true;
      });
    },
  },
};
</script>
