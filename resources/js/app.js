require('./bootstrap');

import {createApp} from 'vue'

import Departments from './components/Departments.vue'

import Form from 'vform'
window.Form = Form;

const app= createApp({})

app.component('departments', Departments);

window.url = '/TaskMis/'

app.mount('#app')
