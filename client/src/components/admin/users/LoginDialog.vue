<template>
  <q-card style="width: 700px; max-width: 80vw">
    <q-card-section class="text-white bg-primary text-center">
      <div class="text-h6">{{ $t("login") }}</div>
    </q-card-section>

    <q-card-section>
      <q-form ref="loginForm" @submit="submit" @keydown.enter="submit">
        <div class="q-mb-md">
          <q-input
            filled
            v-model="user.credentials.email"
            :label="$t('email')"
            :hint="$t('enter_a_valid_email_address')"
            autofocus
            :disable="user.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
              (val) => (val && env.validateEmail(val)) || $t('invalid_email'),
            ]"
          >
            <template v-slot:prepend>
              <q-icon name="mail" />
            </template>
          </q-input>
        </div>
        <div class="q-mb-md">
          <q-input
            filled
            v-model="user.credentials.password"
            :label="$t('password')"
            :hint="$t('enter_a_strong_password')"
            autofocus
            :disable="user.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || $t('this_field_is_required'),
            ]"
          >
            <template v-slot:prepend>
              <q-icon name="lock" />
            </template>
          </q-input>
        </div>
      </q-form>
    </q-card-section>

    <q-card-actions class="text-white bg-secondary text-center">
      <q-btn
        flat
        :label="$t('login')"
        :disable="user.loading"
        :loading="user.loading"
        no-caps
        @click="$.refs.loginForm.submit()"
      />
      <q-btn
        flat
        :label="$t('register')"
        :disable="user.loading"
        no-caps
        v-close-popup
        @click="openRegisterDialog"
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { i18n } from "src/boot/i18n";
import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";

export default {
  name: "LoginDialog",
  setup() {
    const env = EnvStore();
    const user = UserStore();
    const $t = i18n.global.t;

    const functions = {
      submit() {
        user.login((status, message) => {
          if (status == 201) {
            env.dialogs.users.login = false;
            env.ts($t('successful_login'));
            user.getUser();
          }
          if (status >= 400) {
            env.te(message);
          }
        });
      },
      openRegisterDialog() {
        env.dialogs.users.login = false;
        env.dialogs.users.register = true;
      }
    };

    return { env, user, ...functions };
  },
};
</script>
