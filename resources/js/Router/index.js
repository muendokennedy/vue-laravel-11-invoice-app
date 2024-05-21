import {createRouter, createWebHistory} from "vue-router";
import Home from '../components/invoices/index.vue';
import NotFound from '../components/NotFound.vue';

const routes = [
    {
        path: '/',
        name: 'invoice.index',
        component: Home
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notfound',
        component: NotFound
    },
    {
        path: '/invoice/new',
        name: 'newInvoice',
        component: import('../components/invoices/newInvoice.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
