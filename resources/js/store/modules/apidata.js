import axios from 'axios';

export default {
    state: {
        filtered_departments : [], 
        filtered_roles : [], 
        filtered_permission_categories : [], 
        filtered_permissions : [], 
        all_permissions : [], 
        filtered_users : [], 
        unread_notifications: [],
        all_notifications: [],
        
    },


    getters: {

        filtered_departments(state) {
            return state.filtered_departments;
        },
       
        filtered_roles(state) {
            return state.filtered_roles;
        },

        filtered_permission_categories(state) {
            return state.filtered_permission_categories;
        },

        filtered_permissions(state) {
            return state.filtered_permissions;
        },

        filtered_users(state) {
            return state.filtered_users;
        },

        unread_notifications(state) {
            return state.unread_notifications;
        },

        all_notifications(state) {
            return state.all_notifications;
        },
        
    },


    mutations: {

        set_all_departments: (state, data) => {
            state.filtered_departments = []; 
             data.forEach(department => state.filtered_departments.push
            ({value: department.id, label: department.name}))    
        },

        
        set_all_roles: (state, data) => {
            state.filtered_roles = []; 
             data.forEach(role => state.filtered_roles.push
            ({value: role.id, label: role.name}))    
        },

        set_all_permissions: (state, data) => {
            state.all_permissions = data;
            state.filtered_permission_categories = []; 
            let itemsArray = [];
             data.forEach(item => {
                let items= item.name.split('-');
                itemsArray.push(items[0])
             });
           
             let uniqueItems = [...new Set(itemsArray)];
             state.filtered_permission_categories = uniqueItems
           
        },

        set_filtered_permissions: (state, data) => {
            state.filtered_permissions = [];
            data.values.forEach(value => {
                state.all_permissions.find(element => {
                    if(element.name.includes(value)) {
                        state.filtered_permissions.push({value: element.id, label: element.name});
                    }
                })
            })
        },

        set_all_users: (state, data) => {
            state.filtered_users = [];

            data.forEach(user => {
                if(
                    user.department_id === window.auth_user.department_id
                     && user.id !== window.auth_user.id
                     && user.user_level !== 0
                     && user.user_level > window.auth_user.user_level
                ) {
                    state.filtered_users.push({
                        value: user.id,
                        label: user.name
                    });
                }
            })
            // window.auth_roles.map(role => {
            //     if(role.name ==='director'){

            //         data.forEach(user => {
            //             if(user.department_id === window.auth_user.department_id && user.id !== window.auth_user.id) {
            //                 state.filtered_users.push({
            //                     value: user.id,
            //                     label: user.name
            //                 });
            //             }
            //         });
            //     }
            //     if(role.name ==='manager'){

            //         data.forEach(user => {

            //             user.roles.map(role => {
            //                 if(user.department_id === window.auth_user.department_id && user.id !== window.auth_user.id && role.name !== 'director') {
            //                     state.filtered_users.push({
            //                         value: user.id,
            //                         label: user.name
            //                     });
            //                 }
            //             })
                      
            //         });
                    
            //     }

            // })

            
        },

        set_unread_notifications: (state, data) => {
            state.unread_notifications = data; 
               
        },

        set_all_notifications: (state, data) => {
            state.all_notifications = data; 
               
        },


       
    },


    actions:{

        getAllDepartments: (context) => {
            axios.get(`${window.url}api/getAllDepartments`).then((response) => {
                context.commit('set_all_departments', response.data)
            })
        },

        getAllRoles: (context) => {
            axios.get(`${window.url}api/getAllRoles`).then((response) => {
                context.commit('set_all_roles', response.data)
            })
        },

        getAllPermissions: (context) => {
            axios.get(`${window.url}api/getAllPermissions`).then((response) => {
                context.commit('set_all_permissions', response.data)
            })
        },

        getFilteredPermissions: (context, data) => {
           context.commit('set_filtered_permissions', data)
        },

        getAllUsers: (context, data) => {
            axios.get(`${window.url}api/getAllUsers`).then((response) => {
                context.commit('set_all_users', response.data)
            })
        },

        getUnreadNotifications: (context) => {
            axios.get(`${window.url}api/getUnreadNotifications`).then((response) => {
                context.commit('set_unread_notifications', response.data)
            })
        },

    
        markNotificationAsRead: (context, unreadData) => {
            axios.get(`${window.url}api/markNotificationAsRead?unread=${unreadData.id}`).then((response) => {
                
                context.dispatch('getUnreadNotifications')

                window.Toast.fire({
                    icon: "success",
                    title: "Notification marked as read!"
                  });
            })
        },

        getAllNotifications: (context) => {
            axios.get(`${window.url}api/getAllNotifications`).then((response) => {
                context.commit('set_all_notifications', response.data)
            })
        },

        clearAllNotifications: (context) => {
            axios.get(`${window.url}api/clearAllNotifications`).then((response) => {
                
                context.dispatch('getAllNotifications')

                window.Toast.fire({
                    icon: "success",
                    title: "All notifications cleared successfully!"
                  });            })
        },

        storeContact: (context, contactData) => {
            window.emitter.emit('emailLoading', true)
            contactData.post(`${window.url}api/storeContact`).then((response) => {
            $('#contactModal').modal('hide')
            window.Toast.fire({
                icon: "success",
                title: "Email sent successfuly!"
              });

            }).catch(err => {
                window.Toast.fire({
                    icon: "warning",
                    title: "Email not sent, please try again!"
                  });
            }).finally(() => {
                window.emitter.emit('emailLoading', false)

            })
        },

        

        

      

    },
}