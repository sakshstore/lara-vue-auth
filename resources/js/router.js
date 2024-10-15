
import { createRouter, createWebHistory } from 'vue-router';
import SendOtp from './components/SendOtp.vue';
import VerifyOtp from './components/VerifyOtp.vue';

const routes = [
    {
        path: '/',
        name: 'SendOtp',
        component: SendOtp,
    },
    {
        path: '/verify',
        name: 'VerifyOtp',
        component: VerifyOtp,
        props: route => ({ email: route.params.email }),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;