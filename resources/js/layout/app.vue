<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
            <div class="container-fluid bg-with">
                
                <router-link class="navbar-brand" :to="{ name: 'Home' }" exact active-class="active">Note system</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <!-- Add 'exact' and 'active-class' attributes -->
                        <router-link class="nav-link" :to="{ name: 'Login' }" active-class="active" v-if="$store.getters.getToken == 0" >Login</router-link>
                        <router-link class="nav-link" :to="{ name: 'Register' }" active-class="active" v-if="$store.getters.getToken == 0" >Register</router-link>
                        <router-link class="nav-link" :to="{ name: 'Dashboard' }" active-class="active" v-if="$store.getters.getToken != 0" >Dashboard</router-link>
                        <button type="button" class="btn btn-dark" @click="logout" v-if="$store.getters.getToken != 0">Logout</button>
                    </div>
                    
                </div>
            </div>
        </nav>
        <router-view>
        </router-view>
    </div>
</template>

<script>
import { useRouter } from "vue-router"
import { useStore } from 'vuex'
export default {
    setup() {
        const store = useStore();
        const router = useRouter();

        function logout() {
            // localStorage.removeItem('token');
            store.dispatch('removeToken');
            router.push({ name: 'Home' })
        }
        return {
            logout,
        }
    }
}
</script>
