<template>
    <div class="login-section">
		<div class="login-section-inner">
			<div class="row">
				<div class="col-md-6 pe-0">
					<div class="login-section-left">
						<h1>Login</h1>
                        <p class="text-danger" v-if="error">{{ error }}</p>
						<form class="user-login"  @submit.prevent="login">
							<div class="input-field mb-3">
								<label for="exampleFormControlInput1" class="form-label">Email</label>
							  	<input type="email" class="form-control" id="email" v-model="form.email" >
							</div>
							<div class="input-field mb-3">
								<label for="exampleFormControlInput1" class="form-label">Password</label>
							  	<input type="password" class="form-control" id="password" v-model="form.password">
							</div>
							<div class="input-field mb-3">
							  	<input type="submit" class="form-control" id="login-btn" value="Login">
							</div>
							Don't have an account? <router-link to="/register">Register</router-link>
						</form>
					</div>
				</div>
				<div class="col-md-6 ps-0">
					<div class="login-section-right">
					</div>
				</div>
				</div>
		</div>
	</div>
    
</template>
<script>
    import { reactive,ref } from 'vue'
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'
    export default{
        setup(){
            const router = useRouter()
            const store = useStore()

            let form = reactive({
                email: '',
                password: ''
            });
            let error = ref('')

            const login = async() =>{
                await axios.post('/api/login',form).then(res=>{
                    if(res.data.success){
                        store.dispatch('setToken',res.data.data.token);
                        router.push({name:'Dashboard'})
                    }else{
                        error.value = res.data.message;
                    }
                })
            }
            return{
                form,
                login,
                error
            }
        }
    }
</script>