import Vue from "vue";
import Meta from "vue-meta";
import Router from "vue-router";
import routes from "./routes";
import middlewareAuth from "@/middlewares/auth";

Vue.use(Meta);
Vue.use(Router);

const router = createRouter();

/**
 * Create a new router instance.
 *
 * @return {Router}
 */
function createRouter() {
  const router = new Router({
    mode: "history",
    linkActiveClass: "active",
    scrollBehavior: () => ({ y: 0 }),
    routes
  });

  return router;
}

/**
 * Global middlware
 *
 * @return {Array}
 */
function globalMiddleware() {
  return [middlewareAuth];
}

/**
 * Each a middleware
 *
 * @return {void}
 */
function nextFactory(context, middleware, index) {
  const subsequentMiddleware = middleware[index];
  if (!subsequentMiddleware) return context.next;

  return (...parameters) => {
    context.next(...parameters);
    const nextMiddleware = nextFactory(context, middleware, index + 1);
    subsequentMiddleware({ ...context, next: nextMiddleware });
  };
}

router.beforeEach((to, from, next) => {
  var middleware = null;
  var routeMiddleware = null;

  if (to.meta.middleware) {
    routeMiddleware = Array.isArray(to.meta.middleware)
      ? to.meta.middleware
      : [to.meta.middleware];
  }
  middleware = routeMiddleware
    ? globalMiddleware().concat(routeMiddleware)
    : globalMiddleware();

  if (middleware.length > 0) {
    const context = { to, from, next, router };
    const nextMiddleware = nextFactory(context, middleware, 1);

    return middleware[0]({ ...context, next: nextMiddleware });
  }

  return next();
});

export default router;
