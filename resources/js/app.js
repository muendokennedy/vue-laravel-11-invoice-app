import './bootstrap';

import { createApp } from 'vue';
import router from './Router/index.js';
import app from './components/app.vue';

createApp(app).use(router).mount('#app');
