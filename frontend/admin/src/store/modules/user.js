import {
  deleteUser,
  createUser,
  getUsers,
  showUser,
  updateUser,
  requestSendMail,
  resetPassword
} from "@/api/user.api";
import * as type from "../mutation.types";

export const state = {
  users: [],
  user: []
};

export const getters = {
  users: state => state.users,
  user: state => state.user
};

export const mutations = {
  [type.USERS.FETCH_USERS](state, users) {
    state.users = users;
  },
  [type.USERS.FETCH_USER](state, user) {
    state.user = user;
  }
};

export const actions = {
  getUsers({ commit }, param) {
    return new Promise((resolve, reject) => {
      getUsers(param)
        .then(response => {
          commit(type.USERS.FETCH_USERS, response.data.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  createUser({}, data) {
    return new Promise((resolve, reject) => {
      createUser(data)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  deleteUser({}, param) {
    return new Promise((resolve, reject) => {
      deleteUser(param)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  showUser({ commit }, param) {
    return new Promise((resolve, reject) => {
      showUser(param)
        .then(response => {
          commit(type.USERS.FETCH_USER, response.data);
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  updateUser({}, param) {
    return new Promise((resolve, reject) => {
      updateUser(param)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  requestSendMail({}, param) {
    return new Promise((resolve, reject) => {
      requestSendMail(param)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  },
  resetPassword({}, param) {
    return new Promise((resolve, reject) => {
      resetPassword(param)
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
    });
  }
};
