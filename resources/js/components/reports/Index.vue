<template>  
    <div>  
        <div class="pt-3 pb-2 mb-3">
            <h1 class="text-center">Reports</h1>
            <div class="text-center">
                <button type="button" @click="openModal()" class="btn btn-lg btn-outline-success">Create New Report</button>
            </div> 
        </div> 

        <table class="table">
            <thead>
                <tr>
                <th scope="col">Title</th>
                <th scope="col">Detail</th>
                <th scope="col">Date posted</th>
                <th scope="col">Posted by</th>
                <th scope="col">Attachments</th>

                </tr>
            </thead>
            <tbody>
                <tr v-if="loading === false && reports" v-for="(report,i) in reports.data" :key="i">
                    <td>{{ report.title }}</td>
                    <td>{{ report.detail }}</td>
                    <td>{{ report.date_posted }}</td>
                    <td>{{ report.posted_by }}</td>
                    <td>
                        <a  v-if="report.attachment" :href="'/storage/'+report.attachment.path">view</a>
                    </td>
                    
                    <td>
                        <button @click="modifyReport(report)" class="btn btn-outline-success">Edit</button>
                        <button @click="deleteReport(i,report.id)" class="btn btn-outline-danger">Delete</button>
                        <button @click="commentReport(i,report.id)" class="btn btn-outline-primary">Comment</button>
                    </td>
                </tr>

                <tr v-if="loading === true">
                    <td colspan="2">
                        <div class="spiner-example">
                            <p class="text-center">
                                Please wait...
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table> 

        <div class="row mb-3">
                <div class="col-6">
                    <button :disabled="reports.current_page == 1" @click="prevPage()" class="btn btn-success btn-sm btn-fill"> Previous </button>
                        <span class="text-dark">Page {{ reports.current_page  }} of {{ reports.last_page }}</span>
                    <!-- <button :disabled="!showNextLink()" class="btn btn-default btn-sm btn-fill"> Next </button> -->
                    <button  @click="nextPage()" :disabled="reports.current_page == reports.last_page" class="btn btn-success btn-sm btn-fill"> Next </button>
                </div>
                <div class="col-6 text-right">
                    <span>{{ reports.total }} Total</span>
                </div>
            </div>

            
            <modal-report 
                :report="report" 
                :isForEdit="isForEdit"
                @resetEdit="isForEdit = $event"
                @returnUpdate="updateReport($event)"
                @return="pushNewReport($event)"
                @close="show = $event"
                :show="show">
            </modal-report>


    </div>

</template>
<script>
    import ModalReport from '../../components/ModalReport.vue';
    export default {

        data() {
            return {
                show: false,
                loading: false,
                reports: [],
                search: "",
                current_page: 1,
                last_page_url: "",
                next_page_url: "",
                prev_page_url: "",
                isForEdit: false,
                report: {}
            }
        },

        components: {
            ModalReport,

        },
        
        mounted() {
            console.log('Component mounted.')
            this.fetchReports();
        },

        methods: {

            openModal() {
                this.show = !this.show;
            },
            
            pushNewReport(event) {
                this.reports.data.unshift(event);
            },

            fetchReports() {
                this.loading = true;
                axios.get(`/api/reports`)
                .then(response => {
                    console.log('response: ', response.data)
                    this.reports = response.data
                    this.loading = false;
                })
            },

            deleteReport(index, id) {
                axios.delete(`/api/reports/${id}`)
                .then(response => {
                    if(response.status === 200 || response.status === 201) {
                        this.reports.data.splice(index,1);
                    }
                })
            }, 

            modifyReport(report) {
                this.show =!this.show;
                this.report =report;
                this.isForEdit = true;
            },

            commentReport(report) {
                this.show =!this.show;
                this.report =report;
                this.isForEdit = true;
            },


            updateReport(event) {

                let findReport = this.reports.data.findIndex(x => x.id === event.id);
                this.reports.data[findReport] = event;
                
            },

            prevPage() {
                
                this.loading = true
                axios.get(`${this.reports.prev_page_url}`)
                .then(response => {
                    this.reports = response.data;
                    this.loading = false;
                });
            },

            nextPage() {
                this.loading = true
                axios.get(`${this.reports.next_page_url}`)
                .then(response => {
                console.log('check response ter: ', response)
                this.reports = response.data
                this.loading = false;
                });
            },
        } 
        
    }
</script>