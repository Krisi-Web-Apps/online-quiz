<template>
  <q-page class="flex flex-center column">
    <q-img
      :alt="$t('online_quiz')"
      src="~assets/logo.jpeg"
      style="width: 200px; height: 200px"
    />
    <div class="q-mt-md">
      <q-btn
        :label="$t('select_quiz')"
        icon="quiz"
        size="40px"
        color="primary"
        flat
      />
    </div>
  </q-page>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "IndexPage",
});
</script>
