<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h5 class="float-start text-light">Assigned Tasks List</h5>
                    <button class="btn btn-success float-end" v-on:click="createTask" v-if="current_permissions.has('tasks-create')">
                        New Task</button>

                </div>
                <div class="card-body">
                                        <!-- 

                    <button @click="testAction" class="btn btn-info"> test</button>
                    {{ test }}  -->

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search_type">Search Type</label>
                                <select name="search_type" class="form-control" v-model="searchData.search_type">
                                    <option value="name">Name</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search_value">Search Value</label>
                            <input type="text" class="form-control" name="search_value" v-model="searchData.search_value" @keyup="searchDepartment">
                            </div>
                        </div>                                      
                     </div>

                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th v-if="current_permissions.has('departments-update') || current_permissions.has('departments-delete')">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr v-for="(department, index) in departments.data" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ department.name }}</td>
                                    <td v-if="current_permissions.has('departments-update') || current_permissions.has('departments-delete')">
                                        <button class="btn btn-success mx-1" v-on:click="editDepartment(department)">
                                            <i class="fa fa-edit"></i></button>

                                        <button class="btn btn-danger mx-1" v-on:click="deleteDepartment(department)">
                                            <i class="fa fa-trash"></i></button>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>

                    <!-- <div class="d-flex justify-content-center" v-if="departmentLinks.length > 3">

                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li :class="`page-item ${link.active ? 'active': ''} ${ !link.url ? 'disabled': ''}`"
                                v-for="(link, index) in departmentLinks" :key="index"><a class="page-link" href="#" v-html="link.label"
                                @click.prevent="getResults(link)"></a></li>
                                
                            </ul>
                        </nav>
                    </div> -->


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ !editMode ? 'Create Department' : 'Update Department' }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" 
                                                    v-model="taskData.title">
                                                    <div class="text-danger" v-if="taskData.errors.has('title')" v-html="taskData.errors.get('title')" />

                                                </div>
                                            </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="priority">Priority</label>
                                                <select class="form-control" v-model="taskData.priority">
                                                    <option value="Urgent">Urgent</option>
                                                    <option value="Not Urgent">Not Urgent</option>
                                                </select>
                                                    <div class="text-danger" v-if="taskData.errors.has('priority')" v-html="taskData.errors.get('priority')" />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" class="form-control" 
                                                    v-model="taskData.start_date">
                                                    <div class="text-danger" v-if="taskData.errors.has('start_date')" v-html="taskData.errors.get('start_date')" />

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="date" class="form-control" 
                                                    v-model="taskData.end_date">
                                                    <div class="text-danger" v-if="taskData.errors.has('end_date')" v-html="taskData.errors.get('end_date')" />

                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">description</label>
                                                <textarea rows="13" class="form-control" v-model="tastData.description"></textarea>
                                                    <div class="text-danger" v-if="taskData.errors.has('description')" v-html="taskData.errors.get('description')" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" @click="!editMode ? storeDepartment() : updateDepartment()"
                                        class="btn btn-success">
                                        {{ !editMode ? 'Store' : 'Save Changes' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</template>

<script>
export default {

    data() {
        return {
            taskData: new Form( {
                id: '',
                title: '',
                priority: '',
                start_date: '',
                end_date: '',
                description: '',
                assign_to: [],
            }),
            editMode: false,

          
            searchData: {
                search_type:'name',
                search_value:'',
            },

        }
    },

    mounted(){
        this.$store.dispatch('getAuthRolesAndPermissions')

    },
    computed: {
        current_roles(){
            return this.$store.getters.current_roles
        },
        current_permissions(){
            return this.$store.getters.current_permissions
        }
    },

    methods: {
        createTask() {
            this.editMode = false
            this.taskData.reset()
            this.taskData.clear()
            $('#exampleModal').modal('show')
        },
    }

}
</script>