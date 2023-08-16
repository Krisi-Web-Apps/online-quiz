<template>
  <q-card class="medium-dialog">
    <q-scroll-area class="full-height">
      <div>
        <q-card-section class="bg-grey-2">
          <div class="text-h6 text-center">{{ $t("test_results") }}</div>
        </q-card-section>
        <q-separator class="q-my-md" />
        <q-card-section class="bg-grey-2 custom-row grid-columns-3">
          <q-card class="column text-subtitle1">
            <q-card-section class="text-center">
              <q-icon name="check" size="40px" color="positive" />
              <div>{{ $t("correct_answers") }}</div>
              <div class="text-h6">
                {{ playTest.results.numberOfPassedQuestions }}
              </div>
            </q-card-section>
          </q-card>
          <q-card class="column text-subtitle1">
            <q-card-section class="text-center">
              <q-icon
                name="percent"
                size="40px"
                :color="playTest.isPassed ? 'positive' : 'negative'"
              />
              <div>{{ $t("percentage_of_completion") }}</div>
              <div class="text-h6">
                {{ playTest.getPercentageOfCompletion }}
                <span>%</span>
              </div>
            </q-card-section>
          </q-card>
          <q-card class="column text-subtitle1">
            <q-card-section class="text-center">
              <q-icon name="close" size="40px" color="negative" />
              <div>{{ $t("wrong_answers") }}</div>
              <div class="text-h6">
                {{ playTest.results.numberOfFaliedQuestions }}
              </div>
            </q-card-section>
          </q-card>
        </q-card-section>
      </div>
      <div class="text-center">
        <q-btn
          icon="check"
          size="140px"
          color="positive"
          flat
          round
          v-if="playTest.isPassed"
        />
        <q-btn icon="close" size="140px" color="negative" flat round v-else />
      </div>
      <q-card-actions class="bg-grey-2">
        <q-btn
          icon="stop"
          :label="$t('close')"
          color="negative"
          flat
          no-caps
          @click="playTest.onClose"
        />
      </q-card-actions>
    </q-scroll-area>
  </q-card>
</template>

<script>
import { PlayTestStore } from "src/stores/test";

export default {
  setup() {
    const playTest = PlayTestStore();
    return { playTest };
  },
};
</script>
