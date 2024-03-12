<template>
    <div class="flex w-full h-screen justify-center items-center">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div
                class="bg-red-500 p-4 rounded text-gray-200 mb-4"
                v-if="error.length"
            >
                {{ error }}
            </div>

            <form @submit.prevent="onHandleLogin">
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
                    Log in
                </button>

                <div class="flex mt-5">
                    <router-link to="/register" class="w-full bg-red-500 text-white rounded text-center py-3">Register</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
            error: "",
        };
    },
    methods: {
        async onHandleLogin() {
            try {
                this.error = '';

                let response = await window.axios.post("/auth/login", {
                    email: this.email,
                    password: this.password,
                });

                localStorage.setItem('token', response.data.token);
                // note: bootstrap.js de var
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
                this.$router.push('/');
            } catch (err) {
                this.error = err.response.data.message;
            }
        },
    },
};
</script>
