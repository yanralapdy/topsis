<script setup>
import { ref } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode } from "primevue/api";

defineProps({
    value: Object,
});

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>

<template>
    <div>
        <DataTable
            v-model:filters="filters"
            :value="value"
            paginator
            :rows="10"
            dataKey="id"
            :globalFilterFields="['title', 'description']"
            :rowsPerPageOptions="[5, 10, 20, 50]"
        >
            <template #header>
                <div class="flex justify-end">
                    <div class="relative">
                        <input
                            class="border border-gray-300 bg-[#383833] h-10 px-5 pr-10 rounded-full text-sm focus:outline-none placeholder:text-white"
                            v-model="filters['global'].value"
                            placeholder="Keyword Search"
                        />
                        <div
                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                        >
                            <i class="pi pi-search" />
                        </div>
                    </div>
                </div>
            </template>

            <Column field="title" header="Name"></Column>
            <Column header="Description">
                <template #body="{ data }">
                    {{ data.descriptions ? data.descriptions : "-" }}
                </template>
            </Column>
            <Column header="Price" field="price"></Column>
            <Column field="facility" header="Facility Value"></Column>
            <Column field="rating" header="Rating from App"></Column>
            <Column field="star" header="Star"></Column>
            <Column field="si_plus">
                <template #header>
                    <div>Si<span class="align-super">+</span></div>
                </template>
            </Column>
            <Column field="si_min">
                <template #header>
                    <div>Si<span class="align-super">-</span></div>
                </template>
            </Column>
            <Column field="pi" header="Pi"></Column>

            <Column header="Ranking">
                <template #body="{ index }">
                    {{ index + 1 }}
                </template>
            </Column>

            <template #empty>
                <div class="text-center">No Data</div>
            </template>
        </DataTable>
    </div>
</template>
