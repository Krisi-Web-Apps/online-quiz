<template>
  <q-card style="width: 700px; max-width: 80vw">
    <q-card-section class="text-white bg-primary text-center">
      <div class="text-h6">login</div>
    </q-card-section>

    <q-card-section>
      <q-form ref="loginForm" @submit="submit">
        <div class="q-mb-md">
          <q-input
            filled
            v-model="user.credentials.email"
            label="email"
            hint="enter_a_valid_email"
            autofocus
            :disable="user.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || 'this_field_is_required',
              (val) => (val && env.validateEmail(val)) || 'invalid_email',
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
            label="password"
            hint="enter_a_strong_password"
            autofocus
            :disable="user.loading"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || 'this_field_is_required',
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
        label="login"
        :disable="user.loading"
        :loading="user.loading"
        no-caps
        @click="$.refs.loginForm.submit()"
      />
      <q-btn
        flat
        label="cancel"
        :disable="user.loading"
        no-caps
        v-close-popup
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import { EnvStore } from "src/stores/env";
import { UserStore } from "src/stores/user";

export default {
  name: "LoginDialog",
  setup() {
    const env = EnvStore();
    const user = UserStore();

    const functions = {
      submit() {
        user.login((status, message) => {
          if (status == 201) {
            env.dialogs.users.login = false;
            env.ts("successful_login");
          }
          if (status >= 400) {
            env.te(message);
          }
        });
      },
    };

    return { env, user, ...functions };
  },
};
</script>