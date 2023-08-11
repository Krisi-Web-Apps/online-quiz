<template>
  <q-table
    flat
    bordered
    dense
    :rows="rows"
    :columns="columns"
    row-key="id"
    :pagination="{ rowsPerPage: 20, descending: true }"
    :loading="loading"
    :no-data-label="$t('no_records')"
    :rows-per-page-label="$t('records_per_page')"
  >
    <template v-for="slot in slots" v-slot:[slot.name]="scope">
      <slot :name="slot.name" :scope="scope" />
    </template>
  </q-table>
</template>

<script>
export default {
  props: {
    rows: Array,
    columns: Array,
    loading: Boolean,
    slots: Array
  },
  setup(props) {
    return { ...props };
  },
};
</script>
