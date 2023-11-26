<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h5 class="float-start text-light">Users List</h5>
                    <button class="btn btn-success float-end" v-on:click="createUser" v-if="current_permissions.has('users-create')">
                        New User</button>

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
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th v-if="current_permissions.has('users-update') || current_permissions.has('users-delete')">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.department != null ? user.department.name: '...' }}</td>
                                    <td v-if="current_permissions.has('users-update') || current_permissions.has('users-delete')">
                                        <button class="btn btn-success mx-1" v-on:click="editUser(user)">
                                            <i class="fa fa-edit"></i></button>

                                        <button class="btn btn-danger mx-1" v-on:click="deleteUser(user)">
                                            <i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        {{ !editMode ? 'Create User' : 'Update User' }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                       <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" v-model="userData.name">
                                                <div class="text-danger" v-if="userData.errors.has('name')" v-html="userData.errors.get('name')"></div>
                                            </div>
                                       </div>
                                       <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" v-model="userData.email">
                                                <div class="text-danger" v-if="userData.errors.has('email')" v-html="userData.errors.get('email')"></div>
                                            </div>
                                       </div>
                                       <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" v-model="userData.password">
                                                <div class="text-danger" v-if="userData.errors.has('password')" v-html="userData.errors.get('password')"></div>
                                            </div>
                                       </div>
                                       <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="department_id">Department</label>
                                                <multi-select :options="filtered_departments" v-model="userData.department_id" :searchable="true"></multi-select>
                                                <div class="text-danger" v-if="userData.errors.has('department_id')" v-html="userData.errors.get('department_id')"></div>
                                            </div>
                                       </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="selected_roles">Roles</label>
                                                <multi-select :options="filtered_roles" v-model="userData.selected_roles" :searchable="true" mode="tags"></multi-select>
                                              
                                            </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="permission_categories">Permission Ctageories</label>
                                                <multi-select :options="filtered_permission_categories" 
                                                v-model="userData.selected_permission_categories" 
                                                :searchable="true" mode="tags" @input="getFilteredPermissions"></multi-select>
                                              
                                            </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="filtered_permissions">Permissions</label>
                                                <multi-select :options="filtered_permissions"
                                                 v-model="userData.selected_permissions" 
                                                 :searchable="true" mode="tags"></multi-select>     
                                            </div>
                                        </div>
                                      </div>
                                        
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" @click="!editMode ? storeUser() : updateUser()"
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
            userData: new Form( {
                id: '',
                department_id: '',
                name: '',
                email: '',
                password: '',
                selected_roles: [],
                selected_permission_categories: [],
                selected_permissions: [],
            }),
            editMode: false,

         

        }
    },

    methods: {

        getFilteredPermissions (values) {
            this.$store.dispatch('getFilteredPermissions', {values: values}).then(() =>{
                this.userData.selected_permissions = [];
                this.filtered_permissions.forEach(item => {
                    if(!item.label.includes('delete'))
                    {
                        this.userData.selected_permissions.push(item.value);
                    }
                });
            });
            
        }

        ,
        createUser() {
            this.editMode = false
            this.userData.clear()
            this.userData.reset()

            this.userData.name = ''
            $('#exampleModal').modal('show')
        },


        storeUser() {

           this.$store.dispatch('storeUser', this.userData)
        
        },

        
        // getDepartments() {
            
        // },

        editUser(user) {
            this.editMode = true
            this.userData.id=  user.id  
            this.userData.department_id=  user.department_id == 0 ? '' : user.department_id
            this.userData.name=  user.name  
            this.userData.email=  user.email  
            this.userData.selected_roles= []
            this.userData.selected_permission_categories = []
            this.userData.selected_permissions = []

            user.roles.forEach(role => {
                this.userData.selected_roles.push(role.id)
            })

            let permissionsArray = []
            user.permissions.forEach(permission => {
                let permissions =  permission.name.split('-');
                permissionsArray.push(permissions[0])
            } );

            let uniqueItems = [...new Set(permissionsArray)];
            this.userData.selected_permission_categories = uniqueItems;

            this.$store.dispatch('getFilteredPermissions', {values: uniqueItems}).then(()=> {
                user.permissions.forEach(permission => {
                    this.userData.selected_permissions.push(permission.id)
                })
            });

           $('#exampleModal').modal('show')
        },


        updateUser() {
         

            this.$store.dispatch('updateUser', this.userData)
       
        },


        deleteUser(user) {
           this.$store.dispatch('deleteUser', user)
        },


    },

    mounted() {
        this.$store.dispatch('getUsers')
        this.$store.dispatch('getAllDepartments')
        this.$store.dispatch('getAllRoles')
        this.$store.dispatch('getAllPermissions')
        this.$store.dispatch('getAuthRolesAndPermissions')
    },

    computed: {
    
        users(){
            return this.$store.getters.users
        },
        filtered_departments(){
            return this.$store.getters.filtered_departments
        },
        filtered_roles(){
            return this.$store.getters.filtered_roles
        },
        filtered_permission_categories(){
            return this.$store.getters.filtered_permission_categories
        },
        filtered_permissions(){
            return this.$store.getters.filtered_permissions
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