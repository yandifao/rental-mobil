<template>
    <div class="flex mb-4 place-content-end">
        <div class="px-4 py-2 text-white bg-blue-500 rounded-md">
            <router-link :to="{ name: 'cars.add' }" class="text-sm font-medium">Tambah</router-link>
        </div>
    </div>
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="min-w-full border divide-y divide-gray-200">
            <thead>
                <tr>
                    <!-- Filter -->
                    <div class="flex flex-col mb-4 place-content-end">
                        <div class="flex flex-row">
                            <div class="flex flex-row items-center">
                                <label for="search" class="text-gray-600">Search</label>
                                <input type="text" class="w-full px-2 py-1 ml-2 border rounded-md" v-on:keyup="searchCar($event.target.value)">
                            </div>
                        </div>
                    </div>
                </tr>
                <tr>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Nama
                            Mobil</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Brand</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Model</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Plat</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Harga
                            Sewa</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Status</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Action</span>
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                <template v-for="item in cars" :key="item.id">
                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ item.name }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ item.brand }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ item.model }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ item.no_plat }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ formatNumber(item.price) }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            <span v-if="item.status == 1"
                                class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                Available</span>
                            <span v-else
                                class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                Not Available</span>
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-center text-gray-900 whitespace-no-wrap">
                            <router-link :to="{ name: 'cars.edit', params: { id: item.id } }"
                                class="text-indigo-600 hover:text-indigo-900">Edit</router-link>
                            <button @click="deleteCar(item.id)"
                                class="text-red-600 hover:text-red-900 ml-2">Delete</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import useCars from '@/composables/cars'
import { onMounted } from 'vue';

const { cars, getCars, destroyCar, searchCar } = useCars()

const deleteCar = async (id) => {
    if (!window.confirm('You sure detete it?')) {
        return
    }

    await destroyCar(id)
    await getCars()
}

const formatNumber = (number) => {
   return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

onMounted(getCars)
</script>
