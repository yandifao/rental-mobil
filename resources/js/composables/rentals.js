import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useRentals() {
    const rentalData = ref([])
    const rentals = ref([])

    const errors = ref('')
    const router = useRouter()

    var listCar = [];

    const getRentals = async () => {
        let response = await axios.get('/api/return/'+localStorage.getItem('user_id'))
        rentals.value = response.data.data
        listCar = response.data.data;
    }

    const getCarData = async (id) => {
        let response = await axios.get(`/api/rentals/${id}`)
        rentals.value = response.data.data;
    }

    const searchCar = (data) => {
        if (data === '') {
            rentals.value = listCar;
            return;
        }

        let result = listCar.filter((rental) => {
            return rental.name.toLowerCase().includes(data.toLowerCase()) || rental.brand.toLowerCase().includes(data.toLowerCase()) || rental.model.toLowerCase().includes(data.toLowerCase()) || rental.no_plat.toLowerCase().includes(data.toLowerCase());
        });
        rentals.value = result;
    }

    const storeCar = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/rentals', data)
            await router.push({ name: 'rentals.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }

    }

    const updateCar = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/rentals/${id}`, rentalData.value)
            await router.push({ name: 'rentals.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            } else {
                errors.value = e.response.data.message
            }
        }
    }

    const destroyCar = async (id) => {
        await axios.delete(`/api/rentals/${id}`)
    }

    return {
        errors,
        rentalData,
        rentals,
        getCarData,
        getRentals,
        storeCar,
        updateCar,
        destroyCar,
        searchCar
    }
}
