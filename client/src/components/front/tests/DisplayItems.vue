<template>
  <div v-if="!test.loading">
    <q-list v-if="test.items.length > 0">
      <div v-for="(item, index) in test.items" :key="index">
        <q-item clickable v-ripple @click="selectTest(item.slug)">
          <q-item-section side>
            <q-icon name="arrow_forward_ios" />
          </q-item-section>
          <q-item-section class="text-subtitle1">
            {{ item.name }}
          </q-item-section>
        </q-item>
      </div>
    </q-list>
    <div v-else>
      <div class="bg-grey-2 q-px-md q-py-md text-subtitle1">
        <div class="flex items-center">
          <q-icon name="info" size="30px" class="q-mr-sm text-grey-6" />
          {{ $t("no_tests_were_found") }}
        </div>
      </div>
    </div>
  </div>
  <loading-bar v-else />
</template>

<script>
import { useRoute, useRouter } from "vue-router";

import { EnvStore } from "src/stores/env";
import { TestStore } from "src/stores/test";

import LoadingBar from "src/components/front/common/LoadingBar.vue";

export default {
  components: {
    LoadingBar,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const env = EnvStore();
    const test = TestStore();

    if (test.items.length == 0)
      if (route.query.id) test.getItems(null, { category_id: route.query.id });
      else test.getItems();

    return { router, env, test };
  },
  methods: {
    selectTest(slug) {
      this.router.push({ query: { test_slug: slug } });
    },
  },
};
</script>
