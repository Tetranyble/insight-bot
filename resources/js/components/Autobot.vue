<script>
import axios from 'axios';

export default {
    name: "Autobot",
    data() {
        return {
            users: [],
            intervalId: null
        };
    },
    mounted() {
        this.intervalId = setInterval(this.fetchUsers, 5000);
    },
    beforeDestroy() {
        clearInterval(this.intervalId); // Clear interval on component destroy
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await axios.get('autobots');
                this.users = response.data.data;

            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
    },
};
</script>

<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">User List</h2>
        <ul v-if="users.length" class="bg-white rounded-lg shadow-md p-4">
            <li v-for="user in users" :key="user.id" class="py-2 border-b border-gray-200 last:border-none">
                <span class="text-lg font-semibold text-gray-700">{{ user.name }}</span>
                <span class="text-sm text-gray-500">- {{ user.email }}</span>
            </li>
        </ul>
        <p v-else class="text-gray-500">No users found.</p>
    </div>
</template>

<style scoped>

</style>
