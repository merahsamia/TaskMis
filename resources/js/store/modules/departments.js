import axios from 'axios';

export default {
    state: {
        //departments_test: 0,
        departments: {},
        departmentLinks : {},

    },


    getters: {
        departments(state) {
            return state.departments
        },
        departmentLinks(state) {
            return state.departmentLinks
        },
    },


    mutations: {
        set_departments: (state, data) => {
            state.departments = data

            state.departmentLinks = []

            for(let i=0; i < data.links.length; i++)
            {
                if(i === 1
                    || i === Number(data.links.length - 2)
                    || data.links[i].active 
                    || isNaN(data.links[i].label)
                    || Number(data.links[i].label) === Number(data.current_page + 1)
                    || Number(data.links[i].label) === Number(data.current_page - 1)){
                        state.departmentLinks.push(data.links[i])
                    }
            }
        }
    },


    actions:{

        getDepartmentsResults: (context, link) => {
            axios.get(link.url).then((response) => {
                context.commit('set_departments', response.data)
                
        })
        },

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