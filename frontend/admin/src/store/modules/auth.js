import Cookies from "js-cookie";
import * as types from "../mutation.types";
import { signIn } from "@/api/auth.api";

export const state = {
  accessToken: null
};

export const getters = {
  accessToken: state => state.accessToken
};

export const mutations = {
  [types.AUTH.SIGN_IN](state, account) {
    state.accessToken = account.access_token;
    Cookies.set("access_token", account.access_token, {
      expires: account.expires_in / 86400
    });
  },
  [types.AUTH.LOGOUT](state, account) {
    if (account.status === 200) {
      Cookies.remove("access_token");
      state.accessToken = null;
    }
  }
};

export const actions = {
  signIn({ commit }, payload) {
    return new Promise((resolve, reject) => {
      signIn(payload)
        .then(response => {
          commit(types.AUTH.SIGN_IN, response.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  logout({ commit }) {
    commit(types.AUTH.LOGOUT, { status: 200 });
  }
};
