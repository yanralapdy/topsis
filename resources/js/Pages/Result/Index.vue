<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import DataTable from "./Components/DataTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ModalForm from "./Components/ModalForm.vue";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import DestroyModal from "@/Components/DestroyModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    result: Object,
});

const emits = defineEmits(["update:visible", "onUpdate"]);

const onUpdate = () => {
    emits("onUpdate");
};

const form = useForm({
    _method: "POST",
    id: "",
    title: "",
    rating: null,
    star: null,
    price: null,
    facility: null,
    descriptions: "",
    errors: {},
});

const showModalCreate = ref(false);
const showModalDestroy = ref(false);
const toast = useToast();
const save = () => {
    let url = route("result.store");
    form.post(url, {
        preserveScroll: true,
        onError: (e) => {
            showModalCreate.value = false;
            form.reset();
            toast.add({
                severity: "error",
                summary: "Error",
                detail: e,
                life: 3000,
            });
        },
        onSuccess: (e) => {
            showModalCreate.value = false;
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Subject Item has been added.",
                life: 3000,
            });
            onUpdate();
        },
    });
};
</script>

<template>
    <Head>
        <title>Data Result</title>
    </Head>

    <AuthenticatedLayout>
        <Toast />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Result
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Action Table -->
                <div class="flex justify-between mb-4">
                    <button
                        @click="showModalCreate = true"
                        class="bg-[#f3f702] hover:bg-[#cccf49] text-black font-bold py-2 px-4 rounded"
                    >
                        Create
                    </button>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :value="result.data" />
                </div>
            </div>
        </div>
        <DestroyModal v-model:visible="showModalDestroy" :value="form" />
        <ModalForm
            v-model:visible="showModalCreate"
            :value="form"
            @save="save"
        />
    </AuthenticatedLayout>
</template>
