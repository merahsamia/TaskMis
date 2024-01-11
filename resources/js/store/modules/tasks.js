import axios from 'axios';

export default {
    state: {
        // //departments_test: 0,
        // departments: {},
        // departmentLinks : {},

    },


    getters: {
        tasks(state) {
            return state.tasks
        },
      
    },


    mutations: {
        set_tasks: (state, data) => {
            state.tasks = data

   
    },


    actions:{


        // searchDepartment:(context, searchData) => {
        //     setTimeout(function(){
        //         axios.get(`${window.url}api/searchDepartment?${searchData.search_type}=${searchData.search_value}`).then((response) => {
        //             context.commit('set_departments', response.data)
        //         }).catch(err => {
        //             console.log(err);
        //         })
        //     })
        // },

        // getDepartmentsResults: (context, data) => {
        //     axios.get(`${data.link.url}&${data.searchData.search_type}=${data.searchData.search_value}`).then((response) => {
        //         context.commit('set_departments', response.data)
        //         console.log(response.data)                
        // })
        // },

        storeTask: (context, taskData) => {
            taskData.post(window.url + 'api/storeTask')
            .then((response) => {
                $('#exampleModal').modal('hide')

                window.Toast.fire({
                    icon: "success",
                    title: "Task created successfully!"
                  });
            })
        },

        getTasks: (context) => {
            axios.get(`${window.url}api/getTasks`).then((response) => {
                context.commit('set_tasks', response.data)
            })

        },

        // updateDepartment(context, departmentData) {

        //     departmentData.post(window.url + 'api/updateDepartment/' + departmentData.id)
        //     .then((response) => {
        //     context.dispatch('getDepartments')  ,
        //    $('#exampleModal').modal('hide')
        //    window.Toast.fire({
        //     icon: "success",
        //     title: "Department updated successfully!"
        //   });
        //  })

        // },

        // deleteDepartment(context, departmentData) {
        //         axios.post(window.url + 'api/deleteDepartment/' + departmentData.id)
        //             .then(() => {
        //                 context.dispatch('getDepartments')
        //                 window.Toast.fire({
        //                     icon: "success",
        //                     title: "Department deleted successfully!"
        //                   });
        //             });
            
        // }
    },
}