<template>
    <div class="flex flex-col h-screen">
        <div class="bg-slate-700 p-4 flex text-white cursor-pointer justify-end">
            <div @click="handleLogOut">
                Log Out
            </div>
        </div>
        <div class="grid grid-cols-[300px,1fr] h-full">
            <div class="bg-slate-700 py-3 px-3">
                <ul>
                    <li>
                        <router-link to="/api-keys" class="text-white text-center w-full block py-3 mb-3 hover:bg-slate-400 rounded">API Keys</router-link>
                    </li>
                    <li>
                        <router-link to="/store" class="text-white text-center w-full block py-3 mb-3 hover:bg-slate-400 rounded">Store</router-link>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col p-4">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Layout',
    methods: {
        async handleLogOut() {
            try {
                await window.axios.post(`/auth/logout`);

                localStorage.removeItem('token');

                this.$router.push('/login');
            } catch (err) {
                console.error(err);
            }
        }
    }
}
</script>