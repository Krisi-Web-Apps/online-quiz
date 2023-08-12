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
        name: "translations",
        component: () => import("pages/TranslationsPage.vue"),
      },
      {
        path: "profile",
        name: "profile",
        component: () => import("pages/ProfilePage.vue"),
      },
      {
        path: "categories",
        meta: { previousRoute: null },
        name: "categories",
        component: () => import("pages/CategoriesPage.vue"),
      },
      {
        path: "tests",
        meta: { previousRoute: null },
        name: "tests",
        component: () => import("pages/TestsPage.vue"),
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
