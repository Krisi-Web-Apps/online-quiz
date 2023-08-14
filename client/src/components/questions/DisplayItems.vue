<template>
  <custom-table
    :rows="question.items"
    :columns="question.columns"
    :loading="question.loading"
    :slots="[
      { name: 'body-cell-test_title', scope: 'props' },
      { name: 'body-cell-lang', scope: 'props' },
      { name: 'body-cell-options', scope: 'props' },
    ]"
  >
    <template v-slot:body-cell-test_title="props">
      <q-td>
        <router-link
          :to="`?test=${props.scope.row.test_id}`"
          @click="selectTest(props.scope.row.test_id)"
          class="text-decoration-none"
          v-if="!question.loading"
        >
          {{ props.scope.row.test_title }}
        </router-link>
        <div v-else class="text-grey-6">{{ props.scope.row.test_title }}</div>
      </q-td>
    </template>
    <template v-slot:body-cell-lang="props">
      <q-td>
        {{ env.transformArrayToObject(env.languages)[props.scope.row.lang] }}
      </q-td>
    </template>
    <template v-slot:body-cell-options="props">
      <q-td class="text-right">
        <q-btn
          fab-mini
          flat
          icon="edit"
          color="primary"
          @click="openDialog(props.scope.row.id)"
        />
        <q-btn
          fab-mini
          flat
          icon="delete"
          color="negative"
          @click="confirmDeleteItem(props.scope.row.id)"
        />
      </q-td>
    </template>
  </custom-table>
</template>

<script>
import { useQuasar } from "quasar";

import { EnvStore } from "src/stores/env";
import { QuestionStore } from "src/stores/question";

import { i18n } from "src/boot/i18n";

import CustomTable from "src/components/common/CustomTable.vue";
import { useRoute } from "vue-router";

export default {
  components: {
    CustomTable,
  },
  setup() {
    const $t = i18n.global.t;
    const $q = useQuasar();
    const route = useRoute();

    const env = EnvStore();
    const question = QuestionStore();

    if (route.query.test) {
      question.getItems(null, {
        test_id: route.query.test
      });
    } else {
      question.getItems(null, { all: true });
    }

    return { env, question };
  },
  methods: {
    callback(status, message) {
      if (status == 200) {
        this.env.dialogs.questions.saving = true;
      } else {
        this.env.te(message);
      }
    },
    deletedCallback(status, message) {
      if (status == 200) {
        this.env.ts($t("successful_deleted"));
        this.question.getItems();
      } else {
        this.env.te(message);
      }
    },
    openDialog(id) {
      this.question.item.id = id;
      this.question.getItem(this.callback);
    },
    confirmDeleteItem(id) {
      this.$q.dialog({
        title: $t("confirm"),
        message: $t("delete_confimation"),
        color: "negative",
        cancel: true,
      }).onOk(() => {
        this.question.item.id = id;
        this.question.deleteItem(this.deletedCallback);
      });
    },
    selectTest(testId) {
      this.question.getItems(null, { test_id: testId });
    },
  },
};
</script>
