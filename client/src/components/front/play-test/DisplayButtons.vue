<template>
  <div class="text-center q-mt-md">
    <q-btn
      color="primary"
      no-caps
      @click="playTest.prevQuestion"
      :disable="playTest.currentQuestion <= 1"
      class="text-subtitle1"
    >
    <q-icon name="chevron_left" />
    <span>{{ $t(`prev_question`) }}</span>
  </q-btn>
    <q-btn
      color="primary"
      no-caps
      @click="playTest.nextQuestion"
      class="q-ml-md text-subtitle1"
    >
      {{
        playTest.getNumberOfRemainingQuestions > 1
          ? $t("next_question")
          : $t("end_quiz")
      }}
      <q-icon
        name="chevron_right"
        v-if="playTest.getNumberOfRemainingQuestions > 1"
      />
    </q-btn>
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
