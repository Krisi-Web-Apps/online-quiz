<template>
  <q-page padding>
    <h1 class="text-h4 q-mt-none">{{ $t("select_test") }}</h1>
    <display-items />
  </q-page>
</template>

<script>
import DisplayItems from "src/components/front/tests/DisplayItems.vue";

export default {
  components: {
    DisplayItems,
  },
  setup() {},
};
</script>
