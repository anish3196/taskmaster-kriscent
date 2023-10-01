<template>
    <sidebar></sidebar>
        <div class="right_col" role="main">
        <div class="title-box">
            <h2>Profile</h2>
        </div>
        <div class="container-box p-0 profile-container py-0">
            <div class="profile-header">
            </div>
            <div class="container-box-inner p-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="page-details profile-details">
                            <h4>User details</h4>
                                <input type="file" id="selectedFile" ref="myFiles" @change="onChange" style="display: none;" />
                                <div class="input-field">
                                    <label>Name</label>
                                    <input type="text" v-model="adminuserprofile.name" class="form-control" readonly>
                                </div>
                                <div class="input-field">
                                    <label>Email</label>
                                    <input type="email" v-model="adminuserprofile.email" class="form-control" readonly>
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
     import { Store, useStore } from 'vuex'
    export default{
    components:{
        sidebar,
        },

        data(){
		return{
           data:{
               title:'',
		   },
		   adminuserprofile : {
            file:'',
            profile_img:''
           },
           profilepassword : {
              id:'',
              password:'',
              newpassword:'',
              conformpassword:''
           },
		   editModal:false,
		   addModal: false,
           isAdding: false,

		   index: -1,
		   showDeleteModal: false,
		   isDeleting:false,
           deleItem: {},
		   deleteindex: -1,
           visible:false,

		}
	 },
     mounted(){
		this.getAdminUserProfile();
        
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


        async getAdminUserProfile() {
			const res = await this.callApi('get','/api/admin_profile', { headers: {"Authorization" : `Bearer ${localStorage.getItem('token')}`} })
			if(res.status === 200){
                   this.adminuserprofile = res.data.data;
                   this.profilepassword.id = res.data.data.id;
 			}else {
				console.log('something went wrong')

			}
		},


    }   
    }
</script>