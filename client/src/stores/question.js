import { defineStore } from "pinia";
import { api } from "src/boot/axios";

export const QuestionStore = defineStore("question", {
  state: () => ({
    loading: false,
    url: "/questions",
    item: {},
    items: [],
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
    getItems(cb) {
      this.loading = true;
      api
        .get(this.url, {
          params: {
            all: true,
          }
        })
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
          }
        })
        .then((res) => {
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => (this.loading = false));
    },
    setEmptyAnswers(answerCount) {
      this.item.answers = [];
      for (let i = 0; i < answerCount; i++) {
        this.item.answers.push({
          text: "",
          is_correct: false,
        });
      }
    }
  },
});
