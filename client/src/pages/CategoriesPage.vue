<template>
  <div class="container">
    <div class="flex justify-between items-center">
      <h1 class="text-h4 text-center">{{ $t("categories") }}</h1>
      <q-btn :label="$t('add_category')" color="primary" @click="createOpen" />
    </div>
  </div>
  <q-dialog v-model="env.dialogs.categories.saving">
    <save-dialog />
  </q-dialog>
</template>

<script>
import { CategoryStore } from "src/stores/category";
import { EnvStore } from "src/stores/env";

import SaveDialog from "src/components/categories/SaveDialog.vue";
import { UserStore } from "src/stores/user";

export default {
  components: {
    SaveDialog,
  },
  setup() {
    const env = EnvStore();
    const user = UserStore();
    const category = CategoryStore();

    const functions = {
      createOpen() {
        category.item = { lang: user.me.lang }
        env.dialogs.categories.saving = true;
      },
    };

    return { env, category, ...functions };
  },
};
</script>
