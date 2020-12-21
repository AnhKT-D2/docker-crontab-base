<template>
  <select
    v-model="localeSelect"
    class="form-control"
    @change="changeLanguage($event)"
  >
    <option v-for="(locale, key) in locales" :value="locale" :key="key">{{
      $t(`locales.${locale}`)
    }}</option>
  </select>
</template>

<script>
import Cookies from "js-cookie";
import { loadMessages } from "@/plugins/i18n";
import { loadVeeValidate } from "@/plugins/vee-validate";
export default {
  name: "BoxLanguage",
  data() {
    return {
      locales: ["vi", "en", "ja"],
      localeSelect: Cookies.get("locale") || "vi"
    };
  },
  methods: {
    changeLanguage(event) {
      let locale = event.target.value;
      if (this.$i18n.locale !== locale) {
        this.localeSelect = locale;
        loadMessages(locale);
        loadVeeValidate(locale);
        this.$store.dispatch("lang/setLocale", { locale });
      }
    }
  }
};
</script>
