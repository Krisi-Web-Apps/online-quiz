<template>
  <q-page padding class="q-pt-none">
    <div class="container">
      <div class="flex justify-between items-center">
        <h1 class="text-h4 text-center">{{ $t("questions") }}</h1>
        <q-btn
          :label="$t('add_question')"
          icon="add"
          color="primary"
          @click="createOpen"
        />
      </div>
    </div>
    <q-dialog
      v-model="env.dialogs.questions.saving"
      :maximized="$q.screen.width <= 600"
    >
      <save-dialog />
    </q-dialog>
    <q-dialog
      v-model="env.dialogs.questions.selectTest"
      :maximized="$q.screen.width <= 600"
    >
      <select-test />
    </q-dialog>
    <display-items />
  </q-page>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";
import { QuestionStore } from "src/stores/question";

import SaveDialog from "src/components/questions/SaveDialog.vue";
import DisplayItems from "src/components/questions/DisplayItems.vue";
import SelectTest from "src/components/questions/SelectTest.vue";

export default {
  components: {
    SaveDialog,
    DisplayItems,
    SelectTest,
  },
  setup() {
    const env = EnvStore();
    const question = QuestionStore();
    const user = UserStore();

    const functions = {
      createOpen() {
        question.item = { lang: user.me.lang };
        env.dialogs.questions.selectTest = true;
      },
    };

    return { env, ...functions };
  },
};
</script>
