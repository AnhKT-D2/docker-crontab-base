import axios from "axios";
import store from "@/store";
import Cookie from "js-cookie";
import router from "@/router";

const service = axios.create({
  baseURL: "http://localhost/api/",
  headers: {
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
    "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token"
  },
  timeout: 30000 * 4
});

service.interceptors.request.use(
  config => {
    let token = store.getters["auth/accessToken"];
    if (token) {
      config.headers.common["Accept"] = "application/json";
      config.headers.common["Authorization"] = `Bearer ${token}`;
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
      router.push({ name: "SignIn" });
    }

    return Promise.reject(error.response.data);
  }
);

export default service;
