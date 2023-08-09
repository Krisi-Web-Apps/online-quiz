<template>
  <initial-logic />
  <q-dialog v-model="env.dialogs.users.register">
    <register-dialog />
  </q-dialog>
  <q-dialog v-model="env.dialogs.users.login">
    <login-dialog />
  </q-dialog>
</template>

<script>
import { EnvStore } from "src/stores/env";
import InitialLogic from "src/components/users/InitialLogic.vue";
import RegisterDialog from "src/components/users/RegisterDialog.vue";
import LoginDialog from "src/components/users/LoginDialog.vue";

export default {
  name: "UserDialogs",
  components: {
    InitialLogic,
    RegisterDialog,
    LoginDialog,
  },
  setup() {
    const env = EnvStore();
    return { env }
  }
};
</script>
