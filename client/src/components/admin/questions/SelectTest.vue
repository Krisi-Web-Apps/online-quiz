<template>
  <q-card class="medium-dialog">
    <q-card-section class="text-white bg-primary text-center">
      <div class="text-h6">
        {{ $t("select_test") }}
      </div>
    </q-card-section>
    <q-card-section>
      <q-list v-if="test.items.length > 0">
        <q-item
          clickable
          v-ripple
          v-for="(item, index) in test.items"
          :key="index"
          @click="onSelect(item.id)"
        >
          <q-item-section side>
            <q-icon name="arrow_forward_ios" />
          </q-item-section>
          <q-item-section>{{ item.name }}</q-item-section>
        </q-item>
      </q-list>
      <div v-else>{{ $t("select_test_no_records_msg") }}</div>
    </q-card-section>
    <q-card-actions class="text-white bg-secondary text-center">
      <q-btn
        flat
        :label="$t('cancel')"
        icon="close"
        no-caps
        v-close-popup
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { QuestionStore } from "src/stores/question";
import { TestStore } from "src/stores/test";

export default {
  setup() {
    const env = EnvStore();
    const question = QuestionStore();
    const test = TestStore();

    const functions = {
      onSelect(id) {
        question.item.test_id = id;
        env.dialogs.questions.selectTest = false;
        env.dialogs.questions.saving = true;
      }
    }

    test.getItems();

    return { test, ...functions };
  },
};
</script>
