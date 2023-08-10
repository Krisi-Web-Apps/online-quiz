<template>
  <div>
    <q-table
      flat
      bordered
      dense
      :rows="translation.displingItems"
      :columns="columns"
      row-key="name"
      :pagination="{ rowsPerPage: 20, descending: true }"
      v-if="translation.displingItems.length > 0"
    >
    <template v-slot:body="props">
      <q-tr :props="props" @click="openDialog(props.row.id)">
        <q-td key="name" :props="props">
          {{ props.row.name }}
        </q-td>
        <q-td key="text" :props="props">
          {{ props.row.text }}
        </q-td>
      </q-tr>
    </template>
  </q-table>
  </div>
</template>

<script>
import { i18n } from "src/boot/i18n";
import { TranslationStore } from "src/stores/translation";

export default {
  setup() {
    const translation = TranslationStore();
    const $t = i18n.global.t;

    translation.getItems();

    const functions = {
      openDialog(id) {
        console.log(id);
      }
    }

    return { translation, ...functions };
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
          name: "text",
          required: true,
          label: this.$t("text"),
          align: "left",
          field: (row) => row.text,
          format: (val) => `${val}`,
          sortable: true,
        },
      ],
    }
  }
};
</script>
