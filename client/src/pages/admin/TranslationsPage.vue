<template>
  <q-page padding class="q-pt-none">
    <div class="container">
      <div class="flex justify-between items-center">
        <h1 class="text-h4 text-center">{{ $t("translations") }}</h1>
        <q-btn
          :label="$t('add_translation')"
          icon="add"
          color="primary"
          @click="createOpen"
        />
      </div>
    </div>
    <q-dialog v-model="env.dialogs.translations.saving" @hide="onClose">
      <save-dialog />
    </q-dialog>
    <language-tabs />
  </q-page>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { TranslationStore } from "src/stores/translation";

import SaveDialog from "src/components/translations/SaveDialog.vue";
import LanguageTabs from "src/components/translations/LanguageTabs.vue";

export default {
  components: {
    SaveDialog,
    LanguageTabs,
  },
  setup() {
    const env = EnvStore();
    const translation = TranslationStore();

    const functions = {
      onClose() {
        env.dialogs.translations.isSecondLang = false;
      },
      createOpen() {
        env.dialogs.translations.saving = true;
        translation.item = { lang: translation.tab };
      },
    };

    return { env, translation, ...functions };
  },
};
</script>
