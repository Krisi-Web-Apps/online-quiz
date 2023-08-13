<template>
  <q-page padding class="q-pt-none">
    <div class="container">
      <div class="flex justify-between items-center">
        <h1 class="text-h4 text-center">{{ $t("questions") }}</h1>
        <q-btn
          :label="$t('add_question')"
          icon="add"
          color="primary"
          @click="createOpen"
        />
      </div>
    </div>
    <q-dialog
      v-model="env.dialogs.questions.saving"
      @hide="onClose"
      :maximized="$q.screen.width <= 600"
    >
      <save-dialog />
    </q-dialog>
    <display-items />
  </q-page>
</template>

<script>
import { EnvStore } from "src/stores/env";

import SaveDialog from "src/components/questions/SaveDialog.vue";
import DisplayItems from "src/components/questions/DisplayItems.vue";

export default {
  components: {
    SaveDialog,
    DisplayItems,
  },
  setup() {
    const env = EnvStore();

    const functions = {
      onClose() {},
      createOpen() {
        env.dialogs.questions.saving = true;
      },
    };

    return { env, ...functions };
  },
};
</script>
