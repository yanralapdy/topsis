<script setup>
import { onMounted } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GeneralSection from "./Partials/GeneralSection.vue";
import axios from "axios";
import DataTable from "./Partials/ForumItem/Partials/DataTable.vue";

const props = defineProps({
    value: {
        type: Object,
        default: {
            id: null,
            title: "",
            description: "",
        },
    },
    criterias: {
        type: Object,
        default: {
            data: [],
        },
    },
    items: {
        type: Object,
        default: {
            data: [],
        },
    },
});

const form = useForm({
    id: props.value.id,
    title: props.value.title,
    description: props.value.description,
    errors: {
        title: "",
        description: "",
    },
    loading: false,
});

const submit = () => {
    form.loading = true;
    console.log(form.data);
    // axios
    //     .post(route("forum.store"), form.data)
    //     .then((res) => {
    //         form.loading = false;
    //         form.reset();
    //         form.post(route("forum.store"));
    //     })
    //     .catch((err) => {
            form.loading = false;
    //         form.errors = err.response.data.errors;
    //     });
};

onMounted(() => {
    axios.get(route("sanctum.csrf-cookie")).then((res) => {});
});
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

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <GeneralSection :form="form" @submit="submit" />
                </div>
                <!-- <div
                    class="overflow-hidden bg-white p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <DataTable :value="props.items.data" />
                </div> -->

                <Link
                    :href="route('forum.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 mr-2"
                >
                    Kembali
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
