<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h5 class="float-start text-light">Departments List</h5>
                    <button class="btn btn-success float-end" v-on:click="createDepartment">
                        New Department</button>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Director</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(department, index) in departments" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ department.name }}</td>
                                    <td>{{ department.director_id }}</td>
                                    <td>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    v-model="departmentData.name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="director_id">Director</label>
                                                <select name="director_id" class="form-control"
                                                    v-model="departmentData.director_id">
                                                    <option value="">Select a person</option>
                                                    <option value="1">IT Director</option>
                                                    <option value="2">HR Director</option>
                                                </select>
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
            departmentData: {
                id: '',
                name: '',
                director_id: '',
            },
            departments: {},
            editMode: false,

        }
    },

    methods: {
        createDepartment() {
            this.editMode = false
            this.departmentData.name = this.departmentData.director_id = ''
            $('#exampleModal').modal('show')
        },

        storeDepartment() {
            axios.post(window.url + 'api/storeDepartment', this.departmentData)
                .then((response) => {
                    this.getDepartments()
                    $('#exampleModal').modal('hide')
                })
        },

        getDepartments() {
            axios.get(`${window.url}api/getDepartments`).then((response) => {
                console.log(response.data)
                this.departments = response.data

            })
        },

        editDepartment(department) {
            this.editMode = true
            this.departmentData.id = department.id
            this.departmentData.name = department.name
            this.departmentData.director_id = department.director_id
            $('#exampleModal').modal('show')
        },

        updateDepartment() {
            axios.post(window.url + 'api/updateDepartment/' + this.departmentData.id, this.departmentData)
                .then((response) => {
                    this.getDepartments()
                    $('#exampleModal').modal('hide')
                })
        },

        deleteDepartment(department) {
            if (confirm('Are you sure you wanna delete department')) {
                axios.post(window.url + 'api/deleteDepartment/' + department.id)
                    .then(() => {
                        this.getDepartments()
                       
                    })
            }
        }
    },

    mounted() {
        this.getDepartments()
    }

}
</script>