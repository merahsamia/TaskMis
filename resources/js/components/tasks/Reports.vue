<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h5 class="text-light">Reports</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Report Type</label>
                                <select class="form-control" v-model="reportData.type">
                                    <option value="#" disabled>Select a type</option>
                                    <option value="assigned" v-if="current_permissions.has('tasks-create')">Assigned Tasks</option>
                                    <option value="other_completed" v-if="current_permissions.has('tasks-create')">Completed Tasks</option>
                                    <option value="all_inbox" v-if="current_permissions.has('inbox-read') && !current_roles.has('admin')">Inbox Tasks</option>
                                    <option value="completed_inbox" v-if="current_permissions.has('inbox-update') && !current_roles.has('admin')">Completed Inbox Tasks</option>
                                </select>
                                <div class="text-danger" v-if="reportData.errors.has('type')" v-html="reportData.errors.get('type')" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" v-model="reportData.start_date">  
                                <div class="text-danger" v-if="reportData.errors.has('start_date')" v-html="reportData.errors.get('start_date')" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" v-model="reportData.end_date">
                                <div class="text-danger" v-if="reportData.errors.has('end_date')" v-html="reportData.errors.get('end_date')" />
                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-start mt-3" v-if="current_permissions.has('reports-create') 
                        && reportData.type != '#' && reportData.start_date != '' && reportData.end_date != ''">
                        <button type="button" class="btn btn-success" @click.prevent="exportExcel">
                            <i class="fa fa-file-excel-o"></i>
                        </button>
                        <button type="button" class="btn btn-danger mx-2" @click.prevent="exportPDF">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <table id="tasks" style="display: none">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Priority</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Assign To</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(task, index) in tasks" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ task.title }}</td>
                <td>
                    <span :class="`badge ${task.priority == 'Urgent' ? 'badge-danger' : 'badge-success'}`">
                        {{ task.priority }}
                    </span>
                </td>
                <td>{{ task.start_date }}</td>
                <td>{{ task.end_date }}</td>
                <td>{{ task.users.length }} Staff Members</td>
                <td>
                    <p v-if="task.progress == 0" class="text-danger">No Progress</p>
                    <p v-if="task.progress > 0 && task.progress < 100" class="text-warning">Under Progress</p>
                    <p v-if="task.progress == 100" class="text-success">Completed</p>
                </td>
            </tr>
        </tbody>

    </table>
</template>

<script>
    const xlsx = require('xlsx');
    import jsPDF from 'jspdf';
    import autoTable from 'jspdf-autotable';
    export default {

        data() {
            return {
                reportData: new Form({
                type:'#', 
                start_date: '',
                end_date: '',
                 }),

                 tasks: {},
            }
        },

        mounted() {
            this.$store.dispatch('getAuthRolesAndPermissions')

        },

        computed: {
            current_roles(){
                return this.$store.getters.current_roles
            },

            current_permissions(){
                return this.$store.getters.current_permissions
            },
        },

        methods: {
            exportExcel() {
                let data = []

                this.reportData.post(`${window.url}api/exportExcel`).then(response => {
                    //console.log(response.data)
                    response.data.forEach(task => {
                        let assigned_to = task.users.map(user=> {
                            return user.name;
                        });

                        // get Ready the Data 
                        let convertToStringUsers = JSON.stringify(assigned_to);
                        let removeFirstAndLastChar = convertToStringUsers.slice(1, -1);

                        let status;

                        if(task.progress == 0) {
                            status = 'No progress'
                        }
                        if(task.progress > 0 && task.progress < 100) {
                            status = 'Under progress'
                        }
                        if(task.progress == 100) {
                            status = 'Completed'
                        }

                        data.push({
                            title: task.title,
                            priority: task.priority,
                            start_date: task.start_date,
                            end_date: task.end_date,
                            assigned_to: removeFirstAndLastChar,
                            status: status,
                        });

                       

                    });

                     // Export Excel

                        const XLSX = xlsx;
                        const workbook = XLSX.utils.book_new();
                        const worksheet = XLSX.utils.json_to_sheet(data);

                        XLSX.utils.book_append_sheet(workbook, worksheet, "Tasks");

                        /* fix headers */
                        XLSX.utils.sheet_add_aoa(worksheet, [["Title", "Priority", "Start date", "End date", "Assigned To", "Status"]], { origin: "A1" }); 

                         /* calculate column width */
                        const title_width = data.reduce((w, r) => Math.max(w, r.title.length), 10);
                        const priority_width = data.reduce((w, r) => Math.max(w, r.priority.length), 10);
                        const start_date_width = data.reduce((w, r) => Math.max(w, r.start_date.length), 10);
                        const end_date_width = data.reduce((w, r) => Math.max(w, r.end_date.length), 10);
                        const assigned_to_width = data.reduce((w, r) => Math.max(w, r.assigned_to.length), 10);
                        worksheet["!cols"] = [
                            { wch: title_width }, 
                            { wch: priority_width },
                            { wch: start_date_width },
                            { wch: end_date_width },
                            { wch: assigned_to_width } ];

                     /* create an XLSX file and try to save to Presidents.xlsx */
                        XLSX.writeFile(workbook, "Tasks.xlsx", { compression: true });

                        window.TransformStream.fire({
                            icon: 'success',
                            title: 'Excel Exported Successfully'
                        })

                }).catch(err => {
                    console.log(err)
                });
            },


            exportPDF() {
                this.reportData.post(`${window.url}api/exportExcel`).then(response => {
                    this.tasks = response.data
                }).then(() => {

                    const doc = new jsPDF()
                    autoTable(doc, {html: '#tasks'})
                    doc.save('Tasks.pdf')
                });
            }
        }
    }
</script>