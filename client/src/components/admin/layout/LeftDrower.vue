<template>
  <q-drawer
    side="left"
    bordered
    v-model="env.layout.leftDrower"
    class="text-black bg-grey-2"
  >
    <h2 class="text-h6 q-ml-lg">{{ $t("online_quiz") }}</h2>
    <q-list>
      <q-item clickable v-ripple @click="router.push({ name: 'home' })">
        <q-item-section avatar>
          <q-icon :color="isActive('home') ? 'primary' : null" name="home" />
        </q-item-section>
        <q-item-section :class="getClasses('home')">
          {{ $t("home") }}
        </q-item-section>
      </q-item>
      <q-item
        clickable
        v-ripple
        @click="router.push({ name: 'translations' })"
        v-if="user.isLoggedIn"
      >
        <q-item-section avatar>
          <q-icon
            :color="isActive('translations') ? 'primary' : null"
            name="language"
          />
        </q-item-section>
        <q-item-section :class="getClasses('translations')">
          {{ $t("translations") }}
        </q-item-section>
      </q-item>
      <q-item
        clickable
        v-ripple
        @click="router.push({ name: 'categories' })"
        v-if="user.isLoggedIn"
      >
        <q-item-section avatar>
          <q-icon
            :color="isActive('categories') ? 'primary' : null"
            name="category"
          />
        </q-item-section>
        <q-item-section :class="getClasses('categories')">
          {{ $t("categories") }}
        </q-item-section>
      </q-item>
      <q-item
        clickable
        v-ripple
        @click="router.push({ name: 'tests' })"
        v-if="user.isLoggedIn"
      >
        <q-item-section avatar>
          <q-icon :color="isActive('tests') ? 'primary' : null" name="quiz" />
        </q-item-section>
        <q-item-section :class="getClasses('tests')">
          {{ $t("tests") }}
        </q-item-section>
      </q-item>
      <q-item
        clickable
        v-ripple
        @click="router.push({ name: 'questions' })"
        v-if="user.isLoggedIn"
      >
        <q-item-section avatar>
          <q-icon
            :color="isActive('questions') ? 'primary' : null"
            name="contact_support"
          />
        </q-item-section>
        <q-item-section :class="getClasses('questions')">
          {{ $t("questions") }}
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

    return { route, router, env, user };
  },
  methods: {
    isActive(name) {
      return this.route.name == name;
    },
    getClasses(name) {
      return `${this.isActive(name) ? "text-primary" : null} text-subtitle1`;
    },
  },
};
</script>
