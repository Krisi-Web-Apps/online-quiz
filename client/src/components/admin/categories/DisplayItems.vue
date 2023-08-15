<template>
  <q-input
    v-model="category.searchTerm"
    :label="`${$t('search')}...`"
    :hint="$t('search_name')"
    icon="search"
    filled
    clearable
    class="q-mb-sm"
  />
  <custom-table
    :rows="category.items"
    :columns="category.columns"
    :loading="category.loading"
    :filterFn="filter"
    :searchTerm="category.searchTerm"
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

import CustomTable from "src/components/admin/common/CustomTable.vue";

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

    return { env, category };
  },
  methods: {
    callback() {
      this.env.dialogs.categories.saving = true;
    },
    deletedCallback(status, message) {
      if (status == 200) {
        this.env.ts($t("successful_deleted"));
        this.category.getItems();
      } else {
        this.env.te(message);
      }
    },
    openDialog(id) {
      this.category.item.id = id;
      this.category.getItem(this.callback);
    },
    confirmDeleteItem(id) {
      this.$q.dialog({
        title: $t("confirm"),
        message: $t("delete_confimation"),
        color: "negative",
        cancel: true,
      }).onOk(() => {
        this.category.item.id = id;
        this.category.deleteItem(this.deletedCallback);
      });
    },
    filter(row, searchTerm) {
      const searchLowerCase = searchTerm.toLowerCase();
      return row.name.toLowerCase().includes(searchLowerCase);
    },
  },
};
</script>
