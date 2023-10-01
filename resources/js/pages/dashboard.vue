<template>
    <!-- page content -->
    <sidebar></sidebar>
    <div class="right_col" role="main">
        <div class="top-sec-heading">
            <h3>Welcome,</h3>
            <p>Hello, Check Your Tasks.</p>
        </div>
        <div class="container-box">
            <div class="container-box-top-header">
                <div class="container-box-top-header-left">
                    <span><img src="../../img/chart.svg" alt=""></span>
                    <p>Statistics</p>
                </div>
            </div>
            <div class="container-box-inner">
                <div class="row">
                    <div class="col-md-3">
                        <div class="g-box g-box1">
                            <router-link to="/homelist">
                                <p>Total task </p>
                               
                                <div class="g-box-inner">
                                    <h4>{{ tasks.length }}</h4>
                                </div>
                              
                            </router-link>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="g-box g-box2">
                            <router-link to="/homelist">
                                <p>Pending Task </p>
                               
                                <div class="g-box-inner">
                                    <h4>{{ getPendingCount(tasks) }}</h4>
                                </div>
                               
                            </router-link>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="g-box g-box3">
                            <router-link to="/homelist">
                                <p>Completed Task</p>
                               
                                <div class="g-box-inner">
                                    <h4>{{ getCompletedCount(tasks) }}</h4>
                                </div>
                               
                            </router-link>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="g-box g-box3">
                            <router-link to="/homelist">
                                <p>In progress Task </p>
                               
                                <div class="g-box-inner">
                                    <h4>{{ getProgressCount(tasks) }}</h4>
                                </div>
                               
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <router-view></router-view>
</template>
<script>
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'
    import sidebar from '../layouts/sidebar.vue'
    import store from "../store";
    export default{
          components : {
            sidebar,
          },

          data(){
            return{
                tasks : [],
                scans : [],
                redeems:[],
                chartdatacount:[],
                chartdatamonth:[],
                editModal:false,
                addModal: false,
                isAdding: false,
                editData:{
                    title:'',
                    author:'',
                    genre:'',
                    slug:'',
                    description:'',
                    isbn:'',
                    image:'',
                    published:'',
                    publisher:''
                },
                distributor:[],
                retailor:[],
                electrician:[],
                Dealer:[],
                index: -1,
                showDeleteModal: false,
                isDeleting:false,
                deleItem: {},
                deleteindex: -1,
                visible:false,
                chartOptions: {
        chart: {
          id: "vuechart-example",
          height: 350
        },
        xaxis: {
          categories: [],
        },
      },
      series: [
        {
          name: "scans",
          data: [],
        },
      ],
      plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
                

            }
	 },

     
    mounted(){
		this.getAllTask();
	 },
     methods : {

        getPendingCount(tasks){
            var result = tasks.filter((x) => { return x.status == "Pending"; });
            return result.length;
        },

        getProgressCount(tasks){
            var result = tasks.filter((x) => { return x.status == "Progress"; });
            return result.length;
        },

        getCompletedCount(tasks){
            var result = tasks.filter((x) => { return x.status == "Completed"; });
            return result.length;
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



	   	async getAllTask() {
			const res = await this.callApi('get','/api/all_task', { headers: {"Authorization" : `Bearer ${localStorage.getItem('token')}`} })
			if(res.status === 200){
                   this.tasks = res.data.data;
			}else {
				console.log('something went wrong!')

			}
		},

    },     
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
        }
    }
</script>
