<template>
  <div class="container">
    <div class="flex justify-between items-center">
      <h1 class="text-h4 text-center">{{ $t("translations") }}</h1>
      <q-btn :label="$t('add_translation')" color="primary" @click="createOpen" />
    </div>
  </div>
  <q-dialog v-model="env.dialogs.translations.saving">
    <save-dialog />
  </q-dialog>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { TranslationStore } from "src/stores/translation";

import SaveDialog from "src/components/translations/SaveDialog.vue";

export default {
  components: {
    SaveDialog,
  },
  setup() {
    const env = EnvStore();
    const translation = TranslationStore();

    const functions = {
      createOpen() {
        env.dialogs.translations.saving = true;
        translation.item = { lang: "bg" }
      },
    };

    return { env, translation, ...functions };
  },
};
</script>
