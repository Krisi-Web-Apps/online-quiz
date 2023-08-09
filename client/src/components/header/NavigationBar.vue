<template>
  <q-toolbar>
    <div class="container">
      <div class="flex">
        <q-toolbar-title>
          <span>Online Quiz</span>
          <q-btn
            icon="menu"
            flat
            fab-mini
            @click="env.layout.leftDrower = !env.layout.leftDrower"
            class="q-ml-md"
          />
        </q-toolbar-title>
        <div v-if="user.isLoggedIn">
          <q-btn
            icon="person"
            label="profile"
            flat
            no-caps
            @click="$router.push({ name: 'profile' })"
          />
          <q-btn icon="logout" label="logout" flat no-caps @click="logout" />
        </div>
        <div v-else>
          <q-btn
            icon="person"
            label="register"
            flat
            no-caps
            @click="registerOpen"
          />
          <q-btn icon="login" label="login" flat no-caps @click="loginOpen" />
        </div>
      </div>
    </div>
  </q-toolbar>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";

export default {
  name: "NavigationBar",
  setup() {
    const env = EnvStore();
    const user = UserStore();

    const functions = {
      registerOpen() {
        env.dialogs.users.register = true;
      },
      loginOpen() {
        env.dialogs.users.login = true;
      },
      logout() {
        user.logout();
        env.dialogs.users.login = true;
      },
    };

    return { env, user, ...functions };
  },
};
</script>
