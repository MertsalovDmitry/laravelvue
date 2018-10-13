require('./bootstrap');

window.Vue = require('vue');
//window.VueRouter=require('vue-router').default;
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import Autocomplete from 'v-autocomplete';
Vue.use(Autocomplete);

const Listemployees = Vue.component('Listemployees', require('./components/employees/Listemployees.vue'));
const Createemployee = Vue.component('create-employee', require('./components/employees/Createemployee.vue'));
const Editemployee = Vue.component('edit-employee', require('./components/employees/Editemployee.vue'));
const Deleteemployee = Vue.component('delete-employee', require('./components/employees/Deleteemployee.vue'));
const Tree = Vue.component('employees-tree', require ('./components/employees/Tree.vue'));

const routes = [
    { path: '/', component: Tree, name: 'employees-tree' },
    { path: '/list', component: Listemployees, name: 'Listemployees'},
    { path: '/employees/create', component: Createemployee, name: 'create-employee' },
    { path: '/employees/edit/:id', component: Editemployee, name: 'edit-employee' },
    { path: '/employees/delete', component: Deleteemployee, name: 'delete-employee' },

]

 const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue({ router }).$mount('#app')
