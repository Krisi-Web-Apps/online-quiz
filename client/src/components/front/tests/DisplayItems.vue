<template>
  <q-list v-if="test.items.length > 0">
    <div v-for="(item, index) in test.items" :key="index">
      <q-item clickable v-ripple>
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
</template>

<script>
import { TestStore } from "src/stores/test";

export default {
  setup() {
    const test = TestStore();
    return { test };
  },
};
</script>
