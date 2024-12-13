import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue') // 如果有首页
    },
    {
        path: '/aboutUs',
        name: 'AboutUs',
        component: () => import('../views/teammember.vue') // 你可能需要创建一个 Articles.vue 页面
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
        path: '/login',
        name: 'login',
        component: () => import('../views/Login.vue'),
        meta: {
            showNavBar: false
        }
    },
    {
        path: '/admin',
        name: 'admin',
        component: () => import('../views/adminLogin.vue'),
        meta: {
            showNavBar: false
        }
    },
    {
        path: '/articles',
        name: 'article',
        component: () => import('../views/ArticleView.vue'),
        meta: {
            showNavBar: true
        }
    },
    {
        path: '/article/:id',
        name: 'articleplay',
        component: () => import('../views/ArticlePlay.vue'),
        meta: {
            showNavBar: true
        }
    },
    {
        path: '/videoview',
        name: 'VideoView',
        component: () => import('../views/VideoView.vue'),
    },
    {
        path: '/video/:id',
        name: 'VideoPlay',
        component: () => import('../views/VideoPlay.vue'),
        props: true
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;
