<template>
  <q-table
    flat
    bordered
    dense
    :rows="filteredRows"
    :columns="columns"
    row-key="id"
    :pagination="{ rowsPerPage: 20, descending: true }"
    :loading="loading"
    :no-data-label="$t('no_records')"
    :rows-per-page-label="$t('records_per_page')"
    :filter="props.filter"
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
    slots: Array,
    filterFn: Function,
    searchTerm: {
      type: String,
      required: false,
    }
  },
  computed: {
    filteredRows() {
      if (this.props.searchTerm) {
        return this.props.rows.filter(row => this.props.filterFn(row, this.props.searchTerm));
      } else {
        return this.props.rows;
      }
    },
  },
  setup(props) {
    return { props };
  },
};
</script>
