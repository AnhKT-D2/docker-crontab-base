import "core-js/stable";
import "regenerator-runtime/runtime";
import Vue from "vue";
import App from "./App";
import router from "./router";
import CoreUIVue from "@coreui/vue";
import { iconsSet as icons } from "./assets/icons/icons.js";
import store from "./store";
import i18n from "./plugins/i18n";
import MainLayout from "./layouts/MainLayout.vue";
import GuestLayout from "./layouts/GuestLayout.vue";
import { extend } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import { loadVeeValidate } from "@/plugins/vee-validate";

Vue.component("MainLayout", MainLayout);
Vue.component("GuestLayout", GuestLayout);

Object.keys(rules).forEach(rule => {
  extend(rule, {
    ...rules[rule], // copies rule configuration,
    message: loadVeeValidate() // assign message
  });
});

Vue.config.performance = true;
Vue.use(CoreUIVue);
Vue.prototype.$log = console.log.bind(console);

new Vue({
  el: "#app",
  router,
  store,
  i18n,
  icons,
  template: "<App/>",
  components: {
    App
  }
});
