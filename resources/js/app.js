import './bootstrap';

import { createApp } from 'vue';
import app from './components/app.vue';
import router from './router.js';
import layout from './components/layout.vue';

createApp(app)
    .use(router)
    .component('Layout', layout)   
    .mount('#app');