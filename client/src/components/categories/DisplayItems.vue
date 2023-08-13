<template>
  <custom-table
    :rows="category.items"
    :columns="columns"
    :loading="category.loading"
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
import { useQuasar } from "quasar";

import { i18n } from "src/boot/i18n";

import { EnvStore } from "src/stores/env";
import { CategoryStore } from "src/stores/category";
import { UserStore } from "src/stores/user";

import CustomTable from "src/components/common/CustomTable.vue";

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
    const category = CategoryStore();

    if (route.meta.previousRoute.name) {
      category.item.lang = user.me.lang;
      if (category.items.length == 0) category.getItems();
    }

    const functions = {
      callback(status, message) {
        if (status == 200) {
          env.dialogs.categories.saving = true;
          category.getItems();
        } else {
          env.te(message);
        }
      },
      deletedCallback(status, message) {
        if (status == 200) {
          env.ts($t("successful_deleted"));
          category.getItems();
        } else {
          env.te(message);
        }
      },
      openDialog(id) {
        category.item.id = id;
        category.getItem(functions.callback);
      },
      confirmDeleteItem(id) {
        $q.dialog({
          title: $t("confirm"),
          message: $t("delete_confimation"),
          color: "negative",
          cancel: true,
        }).onOk(() => {
          category.item.id = id;
          category.deleteItem(functions.deletedCallback);
        });
      },
    };

    return { env, category, ...functions };
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
          name: "slug",
          required: true,
          label: this.$t("slug"),
          align: "left",
          field: (row) => row.slug,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "description",
          required: true,
          label: this.$t("description"),
          align: "left",
          field: (row) => row.description,
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
