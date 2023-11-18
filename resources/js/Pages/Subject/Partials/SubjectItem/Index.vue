<script setup>
import { useForm } from "@inertiajs/vue3";
import DataTable from "./Components/DataTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ModalForm from "./Components/ModalForm.vue";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import DestroyModal from "@/Components/DestroyModal.vue";

const props = defineProps({
    subjectItem: Object,
    subject: Object,
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
    subject_id: props.subject.id,
    description: "",
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
    form.value = data.value;
    form.title = data.title;
    form.id = data.id;
    form.description = data.description;
    form.subject_id = props.subject.id;

    showModalCreate.value = true;
};

const destroyConfirm = (id) => {
    form.id = id;
    form.title = "Delete Subject Item";
    showModalDestroy.value = true;
};
</script>

<template>
    <div>
        <Toast />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Action Table -->
                <div class="flex justify-between mb-4">
                    <PrimaryButton @click="showModalCreate = true"
                        >Create</PrimaryButton
                    >
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable
                        :value="subjectItem"
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
            :subjectOptions="[
                {
                    id: props.subject.id,
                    title: props.subject.title,
                },
            ]"
            @save="save"
        />
    </div>
</template>
