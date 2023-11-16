<template>
    <div class="row">
        <div class="col-md-12">
            <div class="form-check-inline">
                <input type="radio" class="form-check-input" id="inlineradio1" name="permission_type" v-model="permissionData.permission_type" value="basic">
                <label for="inlineradio1" class="form-check-label">Basic</label>
            </div>
            <div class="form-check-inline">
                <input type="radio" class="form-check-input" id="inlineradio2" name="permission_type" v-model="permissionData.permission_type" value="crud">
                <label for="inlineradio2" class="form-check-label">CRUD</label>
            </div>
        </div>
    </div>

    <div class="row" v-if="permissionData.permission_type== 'basic'">
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="display_name">Display Name</label>
                <input type="text" class="form-control" name="display_name">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" name="description">
            </div>
        </div>
    </div>

    <div class="row" v-if="permissionData.permission_type== 'crud'">
        <div class="col-md-4">
            <div class="form-group">
                <label for="resource">Resource</label>
                <input type="text" class="form-control" name="resource" v-model="permissionData.resource">
            </div>
        </div>
        <div class="col-md-8 mt-4 pt-3">
            <div class="form-check-inline">
                <input type="checkbox" class="form-check-input" id="inlinecheckbox1" name="crudSelected[]" v-model="permissionData.crudSelected" value="create">
                <label for="inlinecheckbox1" class="form-check-label">Create</label>
            </div>
            <div class="form-check-inline">
                <input type="checkbox" class="form-check-input" id="inlinecheckbox2" name="crudSelected[]" v-model="permissionData.crudSelected" value="read">
                <label for="inlinecheckbox2" class="form-check-label">Read</label>
            </div>
            <div class="form-check-inline">
                <input type="checkbox" class="form-check-input" id="inlinecheckbox3" name="crudSelected[]" v-model="permissionData.crudSelected" value="update">
                <label for="inlinecheckbox3" class="form-check-label">Update</label>
            </div>
            <div class="form-check-inline">
                <input type="checkbox" class="form-check-input" id="inlinecheckbox4" name="crudSelected[]" v-model="permissionData.crudSelected" value="delete">
                <label for="inlinecheckbox4" class="form-check-label">Delete</label>
            </div>
        </div>  
        
    </div>

    <div class="row" v-if="permissionData.resource.length >= 3 && permissionData.crudSelected.length > 0 && permissionData.permission_type == 'crud'">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Display name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in permissionData.crudSelected" :key="index">
                <td v-text="crudName(item)"></td>
                <td v-text="crudDisplayName(item)"></td>
                <td v-text="crudDisplayName(item)"></td>
            </tr>
        </tbody>
    </table>
    </div>
</template>

<script>
    export default{
data(){
    return {
        permissionData: {
            permission_type: 'basic',
            crudSelected:['create','read', 'update', 'delete'],
            resource: '',
        }
    }
},
methods: {
    crudName(item) {
        return this.permissionData.resource.toLowerCase() + '-' + item.toLowerCase();

    },
    crudDisplayName(item){
        return this.permissionData.resource.substr(0,1).toUpperCase() + this.permissionData.
        resource.substr(1) + ' ' + item.substr(0, 1).toUpperCase() + item.substr(1);

    }
}
    }
</script>