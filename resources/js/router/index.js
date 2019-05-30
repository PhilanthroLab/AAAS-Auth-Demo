import Vue from 'vue'
import Router from 'vue-router'
import AreYouAUser from "../components/AreYouAUser";
import Login from "../components/Login";
import Register from "../components/Register";
import SelectAuthor from "../components/SelectAuthor";
import AreYouTheAuthor from "../components/AreYouTheAuthor";

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '/',
            name: 'index',
            component: AreYouAUser
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/access-granted',
            name: 'accessGranted',
            component: AreYouTheAuthor
        },
        {
            path: '/select-author',
            name: 'selectAuthor',
            component: SelectAuthor
        },
        {
            path: '*',
            redirect: {
                name: 'index'
            }
        }
    ]
})

function hasQueryParams(route) {
    return !!Object.keys(route.query).length
}

router.beforeEach((to, from, next) => {
    if(!hasQueryParams(to) && hasQueryParams(from)){
        next({name: to.name, query: from.query});
    } else {
        next()
    }
})

export default router