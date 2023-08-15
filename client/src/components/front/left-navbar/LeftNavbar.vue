<template>
  <div class="q-py-md q-pl-md text-h6">{{ $t("categories") }}</div>
  <display-items />
</template>

<script>
import DisplayItems from "src/components/front/categories/DisplayItems.vue";

export default {
  components: {
    DisplayItems,
  }
};
</script>
