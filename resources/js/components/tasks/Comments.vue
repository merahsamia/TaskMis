<template>
     <!-- Modal -->
        <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel"
                        aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentsModalLabel">
                            Comments List For {{ taskInfo.title }}
                        </h5>

                      
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>

                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div v-for="(comment, index) in comments" :key="index">
                                    <div class="d-flex justify-content-between">
                                        <p><strong>{{ comment.user.name }}: </strong> {{ comment.comment}}</p>

                                        <div class="comment-icons">
                                            <i class="fa fa-edit text-success comment-icon" v-if="current_permissions.has('comments-update') && 
                                            current_user.id === comment.user_id" @click="editComment(comment)"></i>
                                            <i class="fa fa-trash text-danger comment-icon" v-if="current_permissions.has('comments-delete') && 
                                            current_user.id === comment.user_id" @click="deleteComment(comment)"></i>
                                        </div>

                                    </div>    
                                    <div class="comments-line"></div>
                                </div>

                                <p v-if="comments.length == 0">No Comments yet!</p>
                            </div>
                        </div>
                      

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea rows="3" class="form-control" v-model="commentData.comment"></textarea>
                                    <div class="text-danger" v-if="commentData.errors.has('comment')" v-html="commentData.errors.get('comment')" />

                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger"  @click="cancelCommentEdit" v-if="editMode">Cancel Edit</button>
                            <button type="button" class="btn btn-success" @click="!editMode ? storeComment() : updateComment()"> 
                                {{ !editMode ? 'Submit Comment' : 'Save Changes' }}
                            </button>

                            
                        </div>

                    </div>

                </div>
            </div>
        </div>

</template>

<script>
import Form from 'vform';

    export default{
        props: [
            'taskInfo',
            'comments',
        ],

        mounted() {

            this.$store.dispatch('getAuthRolesAndPermissions')

            this.current_user = window.auth_user

            window.emitter.on('resetCommentData', () => {
                this.editMode = false

                this.commentData.reset()
                this.commentData.clear()
            });
        }, 

        computed: {
            current_roles(){
            return this.$store.getters.current_roles
            },

            current_permissions(){
            return this.$store.getters.current_permissions
          },
        },
        
        data() {

            return {
                commentData: new Form({
                    id: '',
                    task_id: '',
                    comment: '',
                }),

                editMode: false,
                current_user: {},

            }
        },

        methods: {
            storeComment() {
                this.commentData.task_id = this.taskInfo.id
                this.$store.dispatch('storeComment', this.commentData)
            },

            cancelCommentEdit(){
                this.editMode = false
                this.commentData.reset()
                this.commentData.clear()
            },

            editComment(comment) {
                this.editMode = true
                this.commentData.id = comment.id
                this.commentData.task_id = comment.task_id
                this.commentData.comment = comment.comment
            },

            updateComment() {
                this.$store.dispatch('updateComment', this.commentData)
            }, 
            deleteComment(comment) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch('deleteComment', comment)
                    }
                    });

            }
        }
    }
</script>

<style scoped>
    .comments-line {
        width: 100%;
        margin-bottom: 10px;
        border: 1px solid lightgray;
        
    }

    .comment-icon {
        font-size: 15 px;
        margin: 0 5px;
        cursor: pointer;
    }
</style>