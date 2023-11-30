<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import { onMounted } from "vue";

const props = defineProps({
    form: {
        type: Object,
        default: {
            title: "",
            description: "",
            errors: {
                title: "",
                description: "",
            },
            loading: false,
        },
    },
});

const emit = defineEmits(["submit"]);

onMounted(() => {
    axios.get(route("sanctum.csrf-cookie")).then((res) => {});
});
</script>
<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                General Information
            </h2>
        </header>

        <div class="mt-6 grid sm:grid-cols-1 gap-6">
            <div>
                <InputLabel for="title" value="Title" />
                <input
                    v-model="props.form.title"
                    id="title"
                    placeholder="Title"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled bg-gray-100 text-gray-500"
                    disabled
                />
            </div>
        </div>
    </section>
</template>
