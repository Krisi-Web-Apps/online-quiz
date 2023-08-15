<template>
  <q-page padding>
    <div class="flex items-center q-mb-md">
      <q-btn
        icon="arrow_back_ios_new"
        flat
        fab-mini
        @click="$router.push({ name: 'tests' })"
        v-if="$route.query.test_slug"
      />
      <h1 class="text-h4 q-my-none q-ml-md">
        <span v-if="!$route.query.test_slug">{{ $t("select_test") }}</span>
        <span v-else>{{ test.item.name }}</span>
      </h1>
    </div>
    <display-items v-if="!$route.query.test_slug" />
    <dsiplay-item v-else />
    <q-dialog
      v-model="playTest.beginTest"
      full-height
      :maximized="$q.screen.width <= 600"
      persistent
    >
      <play-test-dialog />
    </q-dialog>
    <q-dialog
      v-model="playTest.testResults"
      full-height
      :maximized="$q.screen.width <= 600"
      persistent
      @hide="clear"
    >
      <test-results />
    </q-dialog>
  </q-page>
</template>

<script>
import { PlayTestStore, TestStore } from "src/stores/test";

import DisplayItems from "src/components/front/tests/DisplayItems.vue";
import DsiplayItem from "src/components/front/tests/DsiplayItem.vue";
import PlayTestDialog from "src/components/front/play-test/PlayTestDialog.vue";
import TestResults from "src/components/front/play-test/TestResults.vue";

export default {
  components: {
    DisplayItems,
    DsiplayItem,
    PlayTestDialog,
    TestResults,
  },
  setup() {
    const test = TestStore();
    const playTest = PlayTestStore();
    return { test, playTest };
  },
  methods: {
    clear() {
      this.playTest.$reset();
    }
  }
};
</script>
