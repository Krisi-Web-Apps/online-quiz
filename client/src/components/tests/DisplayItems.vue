<template>
  <q-input
    v-model="test.searchTerm"
    :label="`${$t('search')}...`"
    :hint="$t('search_name_and_category_name')"
    icon="search"
    filled
    clearable
    class="q-mb-sm"
  />
  <custom-table
    :rows="test.items"
    :columns="test.columns"
    :loading="test.loading"
    :filterFn="filter"
    :searchTerm="test.searchTerm"
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

    return { env, test };
  },
  methods: {
    callback(status, message) {
      if (status == 200) {
        this.env.dialogs.tests.saving = true;
      } else {
        this.env.te(message);
      }
    },
    deletedCallback(status, message) {
      if (status == 200) {
        this.env.ts(this.$t("successful_deleted"));
        this.test.getItems();
      } else {
        this.env.te(message);
      }
    },
    openDialog(id) {
      this.test.item.id = id;
      this.test.getItem(this.callback);
    },
    confirmDeleteItem(id) {
      this.$q.dialog({
        title: this.$t("confirm"),
        message: this.$t("delete_confimation"),
        color: "negative",
        cancel: true,
      }).onOk(() => {
        this.test.item.id = id;
        this.test.deleteItem(this.deletedCallback);
      });
    },
    filter(row, searchTerm) {
      const searchLowerCase = searchTerm.toLowerCase();
      return (
        row.name.toLowerCase().includes(searchLowerCase) ||
        row.category_name.toLowerCase().includes(searchLowerCase)
      );
    },
  },
};
</script>
