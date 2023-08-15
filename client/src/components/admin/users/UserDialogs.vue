<template>
  <initial-logic />
  <q-dialog v-model="env.dialogs.users.register" persistent>
    <register-dialog />
  </q-dialog>
  <q-dialog v-model="env.dialogs.users.login" persistent>
    <login-dialog />
  </q-dialog>
</template>

<script>
import { EnvStore } from "src/stores/env";
import InitialLogic from "src/components/admin/users/InitialLogic.vue";
import RegisterDialog from "src/components/admin/users/RegisterDialog.vue";
import LoginDialog from "src/components/admin/users/LoginDialog.vue";

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
