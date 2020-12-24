import "core-js/stable";
import "regenerator-runtime/runtime";
import Vue from "vue";
import App from "./App";
import router from "./router";
import CoreUIVue from "@coreui/vue";
import { iconsSet as icons } from "./assets/icons/icons.js";
import store from "./store";
import i18n from "./plugins/i18n";
import plugins from "./plugins";
import MainLayout from "./layouts/MainLayout.vue";
import GuestLayout from "./layouts/GuestLayout.vue";
import { extend } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import { loadVeeValidate } from "@/plugins/vee-validate";
import firebase from "firebase";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

Vue.component("MainLayout", MainLayout);
Vue.component("GuestLayout", GuestLayout);

Object.keys(rules).forEach(rule => {
  extend(rule, {
    ...rules[rule], // copies rule configuration,
    message: loadVeeValidate() // assign message
  });
});

Vue.use(VueToast);
Vue.config.performance = true;
Vue.use(CoreUIVue);
Vue.use(plugins);
Vue.prototype.$log = console.log.bind(console);
Vue.use(firebase);

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
