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
    >
    <template v-slot:body-cell-lang="props">
      <q-td :props="props">
        {{ env.transformArrayToObject(env.languages)[props.row.lang] }}
      </q-td>
    </template>
  </q-table>
  </div>
</template>

<script>
import { useRoute } from "vue-router";

import { EnvStore } from "src/stores/env";
import { CategoryStore } from "src/stores/category";
import { UserStore } from "src/stores/user";

export default {
  setup() {
    const route = useRoute();

    const env = EnvStore();
    const user = UserStore();
    const category = CategoryStore();

    if (route.meta.previousRoute.name) {
      category.item.lang = user.me.lang;
      category.getItems();
    }

    return { env, category };
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
