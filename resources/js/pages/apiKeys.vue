<template>
    <Layout>
        <div class="flex flex-col">
            <div class="mb-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    @click="handleNewApiKey"
                >
                    Add
                </button>
            </div>
            <div>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th
                                class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm"
                            >
                                #
                            </th>
                            <th
                                class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm"
                            >
                                Api Key
                            </th>
                            <th
                                class="text-left py-3 px-4 uppercase font-semibold text-sm"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr v-for="item in items" :key="item.id">
                            <td class="w-1/3 text-left py-3 px-4">
                                {{ item.id }}
                            </td>
                            <td class="w-1/3 text-left py-3 px-4">
                                {{ item.token }}
                            </td>
                            <td class="text-left py-3 px-4">
                                <button type="button" @click="handleDeleteKey(item.id)">Sil</button>
                            </td>
                        </tr>
                        <tr v-if="items.length < 1">
                            <td colspan="3" class="text-center py-3">No provided data for user</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../components/layout.vue";

export default {
    name: "apiKeys",
    components: [Layout],
    data() {
        return {
            items: [],
        };
    },
    mounted() {
        this.getLists();
    },
    methods: {
        async getLists() {
            try {
                let response = await window.axios.get("/api-keys");
                this.items = response.data.data;
            } catch (err) {
                console.error(err);
            }
        },

        async handleNewApiKey() {
            try {
                await window.axios.post('/api-keys', {});
                this.getLists();
            } catch (err) {
                console.error(err);
            }
        },

        async handleDeleteKey(id) {
            try {
                await window.axios.delete(`/api-keys/${id}`);
                this.getLists();
            } catch (err) {
                console.error(err);
            }
        }
    },
};
</script>
