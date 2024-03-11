<template>
    <layout>
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form @submit.prevent="onHandle">
                <label class="block mb-4">
                    Key
                    <input
                        type="text"
                        v-model="key"
                        class="w-full mt-2 p-2 border rounded"
                    />
                </label>

                <label class="block mb-4">
                    Value
                    <input
                        type="text"
                        v-model="value"
                        class="w-full mt-2 p-2 border rounded"
                    />
                </label>

                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    Save
                </button>
            </form>
        </div>
    </layout>
</template>

<script>
import Layout from '../../components/layout.vue';

export default {
    name: 'Store Create',
    components: [
        Layout
    ],
    data() {
        return {
            key: '',
            value: ''
        };
    },
    mounted() {
        this.get(this.$route.params.keyId);
    },
    methods: {
        async get(id) {
            try {
                let response = await window.axios.get(`keys/${id}`);

                this.key = response.data.data.key;
                this.value = response.data.data.value;
            } catch (err) {
                console.error(err);
            }
        },

        async onHandle() {
            try {
                await window.axios.post(`/keys`, {
                    key: this.key,
                    value: this.value
                });

                this.$router.push('/store');
            } catch (err) {
                console.error(err);
            }
        }
    }
};
</script>