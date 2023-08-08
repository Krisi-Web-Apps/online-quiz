<template>
  <q-dialog v-model="env.dialogs.users.register">
    <register-dialog />
  </q-dialog>
</template>

<script>
import { EnvStore } from "src/stores/env";
import RegisterDialog from "src/components/users/RegisterDialog.vue";

export default {
  name: "UserDialogs",
  components: {
    RegisterDialog,
  },
  setup() {
    const env = EnvStore();
    return { env }
  }
};
</script>
