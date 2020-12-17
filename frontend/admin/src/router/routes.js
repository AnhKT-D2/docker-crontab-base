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
      }
    ]
  }
];

export default routes;
