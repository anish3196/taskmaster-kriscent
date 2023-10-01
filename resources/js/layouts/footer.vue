<template>
      <footer>
        <div class="footer-inner d-flex align-items-center justify-content-between">
            <div class="footer-inner-left">
                <p>© 2023 Made By Anish Dubey</p>
            </div>
            <div class="footer-inner-right">
                <ul class="d-flex align-items-center list-unstyled">
                    <li><router-link to="/dashboard">Dashboard</router-link></li>
                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>
    <router-view></router-view>
</template>

<script>
    import { useRouter } from "vue-router"
    import { Store, useStore } from 'vuex'
    import '../datatable.min.js';
    import '../bootstrap.datatable.min.js'
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

        mounted(){ 
            $('#example').DataTable();
	 },
    }
</script>