// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './templates/App'
import VueRouter from 'vue-router'
import vueResource from 'vue-resource'

import About from './components/About'

import Clients from './components/Clients'
import Clients_Add from './components/Clients_Add'
import Clients_Edit from './components/Clients_Edit'
import Clients_Details from './components/Clients_Details'

Vue.use(vueResource)
Vue.use(VueRouter)

//global variables
window.base_url = "_SLIM3VUEJS_STARTER/frontend/dist"
window.api_url  = "http://localhost/_SLIM3VUEJS_STARTER/frontend/public/api"

const router = new VueRouter({
  mode: 'history',
  // base: __dirname,
  base: window.base_url,
  routes: [

    {path: '/', component: Clients},
    {path: '/add', component: Clients_Add},
    {path: '/client/:id', component: Clients_Details},
    {path: '/edit/:id', component: Clients_Edit},
    {path: '/about', component: About},

  ]
})

/* eslint-disable no-new */
new Vue({
  router,
  delimiters: ['${', '}'],
  components: {
    App
  },
  template: '<App/>'

}).$mount('#app')
