import axios from 'axios';

export default {
    state: {
        

    },


    getters: {
       
    },

    mutations: {
        
    },


    actions:{


       

        storeComment: (context, commentData) => {
            commentData.post(window.url + 'api/storeComment')
            .then((response) => {
              //  context.dispatch('getDepartments')  ,

              window.emitter.emit('resetCommentData')

                window.Toast.fire({
                    icon: "success",
                    title: "Comment created successfully!"
                  });
            })
        },

        

       
    },
}