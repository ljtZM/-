import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Home from '../views/Home.vue'; 

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home // 如果有首页
    },
    {
        path: '/aboutUs',
        name: 'AboutUs',
        component: () => import('../views/AboutUs.vue') // 你可能需要创建一个 Articles.vue 页面
    },
    {
        path: '/projectIntro',
        name: 'ProjectIntro',
        component: () => import('../views/ProjectIntro.vue') // 你可能需要创建一个 Articles.vue 页面
    },
    {
        path: '/profile',
        name: 'Profile',
        component: () => import('../views/Profile.vue') // 创建 Profile 页面
    },
    {
        path: '/articles',
        name: 'Articles',
        component: () => import('../views/Articles.vue')  // 文章专区
    },
    {
        path: '/videos',
        name: 'Videos',
        component: () => import('../views/Videos.vue')  // 视频专区
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;
