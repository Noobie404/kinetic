import { createWebHistory, createRouter } from "vue-router";
import Login from './auth/admin/login.vue';
import CustomerLogin from './auth/customer/login.vue';
import Home from './components/Home.vue';
import CustomerHome from './components/CustomerHome.vue';
const  routes = [
        { path: '',
        redirect: { name: 'Home' }
        },
        {
            name: 'Login',
            path: '/login',
            component: Login,
            meta: {
              title: 'Login',
            }
        },
        {
            name: 'CustomerLogin',
            path: '/customer/login',
            component: CustomerLogin,
            meta: {
              title: 'Login',
            }
        },
        {
            name: 'Home',
            path: '/',
            component: Home,
            meta: {
                title: 'Kinetik | Admin Panel',
            }
        },
        {
            name: 'CustomerHome',
            path: '/customer',
            component: CustomerHome,
            meta: {
                title: 'Kinetik | Customer Panel',
            }
        },
];

const router = createRouter({
    history: createWebHistory(),
    base: process.env.BASE_URL,
    routes: routes,
    linkActiveClass: 'active'
});

router.beforeEach((to, from) => {
    let documentTtitle = `${process.env.APP_NAME}-${to.name}`;
    if(to.params.title){
        documentTtitle+= `-${to.params.title}`;
    }
})
//   router.beforeEach((to, from, next) => {
//     let language = to.params.lang;
//     if (!language) {
//         language = 'en'
//     }
//     VueI18n.locale = language
//     console.log("Active locale: ", VueI18n.locale)
//     next()
// })
export default router;
