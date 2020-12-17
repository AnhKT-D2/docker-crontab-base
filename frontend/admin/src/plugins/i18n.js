import Vue from "vue";
import VueI18n from "vue-i18n";
import Cookies from "js-cookie";

Vue.use(VueI18n);

const i18n = new VueI18n({
  locale: Cookies.get("locale") || "vi",
  fallbackLocale: Cookies.get("locale") || "vi",
  messages: {}
});

/**
 * @param {String} locale
 */
export async function loadMessages(locale) {
  if (Object.keys(i18n.getLocaleMessage(locale)).length === 0) {
    const messages = await import(`../locales/${locale}.json`);
    i18n.setLocaleMessage(locale, messages);
  }

  if (i18n.locale !== locale) {
    i18n.locale = locale;
  }
}

(async function() {
  await loadMessages(Cookies.get("locale") || "vi");
})();

export default i18n;
