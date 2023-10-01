<template>
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
          <router-link to="/dashboard" class="site_title">Task Master</router-link>
        </div>

        <div class="clearfix"></div>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <ul class="nav side-menu">
              <li><router-link to="/dashboard"><i class="fa fa-home"></i> Dashboard</router-link></li>
              <li><router-link to="/homelist"><i class="fa fa-file-image-o"></i>Task Managment</router-link></li>
              <li><router-link to="/adminprofile"><i class="fa fa-user"></i>Profile</router-link></li>
            </ul>
          </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <!-- /menu footer buttons -->
      </div>
    </div>

    <!-- top navigation -->
    <div class="top_nav">
      <div class="nav_menu">
        <nav>
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            <router-link class="admin-profile" to="/adminprofile">
                Hello,<p>{{ adminuserprofile.name }}</p>
            </router-link>
          </div>

          <ul class="nav navbar-nav navbar-right">
            <li class="">
              <a @click="logout">
                Logout
                <img src="../../img/logout.svg" alt="">
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- /top navigation -->

    <!-- /page content -->
  <router-view></router-view>
</template>
<script>
    import { useRouter } from "vue-router"
    import { Store, useStore } from 'vuex'
    export default{
        setup(){
            const router = useRouter();
            const store = useStore();

            function logout(){
                store.dispatch('removeToken');
                router.push({name:'Login'})
            }

            return {
                logout
            }
        },
        data(){
		return{
		   adminuserprofile : {
            file:'',
            profile_img:''
           },

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
 			}else {
				console.log('something went wrong')

			}
		},


    },

    }
</script>