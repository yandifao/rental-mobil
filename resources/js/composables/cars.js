import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useCars() {
    const carData = ref([])
    const cars = ref([])

    const errors = ref('')
    const router = useRouter()

    var listCar = [];

    const getCars = async () => {
        let response = await axios.get('/api/cars')
        cars.value = response.data.data
        listCar = response.data.data;
    }

    const getCarData = async (id) => {
        let response = await axios.get(`/api/cars/${id}`)
        cars.value = response.data.data;
    }

    const searchCar = (data) => {
        if (data === '') {
            cars.value = listCar;
            return;
        }

        let result = listCar.filter((car) => {
            return car.name.toLowerCase().includes(data.toLowerCase()) || car.brand.toLowerCase().includes(data.toLowerCase()) || car.model.toLowerCase().includes(data.toLowerCase()) || car.no_plat.toLowerCase().includes(data.toLowerCase());
        });
        cars.value = result;
    }

    const storeCar = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/cars', data)
            await router.push({ name: 'cars.index' })
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
            await axios.patch(`/api/cars/${id}`, carData.value)
            await router.push({ name: 'cars.index' })
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
        await axios.delete(`/api/cars/${id}`)
    }

    return {
        errors,
        carData,
        cars,
        getCarData,
        getCars,
        storeCar,
        updateCar,
        destroyCar,
        searchCar
    }
}
