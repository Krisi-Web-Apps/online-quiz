<template>
  <q-tabs
    v-model="translation.tab"
    no-caps
    inline-label
    class="bg-grey-2 text-primary"
  >
    <q-tab
      name="bg"
      icon="language"
      :label="$t('bulgarian')"
      @click="router.push({ query: { lang: 'bg' } })"
    />
    <q-tab
      name="en-US"
      icon="language"
      :label="$t('english_us')"
      @click="router.push({ query: { lang: 'en-US' } })"
    />
  </q-tabs>
  <q-tab-panels v-model="translation.tab" animated>
    <q-tab-panel name="bg">
      <display-all />
    </q-tab-panel>
    <q-tab-panel name="en-US">
      <display-all />
    </q-tab-panel>
  </q-tab-panels>
</template>

<script>
import DisplayAll from "src/components/translations/DisplayAll.vue";
import { TranslationStore } from "src/stores/translation";
import { useRoute, useRouter } from "vue-router";

export default {
  components: {
    DisplayAll,
  },
  setup() {
    const translation = TranslationStore();
    const router = useRouter();
    const route = useRoute();

    if (route.query.lang) {
      translation.tab = route.query.lang;
    }

    return { translation, router };
  },
};
</script>
