import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes.js'
import store from '../store'
import {CONSTANTS} from "../constants";

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    if (store.getters.user) {
        if (to.meta.hasOwnProperty('requiredRoles') && !to.meta.requiredRoles.includes(store.getters.user.role)) {
            next({ name: 'welcome' })
        } else {
            if (to.matched.some(route => route.meta.guard === CONSTANTS.ROUTE.GUARD_GUEST)) next({ name: 'home' })
            else next();
        }
    } else {
        if (to.matched.some(route => route.meta.guard === CONSTANTS.ROUTE.GUARD_AUTH)) next({ name: 'login' })
        else next();
    }
})

export default router;
