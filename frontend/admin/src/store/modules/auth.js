import Cookies from "js-cookie";
import * as types from "../mutation.types";
import { signIn, account } from "@/api/auth.api";

export const state = {
  accessToken: Cookies.get("access_token"),
  account: {}
};

export const getters = {
  accessToken: state => state.accessToken,
  account: state => state.account
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
  },
  [types.AUTH.ACCOUNT](state, account) {
    state.account = account;
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
  },
  getAccount({ commit }) {
    return new Promise((resolve, reject) => {
      account()
        .then(response => {
          resolve(response);
          commit(types.AUTH.ACCOUNT, response.data);
        })
        .catch(error => {
          reject(error);
        });
    });
  }
};
