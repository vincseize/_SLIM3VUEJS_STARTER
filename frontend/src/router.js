import Vue from 'vue';
import VueRouter from 'vue-router';
import config from 'src/config';
import Auth from 'src/auth';

import Login from 'components/Login';
import Clients from 'components/Clients/List';
import Clients_Add from 'components/Clients/Add';
import Clients_Edit from 'components/Clients/Edit';
import Clients_Details from 'components/Clients/Details';
import About from 'components/About';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: config.baseUrl,
    routes: [
        {
            path: '/login',
            component: Login,
        },
        {
            path: '/',
            component: Clients,
            meta: { requiresAuth: true }
        },
        {
            path: '/add',
            component: Clients_Add,
            meta: { requiresAuth: true }
        },
        {
            path: '/client/:id',
            component: Clients_Details,
            meta: { requiresAuth: true }
        },
        {
            path: '/edit/:id',
            component: Clients_Edit,
            meta: { requiresAuth: true }
        },
        {
            path: '/about',
            component: About
        },
        { path: '*', redirect: '/' },
    ]
});

router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
  if (requiresAuth && !Auth.is.authenticated) {
    Auth.logout();
    return;
  }

  next();
});

export default router;
