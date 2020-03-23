import Vue from 'vue';
import VueRouter from 'vue-router';
import vueResource from 'vue-resource';

import App from './components/App';
import About from './components/About';

import Clients from './components/Clients/List';
import Clients_Add from './components/Clients/Add';
import Clients_Edit from './components/Clients/Edit';
import Clients_Details from './components/Clients/Details';

// Global variables
window.project_name = '_SLIM3VUEJS_STARTER';
window.app_version = '0.1.0';
window.base_url = `${window.project_name}/frontend/dist`;
window.api_url = `http://localhost/${window.project_name}/frontend/public/api`;

Vue.use(vueResource);

const router = new VueRouter({
    mode: 'history',
    base: window.base_url,
    routes: [
        {path: '/', component: Clients},
        {path: '/add', component: Clients_Add},
        {path: '/client/:id', component: Clients_Details},
        {path: '/edit/:id', component: Clients_Edit},
        {path: '/about', component: About},
    ]
});
Vue.use(VueRouter);

/* eslint-disable no-new */
new Vue({
    router,
    delimiters: ['${', '}'],
    components: { App },
    template: '<App/>'
}).$mount('#app');
