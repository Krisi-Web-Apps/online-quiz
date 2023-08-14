<template>
  <q-editor
    :model-value="props.modelValue"
    @update:model-value="(val) => $emit('updateText', val)"
    flat
    class="text-editor"
    toolbar-bg="grey-3"
    :toolbar="[
      ['bold', 'italic', 'underline'],
      [
        {
          label: $q.lang.editor.formatting,
          icon: $q.iconSet.editor.formatting,
          list: 'no-icons',
          options: ['p', 'h3', 'h4', 'h5', 'h6', 'code'],
        },
      ],
    ]"
  />
</template>

<script>
import { ref } from "vue";

export default {
  props: {
    title: {
      default: "",
    },
    modelValue: String,
  },
  setup(props) {
    return { props };
  },
};
</script>

<style>
.text-editor {
  border: 1px solid #efefef;
}
</style>
