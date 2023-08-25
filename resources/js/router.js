import { createWebHistory, createRouter } from "vue-router";
import home from './pages/home.vue';
import login from './pages/login.vue';
import register from './pages/register.vue';
import dashboard from './pages/dashboard.vue';
import showNote from './pages/note/showNote.vue';
import editNote from './pages/note/editNote.vue';
import createNote from './pages/note/createNote.vue';


import store from './store';

const routes = [
  { path: '/', name:'Home' , component: home },
  { path: '/login', name:'Login' , component: login, meta:{requiresAuth:false}},
  { path: '/register', name:'Register' , component: register, meta:{requiresAuth:false}},
  { path: '/dashboard', name:'Dashboard' , component: dashboard, meta:{requiresAuth:true}},
  { path: '/notes/:id/edit', name: 'EditNote',component: editNote, props: true, meta:{requiresAuth:true}},
  { path: '/notes/:id/', name: 'ShowNote',component: showNote, props: true, meta:{requiresAuth:true}},
  { path: '/notes/create/', name: 'CreateNote',component: createNote, meta:{requiresAuth:true}},

];

const router=createRouter({
  history: createWebHistory(),
  routes,
});



router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && store.getters.getToken == 0){
        return { name : 'Login'}
    }
    if(to.meta.requiresAuth == false && store.getters.getToken != 0){
        return { name : 'Dashboard'}
    }
})

export default  router;

