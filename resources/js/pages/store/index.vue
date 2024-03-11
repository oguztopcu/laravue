<template>
    <Layout>
        <div class="flex flex-col">
            <div class="mb-4">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    @click="handleNewKey"
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
                                Key
                            </th>
                            <th
                                class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm"
                            >
                                Value
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
                                {{ item.key }}
                            </td>
                            <td class="w-1/3 text-left py-3 px-4">
                                {{ item.value }}
                            </td>
                            <td class="text-left py-3 px-4">
                                <button type="button" @click="handleEdit(item.id)" class="mr-2 mb-2">Edit</button>
                                <button type="button" @click="handleDeleteKey(item.id)">Delete</button>
                            </td>
                        </tr>
                        <tr v-if="items.length < 1">
                            <td colspan="4" class="text-center py-3 px-4">
                                <span>No provided value for user </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../../components/layout.vue";

export default {
    name: "Store Lists",
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
                let response = await window.axios.get("/keys");
                this.items = response.data.data;
            } catch (err) {
                console.error(err);
            }
        },

        handleNewKey() {
            this.$router.push('/store/create');
        },

        handleEdit(id) {
            this.$router.push(`/store/${id}`);
        },

        async handleDeleteKey(id) {
            try {
                await window.axios.delete(`/keys/${id}`);
                this.getLists();
            } catch (err) {
                console.error(err);
            }
        }
    },
};
</script>
