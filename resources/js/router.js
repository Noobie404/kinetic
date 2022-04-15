import { createWebHistory, createRouter } from "vue-router";
import Login from './auth/admin/login.vue';
import CustomerLogin from './auth/customer/login.vue';
import CustomerList from './components/admin/customer/CustomerList.vue';
import CreateCustomer from './components/admin/customer/CreateCustomer.vue';
import EditCustomer from './components/admin/customer/EditCustomer.vue';
import BillList from './components/admin/bill/BillList.vue';
import CreateBill from './components/admin/bill/CreateBill.vue';
import EditBill from './components/admin/bill/EditBill.vue';
import CustomerBills from './components/customer/bill/CustomerBills.vue';
const  routes = [
        { path: '',
        redirect: { name: 'CustomerList' }
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
            name: 'CustomerList',
            path: '/',
            component: CustomerList,
            meta: {
                title: 'Kinetik | Admin Panel',
            }
        },
        {
            name: 'CustomerList',
            path: '/customers',
            component: CustomerList,
            meta: {
                title: 'Kinetik | Admin Panel',
            }
        },
        {
            name: 'CreateCustomer',
            path: '/customer/new',
            component: CreateCustomer,
            meta: {
                title: 'Kinetik | Create Customer',
            }
        },
        {
            name: 'EditCustomer',
            path: '/customer/edit/:id',
            component: EditCustomer,
            meta: {
                title: 'Kinetik | Rdit Customer',
            }
        },
        {
            name: 'BillList',
            path: '/bills',
            component: BillList,
            meta: {
                title: 'Kinetik | Bills',
            }
        },
        {
            name: 'CreateBill',
            path: '/bill/new',
            component: CreateBill,
            meta: {
                title: 'Kinetik | Create Customer',
            }
        },
        {
            name: 'EditBill',
            path: '/bill/edit/:id',
            component: EditBill,
            meta: {
                title: 'Kinetik | Edit Bill',
            }
        },
        {
            name: 'CustomerBills',
            path: '/customer/bills',
            component: CustomerBills,
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
export default router;
