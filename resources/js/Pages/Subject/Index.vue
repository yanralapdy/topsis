<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "./Partials/DataTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ModalForm from "./Partials/ModalForm.vue";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import DestroyModal from "@/Components/DestroyModal.vue";

defineProps({
    subject: Object,
});

const form = useForm({
    _method: "POST",
    id: "",
    title: "",
    description: "",
    errors: {},
});

const showModalCreate = ref(false);
const showModalDestroy = ref(false);
const toast = useToast();
const save = () => {
    let url = route("subject.store");

    if (form.id === "") {
        form.post(url, {
            preserveScroll: true,
            onError: (e) => {
                console.log(e);
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
                    detail: "Subject has been added.",
                    life: 3000,
                });
            },
        });
    } else {
        url = route("subject.update", [form.id]);
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
                    detail: "Subject has been updated",
                    life: 3000,
                });
            },
        });
    }
};

const destroy = () => {
    const url = route("subject.destroy", [form.id]);
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
                detail: "Subject has been deleted",
                life: 3000,
            });
        },
    });
};

const destroyConfirm = (id) => {
    form.id = id;
    form.title = "Delete Subject";
    showModalDestroy.value = true;
};
</script>

<template>
    <Head>
        <title>Data Subject</title>
    </Head>

    <AuthenticatedLayout>
        <Toast />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Subject
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Action Table -->
                <div class="flex justify-between mb-4">
                    <PrimaryButton @click="showModalCreate = true"
                        >Create</PrimaryButton
                    >
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :value="subject.data" @destroy="destroyConfirm" />
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
