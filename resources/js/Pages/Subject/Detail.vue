<script setup>
import { onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GeneralSection from "./Partials/GeneralSection.vue";
import axios from "axios";
import { useToast } from "primevue/usetoast";

const toast = useToast();
const props = defineProps({
    subject: {
        type: Object,
        default: {
            id: null,
            title: "",
            description: "",
        },
    },
});

const form = useForm({
    _method: "PUT",
    id: props.subject?.data?.id,
    title: props.subject?.data?.title,
    description: props.subject?.data?.description,
    errors: {},
});

const criterias = ref([]);
const subjectItems = ref([]);

const submit = () => {
    form.loading = true;
    axios.get(route("sanctum.csrf-cookie")).then((res) => {
        form.post(route("subject.update", [form.id]), {
            preserveScroll: true,
            onSuccess: () => {
                toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: "Data berhasil diubah",
                    life: 3000,
                });
            },
            onError: () => {
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Data gagal diubah",
                    life: 3000,
                });
            },
        });
    });
};

onMounted(() => {
    getCriterias();
    getSubjectItems();
});

const getCriterias = async () => {
    axios.get(route("sanctum.csrf-cookie")).then(async (res) => {
        try {
            const response = await axios.get(route("criterias"), {
                params: {
                    type: "collection",
                    options: [
                        `filter,subject_id,equal,${props.subject.data.id}`,
                    ],
                },
            });

            const result = await response.data;

            criterias.value = result.data;
        } catch (error) {
            criterias.value = [];
        }
    });
};

const getSubjectItems = async () => {
    axios.get(route("sanctum.csrf-cookie")).then(async (res) => {
        try {
            const response = await axios.get(route("subject-items"), {
                params: {
                    type: "collection",
                    options: [
                        `filter,subject_id,equal,${props.subject.data.id}`,
                    ],
                },
            });

            const result = await response.data;

            subjectItems.value = result.data;
        } catch (error) {
            subjectItems.value = [];
        }
    });
};
</script>

<template>
    <Head>
        <title>Data Forum</title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Data Forum
            </h2>
        </template>
        <Toast />
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <GeneralSection :form="form" @submit="submit" />
                </div>
                <div
                    class="overflow-hidden bg-white p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <div
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Criteria
                    </div>
                    <Criteria
                        :criteria="criterias"
                        :subject="props.subject.data"
                        @onUpdate="getCriterias"
                    />
                </div>
                <div
                    class="overflow-hidden bg-white p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <div
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Subject Item
                    </div>
                    <SubjectItem
                        :subjectItem="subjectItems"
                        :subject="props.subject.data"
                        @onUpdate="getSubjectItems"
                    />
                </div>

                <Link
                    :href="route('subject.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 mr-2"
                >
                    Kembali
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
