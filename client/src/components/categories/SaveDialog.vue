<template>
  <q-card class="medium-dialog">
    <q-card-section class="text-white bg-primary text-center">
      <div class="text-h6">
        {{ !category.item.id ? $t("add_category") : $t("edit_category") }}
      </div>
    </q-card-section>
    <q-card-section>
      <q-form ref="categoryForm" @submit="submit" @keydown.enter="submit">
        <div class="q-mb-md">
          <q-input
            filled
            autofocus
            lazy-rules
            v-model="category.item.name"
            :label="$t('name')"
            :disable="category.loading"
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
            @update:model-value="generateSlug"
          >
            <template v-slot:prepend>
              <q-icon name="category" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md">
          <q-input
            filled
            autofocus
            v-model="category.item.slug"
            :label="$t('slug')"
            :disable="category.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
          >
            <template v-slot:prepend>
              <q-icon name="link" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md">
          <q-input
            type="textarea"
            filled
            autofocus
            v-model="category.item.description"
            :label="$t('description')"
            :disable="category.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
          >
            <template v-slot:prepend>
              <q-icon name="edit" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md">
          <q-select
            filled
            v-model="category.item.lang"
            :label="$t('language')"
            :disable="category.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
            :options="env.languages"
            emit-value
            map-options
            :option-label="val => val.key"
            :option-value="val => val.value"
          >
            <template v-slot:prepend>
              <q-icon name="language" />
            </template>
          </q-select>
        </div>
      </q-form>
    </q-card-section>
    <q-card-actions class="text-white bg-secondary text-center">
      <q-btn
        flat
        :disable="category.loading"
        :loading="category.loading"
        no-caps
        @click="$.refs.categoryForm.submit()"
        :label="!category.item.id ? $t('add_category') : $t('edit_category')"
        icon="add"
      />
      <q-btn
        flat
        :label="$t('cancel')"
        icon="close"
        :disable="category.loading"
        no-caps
        v-close-popup
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { i18n } from "src/boot/i18n";
import { CategoryStore } from "src/stores/category";
import { EnvStore } from "src/stores/env";

export default {
  setup() {
    const env = EnvStore();
    const category = CategoryStore();
    const $t = i18n.global.t;

    const functions = {
      callback() {
        env.dialogs.categories.saving = false;
        env.ts();
        category.getItems();
      },
      submit() {
        category.saveItem(functions.callback);
      },
      generateSlug(text) {
        const latinText = env.bulgarianToLatin(text);
        category.item.slug = latinText;
      }
    };

    return { env, category, ...functions };
  },
};
</script>
