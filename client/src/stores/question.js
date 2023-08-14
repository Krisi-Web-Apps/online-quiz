import { defineStore } from "pinia";
import { api } from "src/boot/axios";
import { i18n } from "src/boot/i18n";

const $t = i18n.global.t;

export const QuestionStore = defineStore("question", {
  state: () => ({
    loading: false,
    url: "/questions",
    searchTerm: "",
    item: {},
    items: [],
    columns: [
      {
        name: "title",
        required: true,
        label: $t("title"),
        align: "left",
        field: (row) => row.title,
        format: (val) => `${val}`,
        sortable: true,
      },
      {
        name: "test_title",
        required: true,
        label: $t("test_title"),
        align: "left",
        field: (row) => row.test_title,
        format: (val) => `${val}`,
        sortable: true,
      },
      {
        name: "lang",
        required: true,
        label: $t("lang"),
        align: "left",
        field: (row) => row.lang,
        format: (val) => `${val}`,
        sortable: true,
      },
      {
        name: "answerCount",
        required: true,
        label: $t("answer_count"),
        align: "left",
        field: (row) => row.answers.length,
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
    setEmptyAnswers(answerCount) {
      this.item.answers = [];
      for (let i = 0; i < answerCount; i++) {
        this.item.answers.push({
          text: "",
          is_correct: false,
        });
      }
    },
  },
});
