<template>
  <div>
    <q-table
      flat
      bordered
      dense
      :rows="
        translation.tab == 'bg'
          ? translation.displingItems
          : translation.displayWithoutAnyLangItems
      "
      :columns="columns"
      row-key="name"
      :pagination="{ rowsPerPage: 20, descending: true }"
    >
      <template v-slot:body="props">
        <q-tr :props="props" @click="openDialog(props.row.name)">
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

import { EnvStore } from "src/stores/env";
import { TranslationStore } from "src/stores/translation";

export default {
  setup() {
    const $t = i18n.global.t;
    const env = EnvStore();
    const translation = TranslationStore();

    console.log(0);

    if (translation.tab != "bg")
      translation.getItemsWithout(translation.tab, null);
    else translation.getItems();

    const functions = {
      openDialog(name) {
        translation.item = {
          name: name,
          lang: translation.tab,
        };
        env.dialogs.translations.saving = true;
        env.dialogs.translations.isSecondLang = true;
      },
    };

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
    };
  },
};
</script>
