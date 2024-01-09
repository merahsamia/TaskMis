import axios from 'axios';

export default {
    state: {
        filtered_departments : [], 
        filtered_roles : [], 
        filtered_permission_categories : [], 
        filtered_permissions : [], 
        all_permissions : [], 
        filtered_users : [], 
        
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
            window.auth_roles.map(role => {
                if(role.name ==='director'){

                    data.forEach(user => {
                        if(user.department_id === window.auth_user.department_id && user.id !== window.auth_user.id) {
                            state.filtered_users.push({
                                value: user.id,
                                label: user.name
                            });
                        }
                    });
                }
                if(role.name ==='manager'){

                    data.forEach(user => {

                        user.roles.map(role => {
                            if(user.department_id === window.auth_user.department_id && user.id !== window.auth_user.id && role.name !== 'director') {
                                state.filtered_users.push({
                                    value: user.id,
                                    label: user.name
                                });
                            }
                        })
                      
                    });
                    
                }

            })

            
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
    },
}