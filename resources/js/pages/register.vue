<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <h2 class="m-1">Register</h2>
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="register">
                        <div class="form-group m-1">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" v-model="form.name">
                        </div>
                    <div class="form-group m-1">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group m-1">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <button type="submit" class="form-group btn btn-dark m-1 col-2">Register</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { reactive, ref } from 'vue'
import { useRouter } from "vue-router"
import { useStore } from 'vuex'
export default {
    setup() {
        let form = reactive({
            name:'',
            email: '',
            password: ''
        });
        let errors = ref([])
        let router = useRouter()
        const store = useStore()
        const register = async () => {
            await axios.post('/api/auth/register', form).then(res => {
                // console.log(res.data.status)
                if (res.data.status) {
                    errors.value = null;
                    // console.log(res.data.data.token)
                    // localStorage.setItem('token', res.data.data.token)
                    store.dispatch('setToken', res.data.data.token)
                    router.push({ name: 'Dashboard' })
                }
            }).catch(e => {
                errors.value = e.response.data.errors
            })
        }

        return {
            form,
            register,
            errors
        }
    }
}
</script>
