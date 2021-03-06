
const routes = [
  {
    path: '/',
    component: () => import('layouts/LoginLayout.vue'),
    children: [
      { path: '/', component: () => import('pages/Login.vue') },
      { path: '/logout', component: () => import('pages/Logout.vue') },
    ],
  },
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '/index', component: () => import('pages/Index.vue') },
      { path: 'portifolios', component: () => import('pages/Portifolio.vue') },
      { path: 'portifolios/new', component: () => import('pages/PortifolioNew.vue') },
      { path: 'portifolios/:id', component: () => import('pages/PortifolioEdit.vue') },
    ],
  },
];

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue'),
  });
}

export default routes;
