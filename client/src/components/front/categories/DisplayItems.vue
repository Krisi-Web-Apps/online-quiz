<template>
  <q-list v-if="!category.loading">
    <div v-for="(item, index) in category.items" :key="index">
      <q-item clickable v-ripple @click="getTestsByCategory(item.id)">
        <q-item-section side>
          <q-icon
            name="arrow_forward_ios"
            :class="$route.query.id == item.id ? 'text-primary' : ''"
          />
        </q-item-section>
        <q-item-section
          class="text-subtitle1"
          :class="$route.query.id == item.id ? 'text-primary' : ''"
        >
          {{ item.name }}
        </q-item-section>
      </q-item>
    </div>
  </q-list>
  <loading-bar v-else />
</template>

<script>
import { EnvStore } from "src/stores/env";
import { TestStore } from "src/stores/test";
import { useRouter } from "vue-router";

import LoadingBar from "src/components/front/common/LoadingBar.vue";
import { CategoryStore } from "src/stores/category";

export default {
  components: {
    LoadingBar,
  },
  setup() {
    const router = useRouter();
    const env = EnvStore();
    const category = CategoryStore();
    const test = TestStore();

    category.getItems();

    return { router, env, category, test };
  },
  methods: {
    getTestsByCategory(category_id) {
      this.router
        .push({ name: "tests", query: { id: category_id } })
        .then(() => {
          this.test.getItems(null, { category_id });
        });
    },
  },
};
</script>
