import Vue from 'vue';
import VueRouter from 'vue-router';

import About from '../layout/sites/About.vue';
import Career from '../layout/sites/Career.vue';
import Home from '../layout/sites/Home.vue';
import Login from '../layout/sites/Login';

Vue.use(VueRouter);

export const path = {
    home: '/',
    about: '/about',
    career: '/career',
    login: '/login',
};

const routes = [
    {path: '*', redirect: '/'},
    {path: path.home, component: Home},
    {path: path.about, component: About},
    {path: path.career, component: Career},
    {path: path.login, component: Login},
];

export const router = new VueRouter({
    mode: 'history',
    routes
});
