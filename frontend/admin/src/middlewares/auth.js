import Cookie from "js-cookie";
import store from "@/store";

export default function auth({ to, next }) {
  const token = Cookie.get("access_token");
  const tokenStore = store.getters["auth/accessToken"];
  const requiredAuth = to.matched.some(record => record.meta.requiredAuth);
  if (requiredAuth) {
    if (!token && !tokenStore) {
      next({ name: "SignIn" });
    } else if (token && tokenStore) {
      store.dispatch("auth/getAccount");
    }
    next();
  } else {
    if (to.name === "SignIn" && token && tokenStore) {
      next({ name: "Home" });
    }
    next();
  }
  next();
}
