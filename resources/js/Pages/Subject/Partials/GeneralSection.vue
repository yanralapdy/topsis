<script setup>
import InputError from "@/Components/InputError.vue";
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

const submit = () => {
    emit("submit");
};

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
                    class="w-full border-gray-300 rounded-md"
                />
                <InputError :message="props.form.errors.title" class="mt-2" />
            </div>
            <div>
                <InputLabel for="description" value="Description" />
                <textarea
                    v-model="props.form.description"
                    id="description"
                    placeholder="Description"
                    class="w-full border-gray-300 rounded-md min-h-[10rem]"
                />
                <InputError :message="props.form.errors.description" class="mt-2" />
            </div>
        </div>
        <div>
            <button
                type="button"
                class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                :disabled="props.form.loading"
                processing
                @click="submit"
            >
                Save
            </Button>
        </div>
    </section>
</template>
