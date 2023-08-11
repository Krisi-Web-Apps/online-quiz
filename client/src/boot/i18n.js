import { boot } from "quasar/wrappers";
import { createI18n } from "vue-i18n";
import axios from "axios";

let translations;

(async () => {
  const storedTranslations = localStorage.getItem("translations");

  if (storedTranslations) {
    translations = JSON.parse(storedTranslations);
  } else {
    try {
      const response = await axios.get("http://localhost/translations/all");
      translations = response.data;
      localStorage.setItem("translations", JSON.stringify(translations));
    } catch (error) {
      if (error.message === "Network Error") {
        env.te("Network Error");
      }
    }
  }
})();

// if (!localStorage.getItem("translations"))
//   localStorage.setItem("translations", JSON.stringify(translations));

const i18n = createI18n({
  locale: localStorage.getItem("locale") || "bg",
  messages: translations
});
export default boot(async ({ app }) => {
  // Set i18n instance on app

  app.use(i18n);
});

export { i18n };
