import Vue from 'vue'
import VueRouter from 'vue-router'
window.axios = require('axios');
Vue.use(VueRouter)

import App from './components/App'
import Welcome from './components/Welcome'
import Page from './components/Page'
import Contact from './components/Contact'

const router = new VueRouter({
    mode: 'hash',
    routes: [
        {
            path: '/home',
            name: 'welcome',
            component: Welcome,
            props: { title: "This is the SPA home" }
        },
        {
            path: '/pwa',
            name: 'page',
            component: Page,
            props: {
                title: "This is the SPA Second Page",
                author : {
                    name : "Fisayo Afolayan",
                    role : "Software Engineer",
                    code : "Always keep it clean"
                }
            }
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact,
            props: {
                title: "Contact",
            }
        },
    ],
})

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});