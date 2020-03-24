import Vue from 'vue';
import vueResource from 'vue-resource';

import config from 'src/config';
import router from 'src/router';
import Auth from 'src/auth';
import store from 'src/store';
import App from 'components/App';

// Global variables
window.app_version = config.appVersion;
window.api_url = `${config.serverRoot}${config.baseUrl}/api`;

Vue.use(vueResource);

// Authorization
Auth.checkAuth();

new Vue({
    router,
    store,
    delimiters: ['${', '}'],
    components: { App },
    template: '<App/>'
}).$mount('#app');
