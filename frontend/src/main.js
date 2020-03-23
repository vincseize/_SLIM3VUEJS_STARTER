import Vue from 'vue';
import VueRouter from 'vue-router';
import vueResource from 'vue-resource';

import config from 'src/config';
import App from 'components/App';
import About from 'components/About';

import Clients from 'components/Clients/List';
import Clients_Add from 'components/Clients/Add';
import Clients_Edit from 'components/Clients/Edit';
import Clients_Details from 'components/Clients/Details';

// Global variables
window.app_version = config.appVersion;
window.api_url = `${config.serverRoot}${config.baseUrl}/api`;

Vue.use(vueResource);

const router = new VueRouter({
    mode: 'history',
    base: baseUrl,
    routes: [
        {path: '/', component: Clients},
        {path: '/add', component: Clients_Add},
        {path: '/client/:id', component: Clients_Details},
        {path: '/edit/:id', component: Clients_Edit},
        {path: '/about', component: About},
    ]
});
Vue.use(VueRouter);

new Vue({
    router,
    delimiters: ['${', '}'],
    components: { App },
    template: '<App/>'
}).$mount('#app');
