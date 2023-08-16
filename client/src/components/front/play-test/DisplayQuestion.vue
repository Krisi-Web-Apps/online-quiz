<template>
  <div>
    <q-card-section class="bg-grey-2 text-center text-subtitle1">
      {{ question.items[playTest.currentQuestion - 1].title }}
    </q-card-section>
    <q-list>
      <q-item
        v-for="(item, index) in question.items[playTest.currentQuestion - 1]
          .answers"
        :key="index"
      >
        <q-checkbox
          v-model="
            playTest.items[playTest.currentQuestion - 1].selectedQuestions
          "
          :val="index"
          color="primary"
          :label="item.text"
          class="text-subtitle1"
        />
      </q-item>
    </q-list>
  </div>
</template>

<script>
import { QuestionStore } from "src/stores/question";
import { PlayTestStore } from "src/stores/test";

export default {
  setup() {
    const question = QuestionStore();
    const playTest = PlayTestStore();
    return { question, playTest };
  },
};
</script>
