<template>
  <div>
    <custom-table
      :rows="
        translation.tab == 'bg'
          ? translation.displingItems
          : translation.displayWithoutAnyLangItems
      "
      :columns="columns"
      :loading="translation.loading"
      :slots="[{ name: 'body-cell-options', scope: 'props' }]"
    >
      <template v-slot:body-cell-options="props">
        <q-td class="text-right">
          <q-btn
            fab-mini
            flat
            icon="add"
            color="primary"
            @click="openDialog(props.scope.row.name)"
          />
          <q-btn
            fab-mini
            flat
            icon="delete"
            color="negative"
            @click="onClose(props.scope.row.id)"
          />
        </q-td>
      </template>
    </custom-table>
  </div>
</template>

<script>
import { useQuasar } from "quasar";

import { i18n } from "src/boot/i18n";

import { EnvStore } from "src/stores/env";
import { TranslationStore } from "src/stores/translation";

import CustomTable from "src/components/common/CustomTable.vue";

export default {
  components: {
    CustomTable,
  },
  setup() {
    const $t = i18n.global.t;
    const $q = useQuasar();
    const env = EnvStore();
    const translation = TranslationStore();

    if (translation.tab != "bg") {
      translation.getItemsWithout(translation.tab, null);
    } else {
      if (translation.displingItems.length == 0) translation.getItems();
    }

    const functions = {
      openDialog(name) {
        translation.item = {
          name: name,
          lang: translation.tab,
        };
        env.dialogs.translations.saving = true;
        env.dialogs.translations.isSecondLang = true;
      },
      deletedCallback(status, message) {
        if (status == 204) {
          env.ts($t("successful_deleted"));
          if (translation.tab != "bg") translation.getItemsWithout(translation.tab, null);
          else translation.getItems();
        } else {
          env.te(message);
        }
      },
      onClose(id) {
        $q.dialog({
          title: $t("confirm"),
          message: $t("delete_confimation"),
          color: "negative",
          cancel: true,
        }).onOk(() => {
          translation.item.id = id;
          translation.deleteItem(functions.deletedCallback);
        });
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
