<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import DataTable from "./Components/DataTable.vue";
import ModalForm from "./Components/ModalForm.vue";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import DestroyModal from "@/Components/DestroyModal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    subjectItem: Object,
});

const emits = defineEmits(["update:visible", "onUpdate", "destroyConfirm"]);

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
    let url = route("subject-item.store");
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
                    detail: "Subject Item has been added.",
                    life: 3000,
                });
                onUpdate();
            },
        });
    } else {
        url = route("subject-item.update", [form.id]);
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
                    detail: "Subject Item has been updated",
                    life: 3000,
                });
                onUpdate();
            },
        });
    }
};

const destroy = () => {
    const url = route("subject-item.destroy", [form.id]);
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
                detail: "Subject Item has been deleted",
                life: 3000,
            });
            onUpdate();
        },
    });
};

const edit = (data) => {
    form.price = data.price;
    form.title = data.title;
    form.id = data.id;
    form.descriptions = data.descriptions;
    form.rating = data.rating;
    form.star = data.star;
    form.facility = data.facility;

    showModalCreate.value = true;
};

const destroyConfirm = (id) => {
    form.id = id;
    form.title = "Delete Subject Item";
    showModalDestroy.value = true;
};
</script>

<template>
    <Head>
        <title>Data Subject Item</title>
    </Head>

    <AuthenticatedLayout>
        <Toast />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Subject Item
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
                <div
                    class="bg-[#383833] overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <DataTable
                        :value="subjectItem.data"
                        @edit="edit"
                        @destroy="destroyConfirm"
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
