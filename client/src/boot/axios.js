import { boot } from "quasar/wrappers";
import axios from "axios";
import { EnvStore } from "src/stores/env";

const env = EnvStore();

const api = axios.create({ baseURL: "http://localhost" });

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.message === "Network Error") {
      env.te("Network Error");
    }
    return Promise.reject(error);
  }
);

export default boot(({ app }) => {
  app.config.globalProperties.$axios = axios;
  app.config.globalProperties.$api = api;
});

export { api };
