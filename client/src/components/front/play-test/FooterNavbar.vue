<template>
  <q-card-actions class="bg-grey-2">
    <q-btn
      icon="stop"
      :label="$t('stop_test')"
      color="negative"
      flat
      no-caps
      v-close-popup
      @click="playTest.onClose"
    />
  </q-card-actions>
</template>

<script>
import { PlayTestStore } from 'src/stores/test';

export default {
  setup() {
    const playTest = PlayTestStore();
    return { playTest }
  }
};
</script>
