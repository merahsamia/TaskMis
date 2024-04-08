<template>
    <a class="text-secondary" href="#" @click.prevent="contactUs">Contact us</a>

      <!-- Modal -->
      <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel"
                        aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalLabel">
                            Contact us
                        </h5>

                      
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>

                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" v-model="contactData.name">
                                    <div class="text-danger" v-if="contactData.errors.has('name')" v-html="contactData.errors.get('name')" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" v-model="contactData.email">
                                    <div class="text-danger" v-if="contactData.errors.has('email')" v-html="contactData.errors.get('email')" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea rows="3"  class="form-control" v-model="contactData.message"></textarea>
                                    <div class="text-danger" v-if="contactData.errors.has('message')" v-html="contactData.errors.get('message')" />

                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                           <div>
                                <div class="spinner-border text-success" id="email-spinner" role="status" v-if="email_loading"></div>

                                <button type="button" class="btn btn-success" @click="storeContact" :disabled="email_loading"> 
                                    Submit
                                </button>
                           </div>

                            
                        </div>

                    </div>

                </div>
            </div>
        </div>

</template>

<script>
import Form from 'vform';

    export default {
        data() {
            return {
                
                contactData: new Form({
                    name: '',
                    email: '',
                    message: '',
                }),

                email_loading: false,
            }
        },
        mounted() {
            window.emitter.on('emailLoading', (status) => {
                this.email_loading = status
            });
        },
        methods: {
            contactUs() {
                this.contactData.reset()
                this.contactData.clear()
                $('#contactModal').modal('show')
            },

            storeContact() {
                this.$store.dispatch('storeContact', this.contactData)
            }
        },
         
        

    }
</script>

<style scoped>

    #email-spinner {
        margin-right: 10px;
        position: relative;
        top: 10px;
    }
</style>