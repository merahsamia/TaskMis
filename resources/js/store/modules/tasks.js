import axios from 'axios';

export default {
    state: {
        tasks: {},
        tasksLinks: [],
        inbox_tasks: {},
        inboxTaskLinks: [],
        completed_tasks: {},
        completedTaskLinks: [],
    },

    getters: {
        tasks(state) {
            return state.tasks
        },
        tasksLinks(state) {
            return state.tasksLinks
        },


        inbox_tasks(state) {
            return state.inbox_tasks
        },
        inboxTaskLinks(state) {
            return state.inboxTaskLinks
        },

        completed_tasks(state) {
            return state.completed_tasks
        },
        completedTaskLinks(state) {
            return state.completedTaskLinks
        },
    },


    mutations: {
        set_tasks: (state, data) => {
            state.tasks = data

            state.tasksLinks = [];

            for(let i=0; i < data.links.length; i++)
            {
                if(i === 1
                    || i === Number(data.links.length - 2)
                    || data.links[i].active 
                    || isNaN(data.links[i].label)
                    || Number(data.links[i].label) === Number(data.current_page + 1)
                    || Number(data.links[i].label) === Number(data.current_page - 1)
                    ){
                        state.tasksLinks.push(data.links[i]);
                    }
            }

   
    },
        set_inbox_tasks: (state, data) => {
            state.inbox_tasks = data
            //console.log(data)

            state.inboxTaskLinks = [];

            for(let i=0; i < data.links.length; i++)
            {
                if(i === 1
                    || i === Number(data.links.length - 2)
                    || data.links[i].active 
                    || isNaN(data.links[i].label)
                    || Number(data.links[i].label) === Number(data.current_page + 1)
                    || Number(data.links[i].label) === Number(data.current_page - 1)
                    ){
                        state.inboxTaskLinks.push(data.links[i]);
                    }
            }

   
    },

        set_completed_tasks: (state, data) => {
            state.completed_tasks = data
            //console.log(data)

            state.completedTaskLinks = [];

            for(let i=0; i < data.links.length; i++)
            {
                if(i === 1
                    || i === Number(data.links.length - 2)
                    || data.links[i].active 
                    || isNaN(data.links[i].label)
                    || Number(data.links[i].label) === Number(data.current_page + 1)
                    || Number(data.links[i].label) === Number(data.current_page - 1)
                    ){
                        state.completedTaskLinks.push(data.links[i]);
                    }
            }

   
    },
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

        getTasksResults: (context, link) => {
            axios.get(link.url).then((response) => {
                context.commit('set_tasks', response.data)
        })
        },
       
        storeTask: (context, taskData) => {
            taskData.post(window.url + 'api/storeTask')
            .then((response) => {

                if(window.location.href.indexOf("tasks/index") > -1) {
                    context.dispatch('getTasks')
                    
                } else {
                    context.dispatch('getInboxTasks')
                }

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
        
        updateTask(context, taskData) {
            
            taskData.post(window.url + 'api/updateTask/' + taskData.id)
            .then((response) => {
                context.dispatch('getTasks')  ,
                $('#exampleModal').modal('hide')
                window.Toast.fire({
                    icon: "success",
                    title: "Task updated successfully!"
                });
            })
            
        },
        
        deleteTask(context, taskData) {
            axios.post(window.url + 'api/deleteTask/' + taskData.id)
            .then(() => {
                context.dispatch('getTasks')
                window.Toast.fire({
                    icon: "success",
                    title: "Task deleted successfully!"
                });
            });
            
        },

        
        getInboxTasks: (context) => {
            axios.get(`${window.url}api/getInboxTasks`).then((response) => {
                context.commit('set_inbox_tasks', response.data)
            })
        
        },

        getInboxTasksResults: (context, link) => {
            axios.get(link.url).then((response) => {
                context.commit('set_inbox_tasks', response.data)
        })
        
        },

        getCompletedTasksResults: (context, link) => {
            axios.get(link.url).then((response) => {
                context.commit('set_completed_tasks', response.data)
        })
        
        },

        storePerformTask:(context, data) => {
            axios.post(window.url + 'api/storePerformTask', data.performTaskData, data.config)
            .then((response) => {
                if(window.location.href.indexOf("tasks/inbox") > -1) {
                    context.dispatch('getInboxTasks')
                }else {
                    context.dispatch('getCompletedTasks')
                }
                $('#exampleModal').modal('hide')
                $('#task_file').val('')

                window.Toast.fire({
                    icon: "success",
                    title: "Task performance stored successfully!"
                  });
            })
        },


        getCompletedTasks: (context) => {
            axios.get(`${window.url}api/getCompletedTasks`).then((response) => {
                context.commit('set_completed_tasks', response.data)
            })
        
        },

    },
}