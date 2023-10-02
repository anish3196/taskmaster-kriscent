<template>
    <sidebar></sidebar>
        <div class="right_col" role="main">
        <div class="title-box">
            <h2>Task List <span class="badge bg-orange">{{ tasks.length }}</span></h2>
            <div class="container-box-top-header-right">
                <select @change="changeStatus($event)">
                <option selected disabled>Filter on Basics of status</option>
                <option value="all">All</option>
                <option value="Pending">Pending</option>
                <option value="Progress">Progress</option>
                <option value="Completed">Completed</option>
                </select>
            </div>
        </div>
        <div class="sub-title-box">
            <div class="sub-title-box-right">
                <router-link class="list-banner-btn" to="/homelistadd">Add Task</router-link>
            </div>
        </div>
        <div class="container-box px-0">
            <div class="container-box-top-header px-4">
                <div class="container-box-top-header-left-2">
                    <input type="search" v-model="tasktitle" placeholder="Search By Title"  @keyup="filteredList()">
                </div>
                <div class="container-box-top-header-right d-flex">
                    <div>
                        <label><b>Search by due date - </b></label>
                        <input type="date" v-model="datesearch" @change="filteredListDate()">
                    </div>
                </div>
            </div>
            <div class="container-box-inner">
                <table class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tittle</th>
                            <th>Due date</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(task,i) in tasks" :key="i" v-if="tasks.length">
                            <td>{{ i+1 }}</td>
                            <td>{{ task.title }}</td>
                            <td>{{ stringSeprate(task.due_date) }}</td>
                            <td>
                              {{ task.status }}
                            </td>
                            <td>
                                <!-- <button class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteslider" @click="assigndelete(slider,i)"><img src="../../../img//dustbin.svg">
                            </button> -->
                            <div class="action_toggle_outer">
                                    <button class="action_toggle"><i class="fa fa-ellipsis-v"></i></button>
                                    <div class="action_toggle_content product-edit">
                                        <ul class="list-unstyled">
                                            <li><a href="javascript:void" class="close_toggle"><i class="fa fa-close"></i></a></li>
                                            <li><a class="edit" @click="showEditModal(task,i)" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a></li>
                                            <li><a href="javascript:void" class="reject"  data-bs-toggle="modal" data-bs-target="#deleteslider"  @click="assigndelete(task,i)">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade reactive-modal" id="deleteslider" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-5">
              <h4>Are you sure?</h4>
              <p>You want to Delete?</p>
              <div class="btn-grp">
                  <button class="cancle" data-bs-dismiss="modal"><span><i class="fa fa-close"></i></span></button>
                  <button class="done" @click="deleteSlider(this.sliderdeleteone,this.deleteindex)"><span><i class="fa fa-check"></i></span></button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade edit-box" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body px-5 pb-0">
                <div class="container-box px-5">
            <div class="container-box-inner">
                <div class="page-details">
                <form  @submit.prevent="editSubcategory">
                    <div class="input-field">
                        <label>Title*</label>
                        <input type="text" v-model="editData.title" class="form-control" required>
                    </div>
                    <div class="input-field">
                        <label>Description*</label>
                        <textarea v-model="editData.desc" class="form-control" required></textarea>                
                    </div>
                    <div class="input-field">
                        <label>status*</label>
                        <select class="form-control" v-model="editData.status"  style="background-color: transparent;" required>
                            <option value="">Select status</option>
                            <option value="Pending" :selected="editData.status == 'Pending'">Pending</option>
                            <option value="Progress" :selected="editData.status == 'Progress'">Progress</option>
                            <option value="Completed" :selected="editData.status == 'Completed'">Completed</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>Due Date<span class="red">*</span></label>
                        <input type="date"  class="form-control" v-model="editData.due_date">
                    </div>
                    <button class="submit-green-btn">SUBMIT</button>
                </form>
            </div>
            </div>
        </div>
          </div>
        </div>
      </div>
</div>
</template>

<script>
     import sidebar from '../../layouts/sidebar.vue'
    export default{
    components:{
        sidebar,
        },
    	data(){
		return{
           data:{
               title:'',
		   },
		   tasks : [],
           taskback:[],
           tasktitle:'',
           datesearch:'',
		   editModal:false,
		   addModal: false,
           isAdding: false,
           sliderdeleteone: {},
		   editData:{
			 
		   },

		   index: -1,
		   showDeleteModal: false,
		   isDeleting:false,
           deleItem: {},
		   deleteindex: -1,
           visible:false,

		}
	 },
     mounted(){
		this.getSliders();
	 },
     methods : {


        changeStatus(event){
        if(event.target.value != "all"){
        Object.assign(this.tasks,this.taskback)    
        var result = this.tasks.filter((x) => { return x.status == event.target.value; });
        this.tasks = [];
        Object.assign(this.tasks,result)
        }else if(event.target.value == "all"){
        Object.assign(this.tasks,this.taskback)     
        }  
        },
        
        async callApi(method,url,dataObj){
                try {
                   return await axios({
                      method:method,
                      url: url,
                      data:dataObj,
                    });
                } catch (error) {
                   return error.res
                }
        },

        assigndelete(slider,i){
             this.deleteindex = i;
             Object.assign(this.sliderdeleteone,slider)
        },

		async deleteSlider(slider,i){
			this.isDeleting = true
		   const res =   await axios.delete(`/api/delete_task?id=${slider.id}`,{ headers: {"Authorization" : `Bearer ${localStorage.getItem('token')}`} })
		   if(res.status === 200){
			this.tasks.splice(i,1)
            $(".cancle").click(); 
		   }else{
            alert('Unable to delete')
		   }
		   this.isDeleting = false
		   this.showDeleteModal = false
		},

        showEditModal(slider,index){
				Object.assign(this.editData,slider)
				this.editModal=true
				this.index = index
		},

        stringSeprate(string) {
            let ani = string.split('T') 
            var p = ani[0].split(/\D/g)
            return [p[2],p[1],p[0] ].join("-")
        },

        stringSeprateDate(string) {
          var p = string.split(/\D/g)
            return [p[0],p[1],p[2] ].join("-")
        },

        filteredList() {  
        if(this.tasktitle != '') {
        var usersearch = this.tasks.filter((x) =>{
        return x.title.toLowerCase().includes(this.tasktitle.toLowerCase())
        });
        this.tasks = [];
        Object.assign(this.tasks,usersearch)
        }else {
        Object.assign(this.tasks,this.taskback)   
        }     
        },

        filteredListDate() {  
        if(this.datesearch != '') {
        var usersearch = this.tasks.filter((x) =>{
        return this.stringSeprateDate(x.due_date) == this.datesearch;
        });
        this.tasks = [];
        Object.assign(this.tasks,usersearch)
        }else {
        Object.assign(this.tasks,this.taskback)   
        }     
        },

        async editSubcategory(){
            var form = new FormData();
            form.append("id", this.editData.id);
            form.append("title", this.editData.title);
            form.append("desc", this.editData.desc);
            form.append("status", this.editData.status);
            form.append("due_date", this.editData.due_date);
		    await axios.post('/api/edit_task', form,{ headers: {"Authorization" : `Bearer ${localStorage.getItem('token')}`,'content-type': 'multipart/form-data'}}) .then(function (res) {
                if(res.status === 200){
				alert('Task updated successfully');
			}
             }
             )
            .catch(function (err) {
            if(err.response.status === 400){
            alert("Please Fill all  Fields");
            }else if(err.response.status === 401){
            alert ("you are unauthorized");
            }
            else if(err.response.status === 403){
            alert ("Task alredy exist");
            }
            else if(err.response.status === 500){
            alert ("Something went wrong");
            }
            });
		},

	   	async getSliders() {
			const res = await this.callApi('get','/api/all_task', { headers: {"Authorization" : `Bearer ${localStorage.getItem('token')}`} })
			if(res.status === 200){
                   this.tasks = res.data.data;
                   this.taskback = res.data.data;
			}else {
				console.log('something went wrong')

			}
		},
    }    
}
</script>
