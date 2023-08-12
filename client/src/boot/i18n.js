// i18n.js
import { boot } from "quasar/wrappers";
import { createI18n } from "vue-i18n";
import axios from "axios";

const i18n = createI18n({
  locale: localStorage.getItem("locale") || "bg",
  messages: (
    await axios.get("http://localhost/translations", {
      params: { as_key_value_pairs: true },
    })
  ).data,
});

export default boot(async ({ app }) => {
  app.use(i18n);
});

export { i18n };
