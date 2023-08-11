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
  <div
    v-if="translation.tab != 'bg' && translation.displayWithoutAnyLangItems.length > 0"
    class="q-mt-md"
  >
    <div class="text-white bg-secondary text-subtitle1 q-pa-md rounded-borders">
      {{ $t("translations_to_add_for_this_lang") }}
    </div>
  </div>
  <q-tab-panels v-model="translation.tab" animated>
    <q-tab-panel
      class="q-pa-none q-mt-md"
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
