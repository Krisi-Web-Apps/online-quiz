import { route } from "quasar/wrappers";
import {
  createRouter,
  createMemoryHistory,
  createWebHistory,
  createWebHashHistory,
} from "vue-router";
import routes from "./routes";

export default route(function (/* { store, ssrContext } */) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : process.env.VUE_ROUTER_MODE === "history"
    ? createWebHistory
    : createWebHashHistory;

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,

    history: createHistory(process.env.VUE_ROUTER_BASE),
  });

  Router.beforeEach((to, from, next) => {
    if (from && from.meta) {
      to.meta.previousRoute = from;
    }
    next();
  });

  Router.beforeEach((to, from, next) => {
    if (to.meta.isAuth) {
      const token = JSON.parse(localStorage.getItem("token"));

      if (!token) {
        next({ name: "home" });
        return;
      }
    }
    next();
  });

  return Router;
});
