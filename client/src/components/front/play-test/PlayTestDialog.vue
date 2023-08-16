<template>
  <q-card
    class="medium-dialog"
    :class="$q.screen.width > 600 ? ' flex column justify-between' : ''"
  >
    <div>
      <display-question />
      <display-buttons class="q-my-md" />
      <display-info />
    </div>
    <footer-navbar />
  </q-card>
</template>

<script>
import { QuestionStore } from "src/stores/question";
import { PlayTestStore } from "src/stores/test";

import DisplayQuestion from "./DisplayQuestion.vue";
import DisplayButtons from "./DisplayButtons.vue";
import DisplayInfo from "./DisplayInfo.vue";
import FooterNavbar from "./FooterNavbar.vue";

export default {
  components: {
    DisplayQuestion,
    DisplayButtons,
    DisplayInfo,
    FooterNavbar,
  },
  setup() {
    const question = QuestionStore();
    const playTest = PlayTestStore();

    question.items.forEach(() => {
      playTest.items.push({ selectedQuestions: [] });
    });

    return { question, playTest };
  }
};
</script>
