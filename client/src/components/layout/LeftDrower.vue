<template>
  <q-drawer
    side="left"
    bordered
    v-model="isDrowerOpen"
    class="text-black bg-grey-2"
  >
    <h2 class="text-h6 q-ml-lg">{{ $t("website_title") }}</h2>
    <q-list>
      <q-item clickable v-ripple @click="router.push({ name: 'home' })">
        <q-item-section avatar>
          <q-icon :color="isActive('home') ? 'primary' : null" name="home" />
        </q-item-section>
        <q-item-section :class="getClasses('home')"> home </q-item-section>
      </q-item>
      <q-item clickable v-ripple @click="router.push({ name: 'translations' })">
        <q-item-section avatar>
          <q-icon
            :color="isActive('translations') ? 'primary' : null"
            name="language"
          />
        </q-item-section>
        <q-item-section :class="getClasses('translations')">
          translations
        </q-item-section>
      </q-item>
    </q-list>
  </q-drawer>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";
import { useRoute, useRouter } from "vue-router";

export default {
  computed: {
    isDrowerOpen() {
      return this.env.layout.leftDrower && this.user.isLoggedIn;
    },
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const env = EnvStore();
    const user = UserStore();

    const functions = {
      isActive(name) {
        return this.route.name == name;
      },
      getClasses(name) {
        return `${this.isActive(name) ? "text-primary" : null} text-subtitle1`;
      },
    };

    return { route, router, env, user, ...functions };
  },
};
</script>
