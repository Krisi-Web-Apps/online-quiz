import { boot } from "quasar/wrappers";
import { createI18n } from "vue-i18n";
import axios from "axios";
const translations = localStorage.getItem("translations")
  ? JSON.parse(localStorage.getItem("translations"))
  : (await axios.get("http://localhost/translations/all", { params: { lang: "bg" } })).data;
// if (!localStorage.getItem("translations"))
//   localStorage.setItem("translations", JSON.stringify(translations));

const i18n = createI18n({
  locale: localStorage.getItem("lang") || "bg",
  messages: {
    bg: translations,
  }
});
export default boot(async ({ app }) => {
  // Set i18n instance on app

  app.use(i18n);
});

export { i18n };
