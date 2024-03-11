<template>
    <div class="flex w-full h-screen justify-center items-center">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div
                class="bg-red-500 p-4 rounded text-gray-200 mb-4"
                v-if="error.length"
            >
                {{ error }}
            </div>

            <form @submit.prevent="onHandle">
                <label class="block mb-4">
                    Name
                    <input
                        type="text"
                        v-model="name"
                        class="w-full mt-2 p-2 border rounded"
                    />
                </label>
                <label class="block mb-4">
                    Email
                    <input
                        type="text"
                        v-model="email"
                        class="w-full mt-2 p-2 border rounded"
                    />
                </label>
                <label class="block mb-4">
                    Password
                    <input
                        type="password"
                        v-model="password"
                        class="w-full mt-2 p-2 border rounded"
                    />
                </label>
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    Register
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            error: "",
        };
    },
    methods: {
        async onHandle() {
            try {
                this.error = '';

                await window.axios.post("/auth/register", {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                });

                this.$router.push('/login');
            } catch (err) {
                this.error = err.response.data.message;
            }
        },
    },
};
</script>
