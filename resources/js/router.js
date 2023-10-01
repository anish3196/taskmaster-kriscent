import { createWebHistory, createRouter } from 'vue-router';
import login from './pages/login.vue';
import register from './pages/register.vue';
import dashboard from './pages/dashboard.vue';
import homelist from './components/task/homelist.vue'
import homelistadd from './components/task/homelistadd.vue'


import profile from './components/admin/profile.vue'

import store from './store'

const routes = [
    // {
    //     path : '/apimurphy/public',
    //     name : 'Home',
    //     component : home
    // },
    {
        path : '/',
        name : 'Login',
        component : login,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/register',
        name : 'Register',
        component : register,
        meta:{
            requiresAuth:false
        }
    },
    {
        path : '/dashboard',
        name : 'Dashboard',
        component : dashboard,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/homelist',
        name : 'Homelist',
        component : homelist,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/homelistadd',
        name : 'Homelistadd',
        component : homelistadd,
        meta:{
            requiresAuth:true
        }
    },
    {
        path : '/adminprofile',
        name : 'Profile',
        component : profile,
        meta:{
            requiresAuth:true
        }
    },



];

const router = createRouter({
    history: createWebHistory(),
    routes
});


router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && store.getters.getToken == 0){
        return { name : 'Login'}
    }
    if(to.meta.requiresAuth == false && store.getters.getToken != 0){
        return { name : 'Dashboard'}
    }
})

export default router;
