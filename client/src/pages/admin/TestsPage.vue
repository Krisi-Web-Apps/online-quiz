<template>
  <q-page padding class="q-pt-none">
    <div class="container">
      <div class="flex justify-between items-center">
        <h1 class="text-h4 text-center">{{ $t("tests") }}</h1>
        <q-btn
          :label="$t('add_test')"
          icon="add"
          color="primary"
          @click="createOpen"
        />
      </div>
    </div>
    <q-dialog v-model="env.dialogs.tests.saving" @hide="onClose">
      <save-dialog />
    </q-dialog>
    <display-items />
  </q-page>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";
import { TestStore } from "src/stores/test";

import SaveDialog from "src/components/tests/SaveDialog.vue";
import DisplayItems from "src/components/tests/DisplayItems.vue";

export default {
  components: {
    SaveDialog,
    DisplayItems,
  },
  setup() {
    const env = EnvStore();
    const user = UserStore();
    const test = TestStore();

    const functions = {
      onClose() {},
      createOpen() {
        test.item = {
          lang: user.me.lang,
          description: ""
        };
        env.dialogs.tests.saving = true;
      },
    };

    test.getItems();

    return { env, ...functions };
  },
};
</script>
