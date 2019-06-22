import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import 'ag-grid-enterprise';
import App from './components/App'
import Templates from './components/Templates'
import Page from './components/Page'
import Contact from './components/Contact'
import VueSweetalert2 from 'vue-sweetalert2';



window.axios = require('axios');
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(Vuex);
Vue.use(VueSweetalert2);




const router = new VueRouter({
    mode: 'hash',
    routes: [
        {
            path: '/templates',
            name: 'templates',
            component: Templates,
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
});

const app = new Vue({
    el: '#app',
    components: { App},
    router,
});