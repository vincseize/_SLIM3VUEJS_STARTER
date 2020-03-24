import router from 'src/router';
import store from 'src/store';

export default {
    is: { authenticated: false },

    login(context, credentials) {
        context.$http.post(`${api_url}/token`, credentials)
        .then(({ data }) => {
            window.sessionStorage.setItem('token', data.token);
            window.sessionStorage.setItem('user', data.user);

            this.is.authenticated = true;
            store.commit('user/init', data.user);

            router.replace('/');
        })
        .catch((error) => {
            console.log(error);
            if (!error.response) {
                context.errorMessage({ code: 0, message: 'network error' });
                return;
            }

            const { status, data } = error.response;
            const code = (status === 404 && !data.error) ? 0 : 404;
            const message = data.error ? data.error.message : 'network error';
            context.errorMessage({ code, message });
        });
    },

    logout() {
        store.commit('user/reset');

        window.sessionStorage.clear();
        this.is.authenticated = false;

        router.replace({ path: '/login' });
    },

    checkAuth() {
        const token = window.sessionStorage.getItem('token');
        if (!token) {
            this.logout();
            return;
        }

        this.is.authenticated = true;
        router.replace('/');
    },
};
