<template>
  <div class="container">
    <h1 class="text-h4 text-center">{{ $t("my_profile") }}</h1>
  </div>
  <tab-panels />
</template>

<script>
import TabPanels from "src/components/profile/TabPanels.vue";

export default {
  components: {
    TabPanels,
  },
  setup() {

  }
};
</script>
