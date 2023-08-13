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
          <q-input
            type="textarea"
            filled
            autofocus
            :label="$t('interested_fact')"
            :loading="question.loading"
            :disable="question.loading"
            v-model="question.item.fact"
          >
            <template v-slot:prepend>
              <q-icon name="arrow_forward_ios" />
            </template>
          </q-input>
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

export default {
  setup() {
    const env = EnvStore();
    const question = QuestionStore();
    const $t = i18n.global.t;

    const functions = {
      callback(status, message) {
        if (status == 201 || status == 200) {
          env.dialogs.questions.saving = false;
          env.ts();
          question.getItems();
        } else {
          env.te(message);
        }
      },
      submit() {
        question.saveItem(functions.callback);
      },
      generateSlug(text) {
        const latinText = env.bulgarianToLatin(text);
        question.item.slug = latinText;
      },
    };

    if (!question.item.id) question.setEmptyAnswers(4);

    return { env, question, ...functions };
  },
  methods: {
    deleteAnswer(index) {
      this.question.item.answers.splice(index, 1);
    },
    addAnswer() {
      this.question.item.answers.push({
        text: "",
        is_correct: false,
      });
      this.$refs.answersView.scrollTop = this.$refs.answersView.scrollHeight;
    },
  },
};
</script>
