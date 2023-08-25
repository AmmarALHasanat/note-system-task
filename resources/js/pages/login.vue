<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 mt-4">
            <h2 class="m-1">Login</h2>
            <p class="text-danger" v-if="error">{{error}}</p>
            <form @submit.prevent="login">
                <div class="form-group m-1">
                    <label for="email">Email Address:</label>
                    <input type="email" class="form-control" id="email"  v-model="form.email">
                </div>
                <div class="form-group m-1">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password"  v-model="form.password">
                </div>
                <button type="submit" class="form-group btn btn-dark m-1 col-2">Login</button>
            </form>
        </div>
    </div>
    </div>
</template>
<script>
import { reactive,ref } from 'vue'
import { useRouter } from "vue-router"
import { useStore } from 'vuex'
export default {
    setup() {
        let form = reactive({
            email: '',
            password: ''
        });
        
        let error = ref('')
        let router= useRouter()
        const store = useStore()
        const login= async()=>{
            await axios.post('/api/auth/login',form).then(res=>{
                // console.log(res.data.status)
                if (res.data.status) {
                    error.value=null;
                    // console.log(res.data.data.token)
                    // localStorage.setItem('token',res.data.data.token)
                    store.dispatch('setToken', res.data.data.token);
                    router.push({name: 'Dashboard' })
                }
            }).catch(e => {
                error.value = e.response.data.message
            })
        }
        
        return {
            form,
            login,
            error
        }
    }
}
</script>