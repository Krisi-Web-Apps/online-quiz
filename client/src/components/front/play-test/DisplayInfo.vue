<template>
  <q-card-section class="custom-row grid-columns-2">
    <q-card class="column text-subtitle1">
      <q-card-section class="text-center flex flex-center column full-height">
        <div>{{ $t("corrent_question") }}</div>
        <div class="text-h6">
          {{ playTest.currentQuestion }}
        </div>
      </q-card-section>
    </q-card>
    <q-card class="column text-subtitle1">
      <q-card-section class="text-center flex flex-center column full-height">
        <div>{{ $t("remaining_questions") }}</div>
        <div class="text-h6">
          {{ playTest.getNumberOfRemainingQuestions }}
        </div>
      </q-card-section>
    </q-card>
  </q-card-section>
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
