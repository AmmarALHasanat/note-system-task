import './bootstrap';
import { createApp } from 'vue';
import '../sass/app.scss';

import store from './store';

//const app = createApp({});
// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);
// app.mount('#app');

import App from './layout/app.vue'
import router from './router';

createApp(App)
.use(router)
.use(store)
.mount("#app");

