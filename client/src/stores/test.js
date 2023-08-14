import { defineStore } from "pinia";
import { api } from "src/boot/axios";
import { i18n } from "src/boot/i18n";

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
    getItems(cb) {
      this.loading = true;
      api
        .get(this.url)
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
    }
  },
});
