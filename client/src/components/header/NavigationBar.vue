<template>
  <q-toolbar>
    <div class="container">
      <div class="flex">
        <q-toolbar-title> Online Quiz </q-toolbar-title>
        <div>
          <q-btn icon="person" label="register" flat @click="registerOpen" />
        </div>
      </div>
    </div>
  </q-toolbar>
</template>

<script>
import { EnvStore } from "src/stores/env";

export default {
  name: "NavigationBar",
  setup() {
    const env = EnvStore();

    const functions = {
      registerOpen() {
        env.dialogs.users.register = true;
      }
    }

    return { ...functions }
  }
};
</script>
