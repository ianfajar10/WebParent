import { createRouter, createWebHistory } from "vue-router";

import homeAdminIndex from '../components/admin/home/Index.vue';
import homePagesIndex from '../components/pages/home/Index.vue';
import notFound from '../components/NotFound.vue';
import login from '../components/auth/Login.vue';
import register from '../components/auth/Register.vue';

const routes = [
    {
        path: '/register',
        name: 'Register',
        component: register,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/admin/home',
        name: 'adminHome',
        component: homeAdminIndex,
        meta:{
            requiresAuth:true
        }
    },
    {
        path: '/',
        name: 'Home',
        component: homePagesIndex,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notFound',
        component: notFound,
        meta: {
            requiresAuth: false
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to,from) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')) {
        return { name : 'Login' }
    }

    if (to.meta.requiresAuth == false && localStorage.getItem('token')) {
        if (localStorage.getItem('name') === 'admin') {
            return {
                name: 'adminHome'
            }
        }
    }
})

export default router
