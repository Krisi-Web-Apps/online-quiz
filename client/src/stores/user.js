import { defineStore } from "pinia";
import { api } from "src/boot/axios";

export const UserStore = defineStore("user", {
  state: () => ({
    loading: false,
    url: "/users",
    credentials: {},
    me: {}
  }),
  actions: {
    register(cb) {
      this.loading = true;
      api
        .post(`${this.url}/register`, this.credentials)
        .then((res) => {
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
          else console.log(err);
        })
        .finally(() => (this.loading = false));
    },
    login(cb) {
      this.loading = false;
      api
        .post(`${this.url}/login`, this.credentials)
        .then((res) => {
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
          else console.log(err);
        })
        .finally(() => (this.loading = false));
    },
    afterLogin(token) {
      api.defaults.headers.authorization = token;
      localStorage.setItem("token", JSON.parse(token));
    },
    logout() {
      api.defaults.headers.authorization = null;
      localStorage.removeItem("token");
    },
    getUser(cb) {
      this.loading = true;
      api.get(`${this.url}`).then((res) => {
        this.me = res.data;
        if (cb) cb(res.status);
      })
      .catch((err) => {
        if (cb) cb(err.response.status, err.response.data.error)
        else console.log(err);
      })
      .finally(() => this.loading = false);
    },
  },
});
