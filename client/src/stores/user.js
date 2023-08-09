import { defineStore } from "pinia";
import { api } from "src/boot/axios";

export const UserStore = defineStore("user", {
  state: () => ({
    loading: false,
    isLoggedIn: false,
    url: "/users",
    credentials: {},
    me: {},
    lang: "bg"
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
          console.log(res.data);
          this.afterLogin(res.data.token);
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
          else console.log(err);
        })
        .finally(() => (this.loading = false));
    },
    afterLogin(token) {
      api.defaults.headers.authorization = `Bearer ${token}`;
      localStorage.setItem("token", JSON.stringify(token));
      this.isLoggedIn = true;
    },
    logout() {
      api.defaults.headers.authorization = null;
      localStorage.removeItem("token");
      this.isLoggedIn = false;
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
