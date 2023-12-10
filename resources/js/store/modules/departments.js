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


        searchDepartment:(context, searchData) => {
            setTimeout(function(){
                axios.get(`${window.url}api/searchDepartment?${searchData.search_type}=${searchData.search_value}`).then((response) => {
                    context.commit('set_departments', response.data)
                }).catch(err => {
                    console.log(err);
                })
            })
        },

        getDepartmentsResults: (context, data) => {
            axios.get(`${data.link.url}&${data.searchData.search_type}=${data.searchData.search_value}`).then((response) => {
                context.commit('set_departments', response.data)
                console.log(response.data)                
        })
        },

        storeDepartment: (context, departmentData) => {
            departmentData.post(window.url + 'api/storeDepartment')
            .then((response) => {
                context.dispatch('getDepartments')  ,
                $('#exampleModal').modal('hide')

                window.Toast.fire({
                    icon: "success",
                    title: "Department created successfully!"
                  });
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
           window.Toast.fire({
            icon: "success",
            title: "Department updated successfully!"
          });
         })

        },

        deleteDepartment(context, departmentData) {
                axios.post(window.url + 'api/deleteDepartment/' + departmentData.id)
                    .then(() => {
                        context.dispatch('getDepartments')
                        window.Toast.fire({
                            icon: "success",
                            title: "Department deleted successfully!"
                          });
                    });
            
        }
    },
}