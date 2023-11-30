<script setup>
import { onMounted, ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GeneralSection from "./Partials/GeneralSection.vue";
import axios from "axios";
import Criteria from "./Partials/Criteria.vue";
import SubjectItem from "./Partials/SubjectItem.vue";
import Normalized from "./Partials/Normalized.vue";
import WeightedNormalized from "./Partials/WeightedNormalized.vue";

const props = defineProps({
    result: {
        type: Object,
        default: {
            id: null,
            title: "",
            description: "",
            errors: {},
        },
    },
});

const criterias = ref([]);
const subjectItems = ref([]);
const subjectItemNormalizedMatrik = ref([]);
const subjectItemWeightedNormalizedMatrik = ref([]);

onMounted(() => {
    getCriterias();
    getSubjectItems();
    getSubjectItemNormalizedMatrik();
    getSubjectItemWeightedNormalizedMatrik();
});

const getCriterias = async () => {
    axios.get(route("sanctum.csrf-cookie")).then(async (res) => {
        try {
            const response = await axios.get(route("result-criteria"), {
                params: {
                    type: "collection",
                },
            });

            const result = await response.data;
            console.log(result.data);
            criterias.value = result.data;
        } catch (error) {
            criterias.value = [];
        }
    });
};

const getSubjectItems = async () => {
    axios.get(route("sanctum.csrf-cookie")).then(async (res) => {
        try {
            const response = await axios.get(route("result-subject-item"), {
                params: {
                    type: "collection",
                },
            });

            const result = await response.data;
            console.log(result.data);

            subjectItems.value = result.data;
        } catch (error) {
            subjectItems.value = [];
        }
    });
};

const getSubjectItemNormalizedMatrik = async () => {
    axios.get(route("sanctum.csrf-cookie")).then(async (res) => {
        try {
            const response = await axios.get(route("result-subject-item-normalized-matrik"), {
                params: {
                    type: "collection",
                },
            });

            const result = await response.data;

            subjectItemNormalizedMatrik.value = result.data;
        } catch (error) {
            subjectItemNormalizedMatrik.value = [];
        }
    });
};

const getSubjectItemWeightedNormalizedMatrik = async () => {
    axios.get(route("sanctum.csrf-cookie")).then(async (res) => {
        try {
            const response = await axios.get(route("result-subject-item-weighted-normalized-matrik"), {
                params: {
                    type: "collection",
                    orderBy: "pi",
                    sortBy: "desc",
                },
            });

            const result = await response.data;

            subjectItemWeightedNormalizedMatrik.value = result.data;
        } catch (error) {
            subjectItemWeightedNormalizedMatrik.value = [];
        }
    });
};

</script>

<template>
    <Head>
        <title>Generate Result Data</title>
    </Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Generate Result Data
            </h2>
        </template>
        <Toast />
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-[#383833] p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <GeneralSection :form="result.data" />
                </div>
                <div
                    class="overflow-hidden bg-[#383833] p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <div
                        class="text-xl font-semibold leading-tight text-white"
                    >
                        Criteria
                    </div>
                    <Criteria
                        :value="criterias"
                    />
                </div>
                <div
                    class="overflow-hidden bg-[#383833] p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <div
                        class="text-xl font-semibold leading-tight text-white"
                    >
                        Hotel
                    </div>
                    <SubjectItem
                        :value="subjectItems"
                    />
                </div>
                <div
                    class="overflow-hidden bg-[#383833] p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <div
                        class="text-xl font-semibold leading-tight text-white"
                    >
                        Normalize Matrik
                    </div>
                    <Normalized
                        :value="subjectItemNormalizedMatrik"
                    />
                </div>
                <div
                    class="overflow-hidden bg-[#383833] p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <div
                        class="text-xl font-semibold leading-tight text-white"
                    >
                        Weighted Normalize Matrik and Result
                    </div>
                    <WeightedNormalized
                        :value="subjectItemWeightedNormalizedMatrik"
                    />
                </div>

                <Link
                    :href="route('subject.index')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-[#f3f702] border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 mr-2"
                >
                    Kembali
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
