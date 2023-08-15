<template>
  <q-page padding class="q-pt-none">
    <div class="container">
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <q-btn
            icon="arrow_back_ios_new"
            color="primary"
            flat
            fab
            @click="back"
            v-if="(typeof $route.query.test) != 'undefined'"
          />
          <h1 class="text-h4 text-center q-mr-sm">{{ $t("questions") }}</h1>
        </div>
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
import { useRouter } from "vue-router";

import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";
import { QuestionStore } from "src/stores/question";

import SaveDialog from "src/components/admin/questions/SaveDialog.vue";
import DisplayItems from "src/components/admin/questions/DisplayItems.vue";
import SelectTest from "src/components/admin/questions/SelectTest.vue";

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
    const router = useRouter();

    const functions = {
      createOpen() {
        question.item = { lang: user.me.lang };
        env.dialogs.questions.selectTest = true;
      },
      back() {
        router.push({ name: 'questions' })
        question.getItems(null, { all: true });
      }
    };

    return { env, ...functions };
  },
};
</script>
