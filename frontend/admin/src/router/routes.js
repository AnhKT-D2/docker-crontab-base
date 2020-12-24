function page(path) {
  return () => import(`@/pages/${path}`).then(m => m.default || m);
}

function view(path) {
  return () => import(`@/views/${path}`).then(m => m.default || m);
}

function container(path) {
  return () => import(`@/containers/${path}`).then(m => m.default || m);
}
const routes = [
  {
    path: "/sign-in",
    name: "SignIn",
    meta: {
      layout: "GuestLayout",
      requiredAuth: false
    },
    component: page("Login")
  },
  {
    path: "/sign-up",
    name: "SignUp",
    meta: {
      layout: "GuestLayout",
      requiredAuth: false
    },
    component: page("Login")
  },
  {
    path: "/reset-password",
    name: "reset.password",
    meta: {
      layout: "GuestLayout",
      requiredAuth: false
    },
    component: page("ForgotPassword")
  },
  {
    path: "/reset-password/:token",
    name: "reset.password.form",
    meta: {
      layout: "GuestLayout",
      requiredAuth: false
    },
    component: page("ResetForm")
  },
  {
    path: "/",
    redirect: "/dashboard",
    name: "Home",
    meta: {
      layout: "MainLayout",
      requiredAuth: true
    },
    component: container("TheContainer"),
    children: [
      {
        path: "dashboard",
        name: "Dashboard",
        meta: {
          layout: "MainLayout",
          requiredAuth: true
        },
        component: view("Dashboard")
      },
      {
        path: "/users",
        name: "Users",
        meta: {
          layout: "MainLayout",
          requiredAuth: true
        },
        component: view("users/Users")
      },
      {
        path: "/users/create",
        name: "users.create",
        component: view("users/Create")
      },
      {
        path: "/users/:id",
        name: "users.update",
        component: view("users/Update")
      },
      {
        path: "/users/:id/detail",
        name: "users.detail",
        component: view("users/User")
      }
    ]
  }
];

export default routes;
