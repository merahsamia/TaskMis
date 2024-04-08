require('./bootstrap');

import {createApp} from 'vue'
import {store} from './store/store'

import LogoutComponent from './components/auth/LogoutComponent.vue'
import Departments from './components/Departments.vue'
import Users from './components/Users/Users.vue'
import PermissionsCreate from './components/permissions/PermissionsCreate.vue'
import Tasks from './components/tasks/Tasks.vue'
import Inbox from './components/tasks/Inbox.vue'

import NotificationsComponent from './components/NotificationsComponent.vue'

import DashboardComponent from './components/DashboardComponent.vue'
import TasksBarChart from './components/tasks/TasksBarChart.vue'
import ContactComponent from './components/ContactComponent.vue'

import Form from 'vform'
window.Form = Form;

var Emitter = require('tiny-emitter')
window.emitter = new Emitter()

import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'

import Swal from 'sweetalert2'
window.Swal = Swal


import moment from 'moment';

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    }
  });

  window.Toast = Toast

const app= createApp({})

app.component('multi-select', Multiselect);
app.component('logout-component', LogoutComponent);
app.component('departments', Departments);
app.component('permissions-create', PermissionsCreate);
app.component('users', Users);
app.component('tasks', Tasks);
app.component('inbox', Inbox);

app.component('notifications-component', NotificationsComponent);

app.component('dashboard-component', DashboardComponent);
app.component('TasksBarChart', TasksBarChart);

app.component('contact-component', ContactComponent);

app.config.globalProperties.$filters = {
  myDate(date) {
    return moment(date).startOf('hour').fromNow();
  }
}

window.url = '/TaskMis/'

app.use(store)

app.mount('#app')
