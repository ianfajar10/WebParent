import { createRouter, createWebHistory } from "vue-router";

import homeAdminIndex from '../components/admin/home/Index.vue';
import homePagesIndex from '../components/pages/home/Index.vue';
import notFound from '../components/NotFound.vue';

const routes = [
    {
        path: '/admin/home',
        component: homeAdminIndex
    },
    {
        path: '/',
        component: homePagesIndex
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
