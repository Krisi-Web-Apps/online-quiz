<template>
  <q-separator class="q-mb-md" />
  <div v-if="test.item.description">
    <div v-html="test.item.description"></div>
    <q-separator class="q-my-md" />
  </div>
  <div class="text-subtitle1">
    <span>{{ $t("number_of_questions_in_test") }}:</span>
    <span class="q-ml-sm">{{ test.item.number_of_questions }}</span>
  </div>
  <div class="text-center q-mt-lg">
    <q-btn
      icon="play_arrow"
      :label="$t('begin_test')"
      color="primary"
      size="24px"
      no-caps
      :loading="test.loading || question.loading"
      :disable="test.loading || question.loading"
      @click="onBeginingTest"
    />
  </div>
</template>

<script>
import { useRoute } from "vue-router";

import { EnvStore } from "src/stores/env";
import { TestStore, PlayTestStore } from "src/stores/test";
import { QuestionStore } from "src/stores/question";

export default {
  name: "DsiplayItem",
  setup() {
    const route = useRoute();
    const env = EnvStore();
    const test = TestStore();
    const playTest = PlayTestStore();
    const question = QuestionStore();

    const functions = {
      getItemBySlugCallBack(status, message) {
        if (status != 200) {
          env.te(message);
        }
      },
      getItemsCallBack(status, message) {
        if (status == 200) {
          playTest.beginTest = true;
        } else {
          env.te(message);
        }
      },
      onBeginingTest() {
        question.getItems(functions.getItemsCallBack, { test_id: test.item.id });
      }
    };

    test.item.slug = route.query.test_slug;
    test.getItemBySlug(functions.getItemBySlugCallBack);

    return { test, question, playTest, ...functions };
  },
};
</script>
