<template>
    <div class="modal fade" id="modalReport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create New Report</h5>
            <button type="button" class="close" @click="close()" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
            
              <div class="form-group" :class="{ ' has-danger' : errors.title}">
                <label class="col-form-label">Title:</label>
                <input type="text" :class="{ 'is-invalid' : errors.title }" class="form-control acc_format" id="name"  v-model="report.title" placeholder="Enter Title">
                <div v-if="errors.title" class="invalid-feedback">{{ errors.title[0] }}</div>
              </div>
              
              <div class="form-group" :class="{ ' has-danger' : errors.detail }">
                <label class="col-form-label">Detail:</label>
                <textarea type="text" :class="{ 'is-invalid' : errors.detail }" class="form-control acc_format" id="name"  v-model="report.detail" placeholder="Enter Detail"></textarea>
                <div v-if="errors.detail" class="invalid-feedback">{{ errors.detail[0] }}</div>
              </div>

              <div class="form-group" :class="{ ' has-danger' : errors.date_posted }">
                <label class="col-form-label">Date posted:</label>
                <input type="text" :class="{ 'is-invalid' : errors.date_posted }" class="form-control acc_format" id="name"  v-model="report.date_posted" placeholder="Enter Date">
                <div v-if="errors.date_posted" class="invalid-feedback">{{ errors.date_posted[0] }}</div>
              </div>

              <div class="form-group" :class="{ ' has-danger' : errors.posted_by}">
                <label class="col-form-label">Posted by:</label>
                <input type="text" :class="{ 'is-invalid' : errors.posted_by }" class="form-control acc_format" id="name"  v-model="report.posted_by" placeholder="Enter Name">
                <div v-if="errors.posted_by" class="invalid-feedback">{{ errors.posted_by[0] }}</div>
              </div>

              <div>
                <label>Company Name:</label>
                  <select name="company" id="company">
                    <option></option>
                    <option value="accounting">La Filipina Uy Gongco Corporation</option>
                    <option value="administration">Philippine Foremost Milling Corporation</option>
                    <option value="logistics">Amigo Logistics Corporation</option>
                  </select>
              </div>

              <div>
                <label>Department Name:</label>
                  <select name="department" id="department">
                    <option></option>
                    <option value="accounting">Accounting</option>
                    <option value="administration">Administration</option>
                    <option value="logistics">Information Technology</option>
                  </select>
              </div>

              <div class="form-group">
                <label>Attachment</label>
              </div>
              <div class="custom-file">
                <input type="file" ref="attachment" @change="handleFileAttachment()" accept="image/*,application/pdf" :class="{ 'is-invalid' : errors.attachment }">
                <div v-if="errors.attachment" class="invalid-feedback">{{ errors.attachment[0] }}</div>
              </div>
    
            </form>
         
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="close()" data-dismiss="modal">Close</button>
            <button type="button" v-if="isForEdit === false" class="btn btn-outline-success" @click="store">Post</button> 
            <button type="button" v-if="isForEdit === true" class="btn btn-outline-success" @click="update(report.id)">Update</button>
          </div>
        </div>
      </div>
    </div> 
        
    </template>
    
    <script>
    
    export default {
    
        props: {
            show: {
                type: Boolean,
                default: false
            },
    
            report: {
              type: Object,
              default: {}
            },
    
            isForEdit: {
              type: Boolean,
              default: false
            },
        },
    
        data() {
            return {
                errors: [],
                
            }
        },
        
        watch: {
            show() {
                if(this.show === true) {
                    $('#modalReport')
                    .modal({
                        backdrop: 'static',
                        keyboard: false
                    });              
                }   
                else {
                    $('#modalReport')
                    .modal("hide");
                    }
            }
        },
    
        methods: {
    
            close() {
                this.$emit('close', false);
                $('#modalReport').modal("hide");
                this.downloading = false
            },

           
            store() {
    
                console.log('check if store is triggered')

                  // form data
                let formData = new FormData();
                let attachment = this.$refs['attachment']['files'][0];
                formData.append('attachment', attachment);
                if (this.report.title) formData.append('title', this.report.title);
                if (this.report.detail) formData.append('detail', this.report.detail);
                if (this.report.date_posted) formData.append('date_posted', this.report.date_posted);
                if (this.report.posted_by) formData.append('posted_by', this.report.posted_by);

                axios.post(`api/reports`,
                formData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
                })
    
                axios.post('api/reports',{
                    title: this.report.title,
                    detail: this.report.detail,
                    date_posted: this.report.date_posted,
                    posted_by: this.report.posted_by,

    
                })
               .then(response => {
                    if(response.status === 200 || response.status === 201) {
                        this.close();
                        this.$emit('return', response.data)
                    }
                  })
                .catch(error => {
    
                    if(error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                })
                
            },
    
            update(id) {
              axios.patch(`api/reports/${id}`,{
                    title: this.report.title,
                    detail: this.report.detail,
                    date_posted: this.report.date_posted,
                    posted_by: this.report.posted_by
                  })
                  .then(response => {
                    if(response.status === 200 || response.status === 201) {
                        this.close();
                        this.$emit('returnUpdate', response.data)
                        this.$emit('resetEdit', false)
                    }
                  })
                  .catch(error => {
                      // this.$toastr('warning', `Error found`)
                      if(error.response.status === 422) {
                        this.errors = error.response.data.errors;
                      }
                  })  
            },
                  handleFileAttachment(){
                  this.attachment = this.$refs['attachment']['files'][0];
                  },
        }       
    }
    </script>