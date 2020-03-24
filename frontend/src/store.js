import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import user from 'src/stores/user';

Vue.use(Vuex);

export default new Vuex.Store({
    namepaced: true,
    modules: { user },
    plugins: [
        createPersistedState({
            strict: process.env.NODE_ENV !== 'production',
            storage: window.sessionStorage,
            key: 'persistantData',
            paths: ['user'],
        }),
    ]
});
