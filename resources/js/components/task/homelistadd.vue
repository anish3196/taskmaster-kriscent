<template>
    <sidebar></sidebar>
    <div class="right_col" role="main">
        <div class="title-box">
            <h2>Task Add</h2>
            <div class="container-box-top-header-right">
                <router-link to="/homelist" class="list-banner-btn">List Task</router-link>
            </div>
        </div>
        <div class="container-box px-5">
            <div class="container-box-inner">
                <div class="page-details">
                <form enctype="multipart/form-data"  @submit.prevent="addSlider">
                    <div class="input-field">
                        <label>Tittle</label>
                        <input type="text"   v-model="data.title" class="form-control" required>
                    </div>
                    <div class="input-field">
                        <label>Description</label>
                        <textarea   v-model="data.desc"  class="form-control" required></textarea>
                    </div>
                    <div class="input-field">
                        <label>Link</label>
                            <input type="date" class="form-control"  v-model="data.due_date" required>
                    </div>
                    <div class="input-field">
                        <label>Link</label>
                            <select class="form-control" style="background-color: transparent;" v-model="data.status" required>
                                <option value="" selected disabled>Select status</option>
                                <option value="Pending">Pending</option>
                                <option value="Progress">Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                    </div>
                    <button class="submit-green-btn" >SUBMIT</button>
                </form>
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
               desc:'',
               status:'',
               due_date:'',
		   },
		   sliders : [],
		   editModal:false,
		   addModal: false,
           isAdding: false,
		   editData:{
            title:'',
               desc:'',
               due_date:'',
               status:'',
		   },

		   index: -1,
		   showDeleteModal: false,
		   isDeleting:false,
           deleItem: {},
		   deleteindex: -1,
           visible:false,

		}
	 },
     
     methods : {
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
        

        async addSlider(){
            var form = new FormData();
            form.append("title", this.data.title);
            form.append("desc", this.data.desc);
            form.append("status", this.data.status);
            form.append("due_date", this.data.due_date);
		    await axios.post('/api/add_task', form,{ headers: {"Authorization" : `Bearer ${localStorage.getItem('token')}`,'content-type': 'multipart/form-data'}}) .then(function (res) {
                if(res.status === 200){
				alert('Task Added successfully');
			}
                    })
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
                alert ("SomeThing went wrong");
                }
                    });
		},
    } 
}
</script>