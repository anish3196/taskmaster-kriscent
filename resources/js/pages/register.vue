<template>
    <div class="login-section">
		<div class="login-section-inner">
			<div class="row">
				<div class="col-md-6 pe-0">
					<div class="login-section-left">
						<h1>Register</h1>
                        <p class="text-danger" v-if="error">{{ error }}</p>

                <form @submit.prevent="register">
                    <div class="input-field mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" v-model="form.name">
                    </div>
                    <div class="input-field mb-3">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="input-field mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <div class="input-field mb-3">
                        <label for="cpassword" class="form-label">Confoirm password</label>
                        <input type="password" class="form-control" id="cpassword" v-model="form.c_password">
                    </div>
                    <div class="input-field mb-3">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
                <div class="input-field mb-3">
                        <router-link to="/">back to login page</router-link>
                    </div>
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
                name :'',
                email: '',
                password: '',
                c_password: '',
            });
            let errors = ref([])

            const register = async() =>{
                await axios.post('/api/register',form).then(res=>{
                    if(res.data.success){
                        store.dispatch('setToken',res.data.data.token)
                        router.push({name:'Dashboard'})
                    }
                }).catch(e=>{
                    errors.value = e.response.data.message
                })
            }
            return{
                form,
                register,
                errors
            }
        }
    }
</script>
