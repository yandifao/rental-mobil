import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import router from './router'

import Dashboard from '@/pages/Dashboard.vue';
import CarsList from '@/pages/cars/CarsList.vue';

createApp({
    components: {
        Dashboard,
        CarsList
    }
}).use(router).mount('#app')

// import { createApp } from 'vue';
// import { createRouter, createWebHistory } from 'vue-router';

// // Import components
// // import App from './pages/App.vue';
// import Dashboard from './pages/Dashboard.vue';
// import CarsList from './pages/cars/CarsList.vue';
// import CarsAdd from './pages/cars/CarsAdd.vue';

// const router = createRouter({
//     history: createWebHistory(),
//     routes: [
//         { path: '/dashboard', component: Dashboard },
//         { path: '/cars', component: CarsList },
//         { path: '/cars/create', component: CarsAdd },
//     ]
// });

// const app = createApp(Dashboard);
// app.use(router);
// app.mount('#app');
