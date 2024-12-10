import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Video from '../views/Video.vue';
import Gallery from '../views/Gallery.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue') // 如果有首页
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/gallery',
        name: 'Gallery',
        component: Gallery
    },
    {
        path: '/video/:id',
        name: 'Video',
        component: Video,
        props: true
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;
