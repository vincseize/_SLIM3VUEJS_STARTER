<template>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button
                    type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#navbar"
                    aria-expanded="false"
                    aria-controls="navbar"
                >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <router-link tag="a" class="navbar-brand" to="/">Vuejs Slim3</router-link>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li v-if="isAuth">
                        <router-link to="/">Clients</router-link>
                    </li>
                    <li>
                        <router-link to="/about">About</router-link>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li v-if="isAuth">
                        <router-link to="/add"><i class="fa fa-plus" /> Add Clients</router-link>
                    </li>
                    <li v-if="isAuth">
                        <button class="btn btn-default" style="margin-top: 7px;" @click="logout" title="log out">
                            <i class="fa fa-power-off" />
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import store from 'src/store';
import Auth from 'src/auth';

export default {
    name: 'Navbar',
    computed: {
        isAuth() {
            return store.state.user.id !== null;
        }
    },
    methods: {
        logout() {
            Auth.logout();
        }
    }
};
</script>
