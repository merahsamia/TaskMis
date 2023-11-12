import axios from 'axios';

export default {
    state: {
        //departments_test: 0,
        departments: {},
    },


    getters: {
        departments(state) {
            return state.departments
        }
    },


    mutations: {
        set_departments: (state, data) => {
            state.departments = data
        }
    },


    actions:{
        storeDepartment: (context, departmentData) => {
            departmentData.post(window.url + 'api/storeDepartment')
            .then((response) => {
                context.dispatch('getDepartments')  ,
                $('#exampleModal').modal('hide')
            })
        },

        getDepartments: (context) => {
            axios.get(`${window.url}api/getDepartments`).then((response) => {
                context.commit('set_departments', response.data)
            })

        },

        updateDepartment(context, departmentData) {

            departmentData.post(window.url + 'api/updateDepartment/' + departmentData.id)
            .then((response) => {
            context.dispatch('getDepartments')  ,
           $('#exampleModal').modal('hide')
         })

        },

        deleteDepartment(context, departmentData) {
            if (confirm('Are you sure you wanna delete department')) {
                axios.post(window.url + 'api/deleteDepartment/' + departmentData.id)
                    .then(() => {
                        context.dispatch('getDepartments')
                    });
            }
        }
    },
}