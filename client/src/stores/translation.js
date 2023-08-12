import { defineStore } from "pinia";
import { api } from "src/boot/axios";

export const TranslationStore = defineStore("translation", {
  state: () => ({
    loading: false,
    url: "/translations",
    item: {},
    items: [],
    displingItems: [],
    displayWithoutAnyLangItems: [],
    tab: "bg"
  }),
  actions: {
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
        .finally(() => this.loading = false);
    },
    getItemsByUserLang(lang, cb) {
      this.loading = true;
      api.get(`${this.url}/all`, {
        params: {
          lang: lang,
        }
      })
      .then((res) => {
        this.items = res.data;
        if (cb) cb(res.status);
      })
      .catch((err) => {
        if (cb) cb(err.response.status, err.response.data.error);
      })
      .finally(() => this.loading = false);
    },
    getItems(cb) {
      this.loading = true;
      api
        .get(`${this.url}`, {
          params: {
            lang: this.tab
          }
        })
        .then((res) => {
          this.displingItems = res.data;
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => this.loading = false);
    },
    getItemsWithout(withoutLang, cb) {
      this.loading = true;
      api
        .get(`${this.url}`, {
          params: {
            without_lang: withoutLang,
          }
        })
        .then((res) => {
          this.displayWithoutAnyLangItems = res.data;
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
        })
        .finally(() => this.loading = false);
    },
    deleteItem(cb) {
      this.loading = true;
      api
        .delete(`${this.url}`, {
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
  },
});
