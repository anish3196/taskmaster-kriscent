<template>
     
    <router-view></router-view>
</template>
<script>
     import sidebar from './sidebar.vue'
     import lower from "./footer.vue"
    export default{
    components:{
        sidebar,
        lower
        },
    }
</script>