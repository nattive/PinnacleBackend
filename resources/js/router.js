import VueRouter from 'vue-router'
// Pages
import Register from './components/Register'
import Login from './components/Login'
import Logout from './components/logout'
import index from './components/index'
import ExampleComponent from './components/ExampleComponent'
// import Dashboard from './pages/user/Dashboard'
// import AdminDashboard from './pages/admin/Dashboard'
// Routes
const routes = [{
        path: '/logout',
        name: 'Logout',
        component: Logout,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            // auth: { roles: 'user', redirect: { name: 'login' }, forbiddenRedirect: '/403' }
        }
    },
    {
        path: '/index',
        component: index,
        children: [{
                    path: '/',
                    components: {
                        default: 'AdminDashboard',
                        main: ExampleComponent
                    },
                },


            ]
            // meta: {
            //     auth: { roles: 'user', redirect: { name: 'seller' }, forbiddenRedirect: '/403' }
            // }
    },

    {
        path: '/Register',
        name: 'Register',
        component: Register,
        meta: {
            // auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/403' }
        }
    },

]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router