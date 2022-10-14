require('./bootstrap');

import { createApp } from 'vue'
import App from './components/App.vue'
import router from './router'
import store from './store'

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

store.dispatch('getUser').then(()=>{
    createApp(App)
        .use(router)
        .use(store)
        .mount('#app');
});
