require('./bootstrap');
import { createApp } from "vue";
window.Vue = require('vue');
import router from './router'
import App from './App.vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import store from "./store";
import Toaster from '@meforma/vue-toaster';
// import "./assets/css/style.css";
// import "./assets/css/color-theme1.css";
// import "line-awesome/dist/line-awesome/css/line-awesome.min.css";
// import "./assets/css/responsive.css?v=1.0";
const { reactive } = Vue;
const app = createApp();
app.config.globalProperties.axios=axios
createApp(App)
.use(VueAxios, axios)
.use(router, router)
.use(reactive)
.use(store)
.use(Toaster)
.mount('#app')
