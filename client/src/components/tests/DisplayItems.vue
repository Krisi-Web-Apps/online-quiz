<template>
  <custom-table
    :rows="test.items"
    :columns="columns"
    :loading="test.loading"
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
import { useRoute } from "vue-router";

import { i18n } from "src/boot/i18n";

import { EnvStore } from "src/stores/env";
import { TestStore } from "src/stores/test";
import { UserStore } from "src/stores/user";

import CustomTable from "src/components/common/CustomTable.vue";
import { useQuasar } from "quasar";

export default {
  components: {
    CustomTable,
  },
  setup() {
    const route = useRoute();
    const $t = i18n.global.t;
    const $q = useQuasar();

    const env = EnvStore();
    const user = UserStore();
    const test = TestStore();

    if (route.meta.previousRoute.name) {
      test.item.lang = user.me.lang;
      test.getItems();
    }

    const functions = {
      callback(status, message) {
        if (status == 200) {
          env.dialogs.tests.saving = true;
          test.getItems();
        } else {
          env.te(message);
        }
      },
      deletedCallback(status, message) {
        if (status == 200) {
          env.ts($t("successful_deleted"));
          test.getItems();
        } else {
          env.te(message);
        }
      },
      openDialog(id) {
        test.item.id = id;
        test.getItem(functions.callback);
      },
      confirmDeleteItem(id) {
        $q.dialog({
          title: $t("confirm"),
          message: $t("delete_confimation"),
          color: "negative",
          cancel: true,
        }).onOk(() => {
          test.item.id = id;
          test.deleteItem(functions.deletedCallback);
        });
      },
    };

    return { env, test, ...functions };
  },
  data() {
    return {
      columns: [
        {
          name: "name",
          required: true,
          label: this.$t("name"),
          align: "left",
          field: (row) => row.name,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "question_count",
          required: true,
          label: this.$t("question_count"),
          align: "left",
          field: (row) => row.question_count,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "lang",
          required: true,
          label: this.$t("language"),
          align: "left",
          field: (row) => row.lang,
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
