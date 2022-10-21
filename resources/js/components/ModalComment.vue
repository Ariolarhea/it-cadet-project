<template>
    <div class="modal fade" id="modalComment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
            <button type="button" class="close" @click="close()" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
            
              <div>
                <textarea type="text" class="form-control acc_format" id="name" placeholder="Enter Comment"></textarea>
              </div>
              
            </form>
         
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="close()" data-dismiss="modal">Close</button>
            <button type="button" v-if="isForEdit === false" class="btn btn-outline-success" @click="store">Post</button> 
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
                    $('#modalComment')
                    .modal({
                        backdrop: 'static',
                        keyboard: false
                    });              
                }   else {
                    $('#modalComment')
                    .modal("hide");
                    }
            }
        },
    
        methods: {
    
            close() {
                this.$emit('close', false);
                $('#modalComment').modal("hide");
                this.downloading = false
            },

           
            store() {
    
                console.log('check if store is triggered')

                axios.post('api/reports',{
                    title: this.report.title,
                    detail: this.report.detail,
                    date_posted: this.report.date_posted,
                    posted_by: this.report.posted_by,
                    company: this.report.company,
                    department: this.report.department

    
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
    
            
        }       
    }
    </script>