<template>
  <q-editor
    :model-value="props.modelValue"
    :dense="$q.screen.lt.md"
    :toolbar="[
      [
        {
          label: $q.lang.editor.align,
          icon: $q.iconSet.editor.align,
          fixedLabel: true,
          list: 'only-icons',
          options: ['left', 'center', 'right', 'justify'],
        },
      ],
      ['bold', 'italic', 'strike', 'underline', 'subscript', 'superscript'],
      ['token', 'hr', 'link', 'custom_btn'],
      ['fullscreen'],
      [
        {
          label: $q.lang.editor.formatting,
          icon: $q.iconSet.editor.formatting,
          options: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'code'],
        },
        {
          label: $q.lang.editor.fontSize,
          icon: $q.iconSet.editor.fontSize,
          modelValue: 'normal',
          options: [
            'size-1',
            'size-2',
            'size-3',
            'size-4',
            'size-5',
            'size-6',
            'size-7',
          ],
        },
        {
          label: $q.lang.editor.defaultFont,
          icon: $q.iconSet.editor.font,
          list: 'no-icons',
          options: [
            'default_font',
            'arial',
            'arial_black',
            'comic_sans',
            'courier_new',
            'impact',
            'lucida_grande',
            'times_new_roman',
            'verdana',
          ],
        },
        'removeFormat',
      ],
      ['quote', 'unordered', 'ordered', 'outdent', 'indent'],

      ['undo', 'redo'],
      ['viewsource'],
    ]"
    :fonts="{
      arial: 'Arial',
      arial_black: 'Arial Black',
      comic_sans: 'Comic Sans MS',
      courier_new: 'Courier New',
      impact: 'Impact',
      lucida_grande: 'Lucida Grande',
      times_new_roman: 'Times New Roman',
      verdana: 'Verdana',
    }"
    @update:model-value="(val) => $emit('updateText', val)"
  />
</template>

<script>
export default {
  props: {
    title: {
      default: "",
    },
    modelValue: {
      type: String,
      default: "",
    },
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
.q-editor__content ol li,
.q-editor__content ul li {
  margin-bottom: 5px;
}
</style>
