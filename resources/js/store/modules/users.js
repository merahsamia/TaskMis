import axios from 'axios';

export default {
    state: {
        users : {},
       
    },


    getters: {
        users(state) {
            return state.users
        }
    },


    mutations: {
        set_users: (state, data) => {
            state.users = data
        }
        
    },


    actions:{
        storeUser: (context, userData) => {
            userData.post(window.url + 'api/storeUser')
            .then((response) => {
                context.dispatch('getUsers')  ,
                $('#exampleModal').modal('hide')
            })
        },

        getUsers: (context) => {
            axios.get(`${window.url}api/getUsers`).then((response) => {
                context.commit('set_users', response.data)
                console.log(response.data)
            })

        },

        
        updateUser(context, userData) {

            userData.post(window.url + 'api/updateUser/' + userData.id)
            .then((response) => {
            context.dispatch('getUsers')  ,
           $('#exampleModal').modal('hide')
         })

        },

        deleteUser(context, userData) {
            if (confirm('Are you sure you wanna delete the user')) {
                axios.post(window.url + 'api/deleteUser/' + userData.id)
                    .then(() => {
                        context.dispatch('getUsers')
                    });
            }
        }

     
    },
}