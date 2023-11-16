<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h5 class="float-start text-light">Departments List</h5>
                    <button class="btn btn-success float-end" v-on:click="createDepartment" v-if="current_permissions.has('departments-create')">
                        New Department</button>

                </div>
                <div class="card-body">
                                        <!-- 

                    <button @click="testAction" class="btn btn-info"> test</button>
                    {{ test }}  -->
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
                                <tr v-for="(department, index) in departments" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ department.name }}</td>
                                    <td v-if="current_permissions.has('departments-update') || current_permissions.has('departments-delete')">
                                        <button class="btn btn-success mx-1" v-on:click="editDepartment(department)">
                                            <i class="fa fa-edit"></i></button>

                                        <button class="btn btn-danger mx-1" v-on:click="deleteDepartment(department)">
                                            <i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    v-model="departmentData.name">
                                                    <!-- <p class="text-danger" v-if="departmentErrors.name">Name is required</p> -->
                                                    <div class="text-danger" v-if="departmentData.errors.has('name')" v-html="departmentData.errors.get('name')" />

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

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Create New Department
</button> -->
</template>

<script>
export default {
    data() {
        return {
            departmentData: new Form( {
                id: '',
                name: '',
            }),
            editMode: false,

            departmentErrors: {
                name: false,
            },

        }
    },

    methods: {
        createDepartment() {
            this.editMode = false
            this.departmentData.name = ''
            $('#exampleModal').modal('show')
        },


        storeDepartment() {
            // this.departmentData.name == '' ? this.departmentErrors.name = true
            // : this.departmentErrors.name = false
            // this.departmentData.director_id == '' ? this.departmentErrors.director_id = true
            // : this.departmentErrors.director_id = false
            //if (this.departmentData.name && this.departmentData.director_id) {

           this.$store.dispatch('storeDepartment', this.departmentData)
        //}
        },

        
        // getDepartments() {
            
        // },

        editDepartment(department) {
            this.editMode = true
            this.departmentData.id = department.id
            this.departmentData.name = department.name
            $('#exampleModal').modal('show')
        },


        updateDepartment() {
            // this.departmentData.name == '' ? this.departmentErrors.name = true
            // : this.departmentErrors.name = false
            // this.departmentData.director_id == '' ? this.departmentErrors.director_id = true
            // : this.departmentErrors.director_id = false
            //if (this.departmentData.name && this.departmentData.director_id){

            this.$store.dispatch('updateDepartment', this.departmentData)
        //}
        },


        deleteDepartment(department) {
           this.$store.dispatch('deleteDepartment', department)
        },


        // testAction(){
        //     this.$store.dispatch('testAction')

        // },
    },

    mounted() {
        this.$store.dispatch('getDepartments')
        this.$store.dispatch('getAuthRolesAndPermissions')
    },

    computed: {
        // test() {
        //     return this.$store.getters.test
        // },

        departments(){
            return this.$store.getters.departments
        },
        current_roles(){
            return this.$store.getters.current_roles
        },
        current_permissions(){
            return this.$store.getters.current_permissions
        }
    }

}
</script>