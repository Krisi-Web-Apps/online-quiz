<template>
  <q-tabs
    v-model="translation.tab"
    no-caps
    inline-label
    class="bg-grey-2"
    active-class="text-primary"
  >
    <q-tab
      v-for="(item, index) in env.languages"
      :key="index"
      :name="item.value"
      icon="language"
      :label="$t(`${item.key}`)"
      @click="router.push({ query: { lang: item.value } })"
    />
  </q-tabs>
  <q-tab-panels v-model="translation.tab" animated>
    <q-tab-panel
      v-for="(item, index) in env.languages"
      :key="index"
      :name="item.value"
    >
      <display-all />
    </q-tab-panel>
  </q-tab-panels>
</template>

<script>
import { useRoute, useRouter } from "vue-router";

import { EnvStore } from "src/stores/env";
import { TranslationStore } from "src/stores/translation";

import DisplayAll from "src/components/translations/DisplayAll.vue";

export default {
  components: {
    DisplayAll,
  },
  setup() {
    const translation = TranslationStore();
    const router = useRouter();
    const route = useRoute();
    const env = EnvStore();

    if (route.query.lang) {
      translation.tab = route.query.lang;
    }

    return { env, translation, router };
  },
};
</script>
