import { SET_LOCALE } from "../mutation.types";
import Cookies from "js-cookie";

export const state = {
  locale: Cookies.get("locale") || "vi"
};

export const getters = {
  locale: state => state.locale
};

export const mutations = {
  [SET_LOCALE](state, { locale }) {
    state.locale = locale;
  }
};

export const actions = {
  setLocale({ commit }, { locale }) {
    commit(SET_LOCALE, { locale });
    Cookies.set("locale", locale, { expires: 365 });
  }
};
