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
                                <tr v-for="(department, index) in departments.data" :key="index">
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

                    <div class="d-flex justify-content-center" v-if="departmentLinks.length > 3">

                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li :class="`page-item ${link.active ? 'active': ''} ${ !link.url ? 'disabled': ''}`"
                                v-for="(link, index) in departmentLinks" :key="index"><a class="page-link" href="#" v-html="link.label"
                                @click.prevent="getResults(link)"></a></li>
                                
                            </ul>
                        </nav>
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
            searchData: {
                search_type:'name',
                search_value:'',
            },

        }
    },

    methods: {

        searchDepartment() {
            this.$store.dispatch('searchDepartment', this.searchData)

        },

        getResults(link) {
            if(!link.url || link.active){
                return;
            } else{
                this.$store.dispatch('getDepartmentsResults', link)
            }

        },
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
                        this.$store.dispatch('deleteDepartment', department)
                    }
                    });
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

        departmentLinks(){
            return this.$store.getters.departmentLinks
        },
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