<template>
  <q-card class="medium-dialog">
    <q-card-section class="text-white bg-primary text-center">
      <div class="text-h6">
        {{ !question.item.id ? $t("add_question") : $t("edit_question") }}
      </div>
    </q-card-section>
    <q-card-section>
      <q-form ref="questionForm" @submit="submit">
        <div class="q-mb-md">
          <q-input
            filled
            autofocus
            lazy-rules
            v-model="question.item.title"
            :label="$t('title')"
            :disable="question.loading"
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
          >
            <template v-slot:prepend>
              <q-icon name="contact_support" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md" ref="answersView">
          <div
            v-for="(item, index) in question.item.answers"
            :key="index"
            class="q-mb-lg"
          >
            <q-input
              filled
              autofocus
              v-model="item.text"
              :label="`${$t('answer')} ${index + 1}`"
              :disable="question.loading"
              lazy-rules
              :rules="[
                (val) =>
                  (val && val.length > 0) || $t('this_field_is_required'),
              ]"
            >
              <template v-slot:prepend>
                <q-icon name="arrow_forward_ios" />
              </template>
              <template v-slot:after>
                <q-btn
                  v-if="question.item.answers.length > 2"
                  flat
                  fab-mini
                  icon="delete"
                  color="negative"
                  @click="deleteAnswer(index)"
                />
                <q-btn
                  flat
                  fab-mini
                  icon="add"
                  color="ponitive"
                  @click="addAnswer"
                />
              </template>
            </q-input>
            <q-checkbox
              :label="$t('correct_answer')"
              v-model="item.is_correct"
            />
          </div>
        </div>
        <div class="q-mb-md">
          <text-editor
            @updateText="onUpdateText"
            :model-value="question.item.fact"
          />
        </div>
        <div class="q-mb-md">
          <q-select
            filled
            v-model="question.item.lang"
            :label="$t('language')"
            :disable="question.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
            :options="env.languages"
            emit-value
            map-options
            :option-label="(val) => val.key"
            :option-value="(val) => val.value"
          >
            <template v-slot:prepend>
              <q-icon name="language" />
            </template>
          </q-select>
        </div>
      </q-form>
    </q-card-section>
    <q-card-actions class="text-white bg-secondary text-center">
      <q-btn
        flat
        :disable="question.loading"
        :loading="question.loading"
        no-caps
        @click="$.refs.questionForm.submit()"
        :label="!question.item.id ? $t('add_question') : $t('edit_question')"
        :icon="!question.item.id ? 'add' : 'save'"
      />
      <q-btn
        flat
        :label="$t('cancel')"
        icon="close"
        :disable="question.loading"
        no-caps
        v-close-popup
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { i18n } from "src/boot/i18n";

import { QuestionStore } from "src/stores/question";
import { EnvStore } from "src/stores/env";

import TextEditor from "src/components/admin/common/TextEditor.vue";
import { useRoute } from "vue-router";

export default {
  components: {
    TextEditor,
  },
  setup() {
    const route = useRoute();
    const env = EnvStore();
    const question = QuestionStore();
    const $t = i18n.global.t;

    if (!question.item.id) question.setEmptyAnswers(4);

    return { route, env, question };
  },
  methods: {
    callback(status, message) {
      if (status == 201 || status == 200) {
        this.env.dialogs.questions.saving = false;
        this.env.ts();
        if (this.route.query.test) {
          this.question.getItems(null, {
            test_id: this.route.query.test,
          });
        } else {
          this.question.getItems(null, {
            all: true,
          });
        }
      } else {
        this.env.te(message);
      }
    },
    submit() {
      this.question.saveItem(this.callback);
    },
    generateSlug(text) {
      const latinText = this.env.bulgarianToLatin(text);
      this.question.item.slug = latinText;
    },
    onUpdateText(text) {
      this.question.item.fact = text;
    },
    deleteAnswer(index) {
      this.question.item.answers.splice(index, 1);
    },
    addAnswer() {
      this.question.item.answers.push({
        text: "",
        is_correct: false,
      });
    },
  },
};
</script>
