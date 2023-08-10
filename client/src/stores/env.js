import { defineStore } from "pinia";
import { Notify } from 'quasar';
import { i18n } from 'src/boot/i18n';

const $t = i18n.global.t;

export const EnvStore = defineStore("env", {
  state: () => ({
    dialogs: {
      users: {
        register: false,
        login: false,
      },
      translations: {
        saving: false,
      }
    },
    layout: {
      leftDrower: true,
    },
    languages: [
      {
        key: "Български",
        value: "bg"
      },
      {
        key: "English US",
        value: "en-US"
      }
    ]
  }),
  actions: {
    validateEmail(email) {
      const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      return regex.test(email);
    },
    ts(message = $t("save_changes_successfuly")) {
      Notify.create({
        position: 'bottom-left',
        timeout: 2500,
        type: "positive",
        progress: true,
        message,
        actions: [{ icon: 'close', color: 'white' }]
      });
    },
    te(message = $t("something_went_wrong")) {
      Notify.create({
        position: 'bottom-left',
        timeout: 2500,
        type: "negative",
        progress: true,
        message,
        actions: [{ icon: 'close', color: 'white' }]
      });
    }
  },
});
