<script setup>
import { ref } from "vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import { FilterMatchMode } from "primevue/api";
import { DateTimeToFormat } from "@/utils";
import { Link } from "@inertiajs/vue3";

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
            <Column header="No.">
                <template #body="{ index }">
                    {{ index + 1 }}
                </template>
            </Column>

            <Column field="title" header="Name"></Column>
            <Column header="Last Update">
                <template #body="{ data }">
                    {{ DateTimeToFormat(data.updated_at, "DD MMMM YYYY") }}
                </template>
            </Column>
            <Column>
                <template #body="{ data }">
                    <div class="flex justify-end">
                        <Link :href="route('result.edit', [data.id])">
                            <Button
                                icon="pi pi-file-edit"
                                severity="secondary"
                                text
                            />
                        </Link>
                    </div>
                </template>
            </Column>

            <template #empty>
                <div class="text-center">No Data</div>
            </template>
        </DataTable>
    </div>
</template>
