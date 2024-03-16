<template>
    <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k"
            class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>

    <form class="space-y-6" v-on:submit.prevent="saveCar">
        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="carData.name">
                </div>
            </div>

            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                <div class="mt-1">
                    <input type="text" name="brand" id="brand"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="carData.brand">
                </div>
            </div>

            <div>
                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                <div class="mt-1">
                    <input type="text" name="model" id="model"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="carData.model">
                </div>
            </div>

            <div>
                <label for="no_plat" class="block text-sm font-medium text-gray-700">No Plat</label>
                <div class="mt-1">
                    <input type="text" name="no_plat" id="no_plat"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="carData.no_plat">
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga Sewa</label>
                <div class="mt-1">
                    <input type="number" name="price" id="price"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="carData.price">
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Status</label>
                <div class="mt-1">
                    <select name="status" id="status"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="carData.status">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>
            </div>

            <!-- <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <div class="mt-1">
                    <input type="file" name="image" id="image"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <img :src="imagePreview" class="mt-2" v-if="imagePreview">
            </div> -->

        </div>
        <!-- save button-->
        <div class="flex justify-end">
            <router-link to="/cars"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                Back
            </router-link>&nbsp;&nbsp;
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save
            </button>
        </div>
    </form>
</template>

<script setup>
import useCars from '@/composables/cars'
import { onMounted } from 'vue';

const { errors, carData, updateCar, getCarData } = useCars()
const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

onMounted(() => getCarData(props.id))

const saveCar = async () => {
    await updateCar(props.id)
}
</script>
