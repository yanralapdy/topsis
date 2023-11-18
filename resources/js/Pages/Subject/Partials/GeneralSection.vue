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
    emit("submit", props.form);
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
                <InputText
                    v-model="form.title"
                    id="title"
                    placeholder="Title"
                    class="w-full"
                />
                <InputError :message="form.errors.title" class="mt-2" />
            </div>
            <div>
                <InputLabel for="description" value="Description" />
                <Textarea
                    v-model="form.description"
                    id="description"
                    placeholder="Description"
                    class="w-full"
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
        </div>
        <div>
            <Button
                type="button"
                class="mt-4"
                :disabled="form.loading"
                processing
                @click="submit"
            >
                Save
            </Button>
        </div>
    </section>
</template>
