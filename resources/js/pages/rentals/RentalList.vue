<template>
    <div class="flex mb-4 place-content-end">
        <div class="px-4 py-2 text-white bg-blue-500 rounded-md">
            <router-link :to="{ name: 'rental.add' }" class="text-sm font-medium">Tambah Sewa</router-link>
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
                                <input type="text" class="w-full px-2 py-1 ml-2 border rounded-md" v-on:keyup="searchRental($event.target.value)">
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
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Periode Sewa</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Tanggal Pengembalian</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Total
                            Sewa</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Total Tambahan</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">
                        <span
                            class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase">Action</span>
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                <template v-for="item in rentals" :key="item.id">
                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ item.name }} ({{ item.brand }} {{ item.model }} - {{ item.no_plat }})
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ item.start_date }} - {{ item.end_date }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ item.return_date == null ? 'Belum Kembali' : item.return_date }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ formatNumber(item.price) }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ formatNumber(item.additional_cost) }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-center text-gray-900 whitespace-no-wrap">
                            <router-link :to="{ name: 'rental.return', params: { id: item.id } }"
                                class="text-indigo-600 hover:text-indigo-900">Kembalikan</router-link>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import useRentals from '@/composables/rentals'
import { onMounted } from 'vue';

const { rentals, getRentals, destroyRental, searchRental } = useRentals()

const deleteRental = async (id) => {
    if (!window.confirm('You sure detete it?')) {
        return
    }

    await destroyRental(id)
    await getRentals()
}

const formatNumber = (number) => {
   return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

onMounted(getRentals)
</script>
