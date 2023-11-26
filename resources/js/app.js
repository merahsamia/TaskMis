require('./bootstrap');

import {createApp} from 'vue'
import {store} from './store/store'

import LogoutComponent from './components/auth/LogoutComponent.vue'
import Departments from './components/Departments.vue'
import Users from './components/Users/Users.vue'
import PermissionsCreate from './components/permissions/PermissionsCreate.vue'

import Form from 'vform'
window.Form = Form;

import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'

const app= createApp({})

app.component('logout-component', LogoutComponent);
app.component('departments', Departments);
app.component('permissions-create', PermissionsCreate);
app.component('users', Users);
app.component('multi-select', Multiselect);

window.url = '/TaskMis/'

app.use(store)

app.mount('#app')
