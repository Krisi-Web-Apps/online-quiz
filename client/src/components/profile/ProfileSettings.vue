<template>
  <q-form @submit.prevent="submit">
    <div class="q-mb-md">
      <q-select
        clearable
        filled
        v-model="user.me.lang"
        :label="$t('lang')"
        :options="env.languages"
        :option-label="(val) => val.key"
        :option-value="(val) => val.value"
        emit-value
        map-options
      />
    </div>
    <q-btn
      type="submit"
      :disable="user.loading"
      :loading="user.loading"
      no-caps
      color="primary"
      :label="$t('save')"
      icon="save"
    />
  </q-form>
</template>

<script>
import { useI18n } from "vue-i18n";

import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";

export default {
  setup() {
    const env = EnvStore();
    const user = UserStore();
    const { locale } = useI18n();

    const functions = {
      callback(status, message) {
        if (status == 200) {
          functions.changeLocale(user.me.lang);
          env.ts();
        }
        if (status >= 400) {
          env.te(message);
        }
      },
      submit() {
        user.saveItem(functions.callback);
      },
      changeLocale(l) {
        locale.value = l;
        localStorage.setItem("locale", l);
      },
    };
    return { env, user, ...functions };
  },
};
</script>
