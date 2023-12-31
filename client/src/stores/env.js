import { defineStore } from "pinia";
import { Notify } from "quasar";

import { i18n } from "src/boot/i18n";
import { alphabet } from "src/constants";

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
        isSecondLang: false,
      },
      categories: {
        saving: false,
      },
      tests: {
        saving: false,
      },
      questions: {
        saving: false,
        selectTest: false,
      }
    },
    layout: {
      leftDrower: true,
    },
    languages: [
      {
        key: $t("bulgarian"),
        value: "bg",
      },
      {
        key: $t("english_us"),
        value: "en-US",
      },
      {
        key: $t("russian"),
        value: "ru",
      },
    ],
  }),
  actions: {
    validateEmail(email) {
      const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      return regex.test(email);
    },
    ts(message = $t("save_changes_successfuly")) {
      Notify.create({
        position: "bottom-left",
        timeout: 2500,
        type: "positive",
        progress: true,
        message,
        actions: [{ icon: "close", color: "white" }],
      });
    },
    te(message = $t("something_went_wrong")) {
      Notify.create({
        position: "bottom-left",
        timeout: 2500,
        type: "negative",
        progress: true,
        message: $t(message),
        actions: [{ icon: "close", color: "white" }],
      });
    },
    bulgarianToLatin(text) {
      const words = text.split(/\s+/);

      const convertedWords = words.map((word) => {
        const lowercaseWord = word.toLowerCase();
        const convertedChars = [];
        for (let i = 0; i < lowercaseWord.length; i++) {
          const char = lowercaseWord[i];
          if (alphabet[char]) {
            convertedChars.push(alphabet[char]);
          } else {
            convertedChars.push(char);
          }
        }

        return convertedChars.join("");
      });

      return convertedWords.join("-");
    },
    transformArrayToObject(array) {
      const result = {};

      for (const item of array) {
        result[item.value] = item.key;
      }

      return result;
    },
  },
});
