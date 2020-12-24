import axios from "axios";
import store from "@/store";
import Cookie from "js-cookie";
import i18n from "../plugins/i18n";
import router from "@/router";

const service = axios.create({
  baseURL: "http://localhost:8089/api/",
  headers: {
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
    "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token"
  },
  timeout: 30000 * 4
});

service.interceptors.request.use(
  config => {
    const token =
      store.getters["auth/accessToken"] || Cookie.get("access_token");
    const locale = Cookie.get("locale");
    if (token) {
      config.headers.common["Accept"] = "application/json";
      config.headers.common["Authorization"] = `Bearer ${token}`;
    }

    if (locale) {
      config.headers.common["Accept-Language"] = locale;
    }

    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

service.interceptors.response.use(
  response => response.data,
  error => {
    if (error.response.status === 401) {
      Cookie.remove("access_token");
      // router.push({ name: "SignIn" });
      return Promise.reject(error);
    }

    if (error.response.status === 403 || error.response.status === 404) {
      router.push({ name: error.response.status.toString() });
      return Promise.reject(error);
    }

    if (error.response.status >= 400) {
      Cookie.remove("access_token");
      return Promise.reject(error);
    }

    let msg = i18n.t(`error.default`);
    if (
      error.response.status === 422 &&
      error.response.data.error.code === 4220
    ) {
      let messages = error.response.data.error.message;
      let firstKey = Object.keys(messages)[0];
      let firstValue = messages[firstKey][0];
      let part = firstValue.slice(
        firstValue.indexOf(".") + 1,
        firstValue.length
      );
      msg = i18n.t(`error.validation.${firstKey}.${part}`);
    } else {
      if (error.response.data.error.code) {
        msg = i18n.t(`error.${error.response.data.error.code}`);
      }
    }

    // alert("Lỗi: " + msg);
  }
);

export default service;
