<template>
  <div>
    <q-table
      flat
      bordered
      dense
      :rows="category.items"
      :columns="columns"
      row-key="name"
      :pagination="{ rowsPerPage: 20, descending: true }"
      :loading="category.loading"
    >
    <template v-slot:body-cell-lang="props">
      <q-td :props="props">
        {{ env.transformArrayToObject(env.languages)[props.row.lang] }}
      </q-td>
    </template>
    <template v-slot:body="props">
      <q-tr :props="props" @click="openDialog(props.row.id)">
        <q-td key="name" :props="props">
          {{ props.row.name }}
        </q-td>
        <q-td key="slug" :props="props">
          {{ props.row.slug }}
        </q-td>
        <q-td key="description" :props="props">
          {{ props.row.description }}
        </q-td>
        <q-td key="lang" :props="props">
          {{ env.transformArrayToObject(env.languages)[props.row.lang] }}
        </q-td>
      </q-tr>
    </template>
  </q-table>
  </div>
</template>

<script>
import { useRoute } from "vue-router";

import { i18n } from "src/boot/i18n";

import { EnvStore } from "src/stores/env";
import { CategoryStore } from "src/stores/category";
import { UserStore } from "src/stores/user";

export default {
  setup() {
    const route = useRoute();
    const $t = i18n.global.t;

    const env = EnvStore();
    const user = UserStore();
    const category = CategoryStore();

    if (route.meta.previousRoute.name) {
      category.item.lang = user.me.lang;
      category.getItems();
    }

    const functions = {
      callback(status, message) {
        console.log(status);
        if (status == 200) {
          env.dialogs.categories.saving = true;
        } else {
          env.te(message);
        }
      },
      openDialog(id) {
        category.item.id = id;
        category.getItem(functions.callback);
      }
    }

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
      ],
    };
  },
};
</script>
