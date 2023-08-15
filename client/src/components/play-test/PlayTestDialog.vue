<template>
  <q-card class="medium-dialog flex column justify-between">
    <div>
      <q-card-section class="bg-grey-2">
        <div class="text-h6 text-center">{{ question.item.title }}</div>
      </q-card-section>
      <q-separator class="q-my-md" />
      <q-list>
        <div v-for="(item, index) in question.item.answers" :key="index">
          <q-item
            :class="`text-subtitle1
            ${playTest.selectedIndex == index ? 'text-white bg-primary' : ''}`"
            @click="selectAnswer(index)"
          >
            <q-checkbox
              v-model="playTest.selectedIndexes"
              :val="index"
              color="primary"
              :label="item.text"
            />
          </q-item>
        </div>
      </q-list>
      <q-separator class="q-my-md" />
      <div class="text-center">
        <q-btn
          icon-right="chevron_right"
          :label="$t('next_question')"
          class="text-subtitle1"
          color="primary"
          no-caps
          @click="onAnswer"
          :disable="playTest.selectedIndexes.length == 0"
          v-if="playTest.checkNextQuestionExists"
        />
        <q-btn
          :label="$t('end_quiz')"
          class="text-subtitle1"
          color="primary"
          no-caps
          @click="stop"
          v-else
        />
      </div>
    </div>
    <q-card-actions class="bg-grey-2">
      <q-btn
        icon="stop"
        :label="$t('stop_test')"
        color="negative"
        flat
        no-caps
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { QuestionStore } from "src/stores/question";
import { PlayTestStore } from "src/stores/test";

export default {
  created() {
    this.getTheQuestion();
  },
  setup() {
    const question = QuestionStore();
    const playTest = PlayTestStore();

    return { question, playTest };
  },
  methods: {
    next() {
      this.playTest.nextQuestion();
      this.getTheQuestion();
    },
    getTheQuestion() {
      this.question.item =
        this.question.items[this.playTest.currentQuestion - 1];
    },
    onAnswer() {
      this.saveAnswers();
      this.clearCurrentStateAnswers();
      this.next();
    },
    saveAnswers() {
      this.playTest.answeredQuestions.push({
        answerNumber: this.playTest.currentQuestion,
        selectedIndexes: this.playTest.selectedIndexes
      });
    },
    clearCurrentStateAnswers() {
      this.playTest.selectedIndexes = [];
    },
    stop() {
      this.playTest.completedTest = true;
      this.playTest.stop();
    },
  },
};
</script>
