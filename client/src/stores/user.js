import { defineStore } from 'pinia';
import { api } from 'src/boot/axios';

export const UserStore = defineStore('user', {
  state: () => ({
    loading: false,
    url: "/users",
    credentials: {}
  }),
  actions: {
    register(cb) {
      this.loading = true;
      api.post(`${this.url}/register`, this.credentials)
        .then((res) => {
          if (cb) cb(res.status);
        })
        .catch((err) => {
          if (cb) cb(err.response.status, err.response.data.error);
          else console.log(err);
        }).
        finally(() => this.loading = false);
    }
  },
});
