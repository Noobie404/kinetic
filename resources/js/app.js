require('./bootstrap');
import { createApp } from "vue";
window.Vue = require('vue');
import router from './router'
import App from './App.vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import store from "./store";
import Toaster from '@meforma/vue-toaster';
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
