<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import DataTable from "./Partials/DataTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ModalForm from "./Partials/ModalForm.vue";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import DestroyModal from "@/Components/DestroyModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    criteria: Object,
});

const emits = defineEmits(["update:visible", "onUpdate"]);

const onUpdate = () => {
    emits("onUpdate");
};

const form = useForm({
    _method: "POST",
    id: "",
    title: "",
    value: null,
    description: "",
    errors: {},
});

const showModalCreate = ref(false);
const showModalDestroy = ref(false);
const toast = useToast();
const save = () => {
    let url = route("criteria.store");
    if (form.id === "") {
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
                    detail: "Criteria has been added.",
                    life: 3000,
                });
                onUpdate();
            },
        });
    } else {
        url = route("criteria.update", [form.id]);
        form._method = "PUT";
        form.put(url, {
            preserveScroll: true,
            onError: (e) => {
                showModalCreate.value = false;
                form.reset();
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: e.response.data.message,
                    life: 3000,
                });
            },
            onSuccess: (e) => {
                showModalCreate.value = false;
                form.reset();
                toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: "Criteria has been updated",
                    life: 3000,
                });
                onUpdate();
            },
        });
    }
};

const destroy = () => {
    const url = route("criteria.destroy", [form.id]);
    form.delete(url, {
        preserveScroll: true,
        onError: (e) => {
            showModalDestroy.value = false;
            form.reset();
            toast.add({
                severity: "error",
                summary: "Error",
                detail: e.response.data.message,
                life: 3000,
            });
        },
        onSuccess: (e) => {
            showModalDestroy.value = false;
            form.reset();
            toast.add({
                severity: "success",
                summary: "Success",
                detail: "Criteria has been deleted",
                life: 3000,
            });
            onUpdate();
        },
    });
};

const edit = (data) => {
    form.value = data.value;
    form.title = data.title;
    form.id = data.id;
    form.description = data.description;

    showModalCreate.value = true;
};

</script>

<template>
    <Head>
        <title>Data Criteria</title>
    </Head>

    <AuthenticatedLayout>
        <Toast />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Criteria
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable
                        :value="criteria.data"
                        @edit="edit"
                    />
                </div>
            </div>
        </div>
        <DestroyModal
            v-model:visible="showModalDestroy"
            :value="form"
            @destroy="destroy"
        />
        <ModalForm
            v-model:visible="showModalCreate"
            :value="form"
            @save="save"
        />
    </AuthenticatedLayout>
</template>
