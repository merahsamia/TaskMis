require('./bootstrap');

import {createApp} from 'vue'

import Departments from './components/Departments.vue'
const app= createApp({})

app.component('departments', Departments);

window.url = '/TaskMis/'

app.mount('#app')