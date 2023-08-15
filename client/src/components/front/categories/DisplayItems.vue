<template>
  <q-list>
    <div v-for="(item, index) in category.items" :key="index">
      <q-item clickable v-ripple @click="getQuestionsByCategory(item.id, index)">
        <q-item-section side>
          <q-icon name="arrow_forward_ios" />
        </q-item-section>
        <q-item-section class="text-subtitle1">
          {{ item.name }}
        </q-item-section>
      </q-item>
      <div
        v-if="index == env.layout.front.leftDrower.selectedCategory"
        v-for="(item, index) in test.items"
        :key="index"
        class="q-ml-md"
      >
        <q-item clickable v-ripple>
          <q-item-section side>
            <q-icon name="arrow_forward_ios" />
          </q-item-section>
          <q-item-section class="text-subtitle1">
            {{ item.name }}
          </q-item-section>
        </q-item>
      </div>
    </div>
  </q-list>
</template>

<script>
import { CategoryStore } from "src/stores/category";
import { EnvStore } from "src/stores/env";
import { TestStore } from "src/stores/test";

export default {
  setup() {
    const env = EnvStore();
    const category = CategoryStore();
    const test = TestStore();

    category.getItems();

    const functions = {
      getQuestionsByCategory(category_id, index) {
        env.layout.front.leftDrower.selectedCategory = index;
        test.getItems(null, { category_id });
      },
    };

    return { env, category, test, ...functions };
  },
};
</script>
