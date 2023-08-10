import { defineStore } from "pinia";
import { api } from "src/boot/axios";

export const TranslationStore = defineStore("translation", {
  state: () => ({
    loading: false,
    url: "/translations",
    item: {},
    items: [],
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
    }
  },
});
