import { defineStore } from "pinia";
import { api } from "src/boot/axios";
import { i18n } from "src/boot/i18n";
import { QuestionStore } from "./question";

const $t = i18n.global.t;

export const TestStore = defineStore("test", {
  state: () => ({
    loading: false,
    url: "/tests",
    searchTerm: "",
    item: {},
    items: [],
    columns: [
      {
        name: "name",
        required: true,
        label: $t("name"),
        align: "left",
        field: (row) => row.name,
        format: (val) => `${val}`,
        sortable: true,
      },
      {
        name: "question_count",
        required: true,
        label: $t("question_count"),
        align: "left",
        field: (row) => row.question_count,
        format: (val) => `${val}`,
        sortable: true,
      },
      {
        name: "category_name",
        required: true,
        label: $t("category_name"),
        align: "left",
        field: (row) => row.category_name,
        format: (val) => `${val}`,
        sortable: true,
      },
      {
        name: "lang",
        required: true,
        label: $t("language"),
        align: "left",
        field: (row) => row.lang,
        format: (val) => `${val}`,
        sortable: true,
      },
      {
        name: "options",
        required: true,
        label: $t("options"),
        align: "right",
      },
    ],
  }),
  actions: {
    getItem(cb) {
      this.loading = true;
      api
        .get(this.url, {
          params: {
            id: this.item.id,
          },
        })
        .then((res) => {
          this.item = res.data;
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => (this.loading = false));
    },
    getItemBySlug(cb) {
      this.loading = true;
      api
        .get(this.url, {
          params: {
            slug: this.item.slug,
          },
        })
        .then((res) => {
          this.item = res.data;
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => (this.loading = false));
    },
    getItems(cb, params) {
      this.loading = true;
      api
        .get(this.url, { params })
        .then((res) => {
          this.items = res.data;
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => (this.loading = false));
    },
    saveItem(cb) {
      this.loading = true;
      api
        .post(this.url, this.item)
        .then((res) => {
          this.item = res.data;
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => (this.loading = false));
    },
    deleteItem(cb) {
      this.loading = true;
      api
        .delete(this.url, {
          params: {
            id: this.item.id,
          },
        })
        .then((res) => {
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => (this.loading = false));
    },
  },
});

export const PlayTestStore = defineStore("playTest", {
  state: () => ({
    beginTest: false,
    testResults: false,
    currentQuestion: 1,
    numberOfQuestions: null,
    selectedIndexes: [],
    answeredQuestions: [],
    completedTest: false,
    results: {
      numberOfPassedQuestions: 0,
      numberOfFaliedQuestions: 0
    },
    items: []
  }),
  getters: {
    getNumberOfRemainingQuestions: (state) => state.items.length - state.currentQuestion,
    getPercentageOfCompletion: (state) => Math.round(state.results.numberOfPassedQuestions / state.items.length * 100),
    isPassed: (state) => Math.round(state.results.numberOfPassedQuestions / state.items.length * 100) > 80,
  },
  actions: {
    nextQuestion() {
      if (this.currentQuestion < this.items.length) {
        this.currentQuestion++;
      } else {
        this.checkQuestion();
        this.testResults = true;
      }
    },
    prevQuestion() {
      if (this.currentQuestion > 1) this.currentQuestion--;
    },
    checkQuestion() {
      this.results.numberOfPassedQuestions = 0;
      this.results.numberOfFaliedQuestions = 0;

      let isValid = true;

      this.items.forEach((item, questionIndex) => {
        if (item.selectedQuestions.length == 0) {
          isValid = false;
        }

        const question = QuestionStore();

        item.selectedQuestions.forEach(index => {
          if (!question.items[questionIndex].answers[index].is_correct) {
            isValid = false;
          }
        });

        if (isValid) this.results.numberOfPassedQuestions++;
        else this.results.numberOfFaliedQuestions++;
      });
    },
    onClose() {
      this.$reset();
    }
  },
});
