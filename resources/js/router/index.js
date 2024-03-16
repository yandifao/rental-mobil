import { createRouter, createWebHistory } from 'vue-router'

import Dashboard from '@/pages/Dashboard.vue'
import CarsList from '@/pages/cars/CarsList.vue'
import CarsAdd from '@/pages/cars/CarsAdd.vue'
import CarsEdit from '@/pages/cars/CarsEdit.vue'
import RentalAdd from '@/pages/rentals/RentalAdd.vue'
import RentalReturn from '@/pages/rentals/RentalReturn.vue'
import RentalList from '@/pages/rentals/RentalList.vue'

const routes = [
    {
        path: '/',
        name: 'dashboard.index',
        component: Dashboard
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/cars',
        name: 'cars.index',
        component: CarsList
    },
    {
        path: '/cars/add',
        name: 'cars.add',
        component: CarsAdd
    },
    {
        path: '/cars/:id/edit',
        name: 'cars.edit',
        component: CarsEdit,
        props: true
    },
    {
        path: '/rental',
        name: 'rental.add',
        component: RentalAdd
    },
    {
        path: '/rental/list',
        name: 'rental.list',
        component: RentalList
    },
    {
        path: '/return/:id',
        name: 'rental.return',
        component: RentalReturn
    },
];

export default createRouter({
    history: createWebHistory(),
    routes
})
