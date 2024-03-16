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
                <label for="no_plat" class="block text-sm font-medium text-gray-700">No Plat</label>
                <div class="mt-1">
                    <input type="text" name="no_plat" id="no_plat"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="rental.no_plat">
                </div>
            </div>

            <fieldset>
                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                    <div class="mt-1">
                        <input type="date" name="return_date" id="return_date"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="rental.return_date">
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
                Kembalikan
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
                user_id: localStorage.getItem('user_id'),
                no_plat: '',
                return_date: new Date().toISOString().substr(0, 10)
            },
            cars: [],
            errors: null,
            rental_id: this.$route.params.id
        }
    },
    async created() {
        await this.getCars();
    },
    methods: {
        async getCars() {
            try {
                const response = await axios.get('/api/cars');
                this.cars = response.data.data;
            } catch (error) {
                swal('Error', 'Failed to fetch cars', 'error');
            }
        },

        validateMandatory() {
            let isValid = true;
            if (!this.rental.no_plat) {
                this.errors = { no_plat: ['The No Plat field is required'] };
                isValid = false;
            }
            if (!this.rental.return_date) {
                this.errors = { return_date: ['The Return Date field is required'] };
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
                        const response = await axios.post('/api/return/'+this.rental_id, this.rental);
                        Swal.fire(
                            'Success!',
                            'Car has been returned',
                            'success'
                        );
                        this.$router.push({ name: 'rental.list' });
                    } catch (error) {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to return car',
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
