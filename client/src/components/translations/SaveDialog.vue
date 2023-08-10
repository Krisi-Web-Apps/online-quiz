<template>
  <q-card style="width: 700px; max-width: 80vw">
    <q-card-section class="text-white bg-primary text-center">
      <div class="text-h6">
        {{ !translation.item.id ? $t('add_translation') : $t('edit_translation') }}
      </div>
    </q-card-section>

    <q-card-section>
      <q-form ref="translationForm" @submit="submit">
        <div class="q-mb-md">
          <q-input
            filled
            v-model="translation.item.name"
            :label="$t('name')"
            :hint="$t('enter_a_key_with_underscores')"
            autofocus
            :disable="translation.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
          >
            <template v-slot:prepend>
              <q-icon name="lock" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md">
          <q-input
            filled
            v-model="translation.item.text"
            :label="$t('text')"
            autofocus
            :disable="translation.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
          >
            <template v-slot:prepend>
              <q-icon name="article" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md">
          <q-select
            clearable
            filled
            v-model="translation.item.lang"
            :label="$t('lang')"
            :options="env.languages"
            :option-label="(val) => val.key"
            :option-value="(val) => val.value"
            emit-value
            map-options
          />
        </div>
      </q-form>
    </q-card-section>
    <q-card-actions class="text-white bg-secondary text-center">
      <q-btn
        flat
        :disable="translation.loading"
        :loading="translation.loading"
        no-caps
        @click="$.refs.translationForm.submit()"
      >
        {{ !translation.item.id ? $t('add_translation') : $t('edit_translation') }}
      </q-btn>
      <q-btn
        flat
        :label="$t('cancel')"
        :disable="translation.loading"
        no-caps
        v-close-popup
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { TranslationStore } from "src/stores/translation";

import { i18n } from "src/boot/i18n";

export default {
  setup() {
    const env = EnvStore();
    const translation = TranslationStore();
    const $t = i18n.global.t;

    const functions = {
      submit() {
        translation.saveItem((status, message) => {
          if (status == 201) {
            env.dialogs.translations.saving = false;
            env.ts($t("successful_created_translation"));
            setTimeout(() => {
              env.dialogs.translations.saving = true;
              translation.item = { lang: translation.item.lang }
            }, 500);
          }
          if (status >= 400) {
            env.te(message);
          }
        });
      },
    };

    return { env, translation, ...functions };
  },
};
</script>
