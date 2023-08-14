const routes = [
  {
    path: "/admin",
    component: () => import("layouts/AdminLayout.vue"),
    children: [
      {
        path: "",
        name: "home",
        component: () => import("pages/admin/IndexPage.vue"),
      },
      {
        path: "translations",
        meta: { isAuth: true },
        name: "translations",
        component: () => import("pages/admin/TranslationsPage.vue"),
      },
      {
        path: "profile",
        meta: { isAuth: true },
        name: "profile",
        component: () => import("pages/admin/ProfilePage.vue"),
      },
      {
        path: "categories",
        meta: { isAuth: true, previousRoute: null },
        name: "categories",
        component: () => import("pages/admin/CategoriesPage.vue"),
      },
      {
        path: "tests",
        meta: { isAuth: true, previousRoute: null },
        name: "tests",
        component: () => import("pages/admin/TestsPage.vue"),
      },
      {
        path: "questions",
        meta: { isAuth: true, previousRoute: null },
        name: "questions",
        component: () => import("pages/admin/QuestionsPage.vue"),
      },
    ],
  },
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        meta: { isAuth: false, previousRoute: null },
        name: "home",
        component: () => import("pages/front/HomePage.vue"),
      },
    ],
  },
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
