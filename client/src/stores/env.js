import { defineStore } from "pinia";
import { Notify } from 'quasar'

export const EnvStore = defineStore("env", {
  state: () => ({
    dialogs: {
      users: {
        register: false,
      },
    },
  }),
  actions: {
    validateEmail(email) {
      const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      return regex.test(email);
    },
    ts(message = "save_changes_successfuly") {
      Notify.create({
        position: 'bottom-left',
        timeout: 2500,
        type: "positive",
        progress: true,
        message,
        actions: [{ icon: 'close', color: 'white' }]
      });
    },
    te(message = "something_went_wrong") {
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
