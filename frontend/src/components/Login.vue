<template>
  <div class="login container">
    <h1>Login Vue.js Slim3</h1>
    <p><strong>Starter Sample</strong>: Restful API, CRUD, Twig, Bootstrap3</p>
    <p>Page processing by Vue.js</p>
    <p>Version {{ version }}</p>
    <p>&nbsp;</p>
    <form class="form-inline" role="form" @submit.prevent="login">
        <div class="form-group">
            <input type="text" class="form-control" v-model="credentials.pseudo" />
        </div>
        <div class="form-group">
            <input type="password" class="form-control" v-model="credentials.password" />
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Sign in" />
        </div>
    </form>
    <div class="login_bottom">
        <div>Author: Vincseize 2019</div>
        <div>Based on: https://github.com/sarfraznawaz2005/slim3-skeleton</div>
    </div>
  </div>
</template>

<script>
import Auth from 'src/auth';

export default {
    name: 'login',
    data () {
        return {
            version: window.app_version,
            credentials: {
                pseudo: 'demo',
                password: 'demo'
            }
        }
    },
    methods: {
        login() {
            Auth.login(this, this.credentials);
        },

        errorMessage(error) {
            // - TODO : Display the message in the Login page
            console.error(error.code, error.message);
        }
    }
};
</script>

<style scoped>
    .login {
        text-align: center;
    }
    .login_bottom {
        position: absolute;
        padding: 15px;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
