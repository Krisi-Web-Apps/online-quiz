<template>
  <q-card style="width: 700px; max-width: 80vw">
    <q-card-section class="text-white bg-primary text-center">
      <div class="text-h6">
        {{ !test.item.id ? $t("add_test") : $t("edit_test") }}
      </div>
    </q-card-section>
    <q-card-section>
      <q-form ref="testForm" @submit="submit">
        <div class="q-mb-md">
          <q-input
            filled
            autofocus
            lazy-rules
            v-model="test.item.name"
            :label="$t('name')"
            :disable="test.loading"
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
            @update:model-value="generateSlug"
          >
            <template v-slot:prepend>
              <q-icon name="quiz" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md">
          <q-input
            filled
            autofocus
            v-model="test.item.slug"
            :label="$t('slug')"
            :disable="test.loading"
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
            v-model="test.item.description"
            :label="$t('description')"
            :disable="test.loading"
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
            v-model="test.item.lang"
            :label="$t('language')"
            :disable="test.loading"
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
        <div class="q-mb-md">
          <q-select
            emit-value
            map-options
            filled
            lazy-rules
            v-model="test.item.category_id"
            :label="$t('category')"
            :disable="test.loading"
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
            :option-label="val => val.name"
            :option-value="val => val.id"
            :options="category.items"
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
        :disable="test.loading"
        :loading="test.loading"
        no-caps
        @click="$.refs.testForm.submit()"
        :label="!test.item.id ? $t('add_test') : $t('edit_test')"
        icon="add"
      />
      <q-btn
        flat
        :label="$t('cancel')"
        icon="close"
        :disable="test.loading"
        no-caps
        v-close-popup
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { TestStore } from "src/stores/test";
import { EnvStore } from "src/stores/env";
import { CategoryStore } from "src/stores/category";

export default {
  setup() {
    const env = EnvStore();
    const test = TestStore();
    const category = CategoryStore();

    const functions = {
      callback() {
        env.dialogs.tests.saving = false;
        env.ts();
        test.getItems();
      },
      submit() {
        test.saveItem(functions.callback);
      },
      generateSlug(text) {
        const latinText = env.bulgarianToLatin(text);
        test.item.slug = latinText;
      }
    };

    category.getItems();

    return { env, category, test, ...functions };
  },
};
</script>
