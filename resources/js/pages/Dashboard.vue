<template>
    <div id="layout-dashboard">
        <div class="flex flex-wrap -mx-4">
                    <h2 class="text-2xl font-semibold">Welcome {{ user }} to the Dashboard</h2>
        </div>
        <br>
        <div v-if="role" class="flex flex-wrap -mx-4">
            <div class="w-full md:w-1/3 px-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items center">
                        <div class="flex-shrink-0 mr-4">
                            <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v7m0 0v7m0-7h7m-7 0H5"></path>
                            </svg>
                        </div>
                        <div class="text-right text-gray-800 font-semibold">
                            <h2 class="text-2xl">Total Users</h2>
                            <p class="text-3xl">{{ total_user }}</p>
                        </div>
                    </div>
                    <!--<a href="#" class="block mt-4 text-center text-blue-500">View all</a>-->
                </div>
            </div>
            <div class="w-full md:w-1/3 px-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v7m0 0v7m0-7h7m-7 0H5"></path>
                            </svg>
                        </div>
                        <div class="text-right text-green-500 font-semibold">
                            <h2 class="text-2xl">Total Cars</h2>
                            <p class="text-3xl">{{ total_car }}</p>
                        </div>
                    </div>
                    <!--<a href="#" class="block mt-4 text-center text-blue-500">View all</a>-->
                </div>
            </div>
            <div class="w-full md:w-1/3 px-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v7m0 0v7m0-7h7m-7 0H5"></path>
                            </svg>
                        </div>
                        <div class="text-right text-red-500 font-semibold">
                            <h2 class="text-2xl">Total Rentals</h2>
                            <p class="text-3xl">{{ total_rental }}</p>
                        </div>
                        <!--<a href="#" class="block mt-4 text-center text-blue-500">View all</a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            total_user: 0,
            total_car: 0,
            total_rental: 0,
            role: true,
            user: document.querySelector("meta[name='user-name']").getAttribute('content'),
            user_role: document.querySelector("meta[name='user-role']").getAttribute('content'),
            user_id : document.querySelector("meta[name='user-id']").getAttribute('content')
        };
    },
    methods: {

    },
    mounted() {
        if (this.user_role == 'admin') {
            this.role = true;
        } else {
            this.role = false;
        }
        localStorage.setItem('user_role', this.user_role);
        localStorage.setItem('user_name', this.user);
        localStorage.setItem('user_id', this.user_id);
    },
};
</script>

<style scoped></style>
