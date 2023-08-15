<template>
  <q-page padding>
    <h1 class="text-h4 text-center">{{ $t("online_quiz") }}</h1>
    <display-items />
  </q-page>
</template>

<script>
import DisplayItems from 'src/components/front/categories/DisplayItems.vue';

export default {
  components: {
    DisplayItems,
  },
  setup() {

  }
};
</script>
