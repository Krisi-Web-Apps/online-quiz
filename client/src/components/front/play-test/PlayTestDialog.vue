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
        <!-- <q-btn
          icon="chevron_left"
          :label="$t('prev_question')"
          class="text-subtitle1 q-mr-md"
          color="primary"
          no-caps
          @click="onPrev"
          :disable="playTest.currentQuestion <= 1"
        /> -->
        <q-btn
          icon-right="chevron_right"
          :label="$t(`${playTest.checkNextQuestionExists ? 'next_question' : 'end_quiz'}`)"
          class="text-subtitle1"
          color="primary"
          no-caps
          @click="onAnswer"
          :disable="playTest.selectedIndexes.length == 0"
        />
      </div>
    </div>
    <ul>
      <li>
        <div class="text-subtitle1">
          <span class="q-mr-sm">{{ $t("corrent_question") }}:</span>
          <span>{{ playTest.currentQuestion }}</span>
        </div>
      </li>
      <li>
        <div class="text-subtitle1">
          <span class="q-mr-sm">{{ $t("remaining_questions") }}:</span>
          <span>{{ playTest.getNumberOfRemainingQuestions }}</span>
        </div>
      </li>
    </ul>
    <q-card-actions class="bg-grey-2">
      <q-btn
        icon="stop"
        :label="$t('stop_test')"
        color="negative"
        flat
        no-caps
        v-close-popup
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
      this.isValidAnswer();
      this.playTest.answeredQuestions.push(this.playTest.selectedIndexes);
      this.clearCurrentStateAnswers();
      this.next();
    },
    clearCurrentStateAnswers() {
      this.playTest.selectedIndexes = [];
    },
    stop() {
      this.playTest.completedTest = true;
      this.playTest.stop();
    },
    isValidAnswer() {
      let isValid = true;

      this.playTest.selectedIndexes.forEach((index) => {
        if (!this.question.item.answers[index].is_correct) {
          isValid = false;
        }
      });

      if (isValid) this.playTest.results.numberOfPassedQuestions++;
      else this.playTest.results.numberOfFaliedQuestions++;
    },
    // onPrev() {
    //   this.playTest.prevQuestion();
    //   this.getTheQuestion();
    //   this.playTest.selectedIndexes = this.playTest.answeredQuestions.pop();
    // }
  },
};
</script>
