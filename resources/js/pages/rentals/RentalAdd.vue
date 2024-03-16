<template>
    <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k"
            class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>

    <form class="space-y-6" @submit.prevent="submitForm">
        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <label for="car" class="block text-sm font-medium text-gray-700">Car</label>
                <div class="mt-1">
                    <select name="car_id" id="car_id"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="rental.car_id">
                        <option value="">Select Car</option>
                        <option v-for="car in cars" :key="car.id" :value="car.id">
                            {{ car.name }} ({{ car.no_plat }}) - {{ car.model }}
                        </option>
                    </select>
                </div>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <div class="mt-1">
                    <input type="date" name="start_date" id="start_date"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="rental.start_date">
                </div>
            </div>

            <fieldset>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <div class="mt-1">
                        <input type="date" name="end_date" id="end_date"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="rental.end_date">
                    </div>
                </div>
            </fieldset>
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
            <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sewa
            </button>
        </div>
    </form>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            rental: {
                user_id: document.querySelector("meta[name='user-id']").getAttribute('content'),
                car_id: '',
                start_date: new Date().toISOString().substr(0, 10),
                end_date: new Date().toISOString().substr(0, 10)
            },
            cars: [],
            errors: null
        }
    },
    async created() {
        await this.getCars();
    },
    methods: {
        async getCars() {
            try {
                const response = await axios.get('/api/cars-available');
                this.cars = response.data.data;
            } catch (error) {
                swal('Error', 'Failed to fetch cars', 'error');
            }
        },

        validateMandatory() {
            let isValid = true;
            if (!this.rental.car_id) {
                this.errors = { car_id: ['The car field is required'] };
                isValid = false;
            }
            if (!this.rental.start_date) {
                this.errors = { start_date: ['The start field is required'] };
                isValid = false;
            }
            if (!this.rental.end_date) {
                this.errors = { end_date: ['The end field is required'] };
                isValid = false;
            }
            return isValid;
        },

        async submitForm() {
            if (!this.validateMandatory()) {
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to rent this car?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, rent it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await axios.post('/api/rentals', this.rental);
                        Swal.fire(
                            'Success!',
                            'Car has been rented',
                            'success'
                        );
                        this.$router.push({ name: 'rental.list' });
                    } catch (error) {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to rent car, please select another date',
                                'error'
                            );
                        }
                    }
                }
            });
        }
    }
}
</script>
