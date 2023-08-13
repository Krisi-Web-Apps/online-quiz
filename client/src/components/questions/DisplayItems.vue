<template>
  <custom-table
    :rows="question.items"
    :columns="columns"
    :loading="question.loading"
    :slots="[
      { name: 'body-cell-lang', scope: 'props' },
      { name: 'body-cell-options', scope: 'props' },
    ]"
  >
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

export default {
  components: {
    CustomTable,
  },
  setup() {
    const $t = i18n.global.t;
    const $q = useQuasar();

    const env = EnvStore();
    const question = QuestionStore();

    if (question.items.length == 0) question.getItems();

    const functions = {
      callback(status, message) {
        if (status == 200) {
          env.dialogs.questions.saving = true;
        } else {
          env.te(message);
        }
      },
      deletedCallback(status, message) {
        if (status == 200) {
          env.ts($t("successful_deleted"));
          question.getItems();
        } else {
          env.te(message);
        }
      },
      openDialog(id) {
        question.item.id = id;
        question.getItem(functions.callback);
      },
      confirmDeleteItem(id) {
        $q.dialog({
          title: $t("confirm"),
          message: $t("delete_confimation"),
          color: "negative",
          cancel: true,
        }).onOk(() => {
          question.item.id = id;
          question.deleteItem(functions.deletedCallback);
        });
      },
    };

    return { env, question, ...functions };
  },
  data() {
    return {
      columns: [
        {
          name: "title",
          required: true,
          label: this.$t("title"),
          align: "left",
          field: (row) => row.title,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "lang",
          required: true,
          label: this.$t("lang"),
          align: "left",
          field: (row) => row.lang,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "answerCount",
          required: true,
          label: this.$t("answer_count"),
          align: "left",
          field: (row) => row.answers.length,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "options",
          required: true,
          label: this.$t("options"),
          align: "right",
        },
      ],
    };
  },
};
</script>
