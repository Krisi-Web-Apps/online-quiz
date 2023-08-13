const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        name: "home",
        component: () => import("pages/IndexPage.vue"),
      },
      {
        path: "translations",
        meta: { isAuth: true },
        name: "translations",
        component: () => import("pages/TranslationsPage.vue"),
      },
      {
        path: "profile",
        meta: { isAuth: true },
        name: "profile",
        component: () => import("pages/ProfilePage.vue"),
      },
      {
        path: "categories",
        meta: { isAuth: true, previousRoute: null },
        name: "categories",
        component: () => import("pages/CategoriesPage.vue"),
      },
      {
        path: "tests",
        meta: { isAuth: true, previousRoute: null },
        name: "tests",
        component: () => import("pages/TestsPage.vue"),
      },
      {
        path: "questions",
        meta: { isAuth: true, previousRoute: null },
        name: "questions",
        component: () => import("pages/QuestionsPage.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
