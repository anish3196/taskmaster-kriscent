import { createApp } from 'vue';
import router from './router.js';
import store from './store';
import './anish.js'
import './bootstrap.datatable.min.js'
import './bootstrap.min.js';
import './custom.js';
import './bootstrap.js';





import App from './layouts/app.vue'

createApp(App)
    .use(router)
    .use(store)
    .mount("#app")

