<script setup>
import { computed, ref } from "vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import InputNumber from "primevue/inputnumber";
import Textarea from "primevue/textarea";

const props = defineProps({
    visible: Boolean,
    value: {
        type: Object,
        default: {
            id: "",
            title: "",
            value: null,
            description: "",
            errors: {},
        },
    },
    subjectOptions: {
        type: Array,
        default: () => [],
    },
});

const emits = defineEmits(["update:visible", "save"]);

const loading = ref(true);

const visible = computed({
    get() {
        return props.visible;
    },
    set(newValue) {
        emits("update:visible", newValue);
    },
});

const onModalHide = () => {
    loading.value = true;

    // set value to default
    props.value.id = "";
    props.value.title = "";
    props.value.value = null;
    props.value.description = "";
};

const save = (e) => {
    emits("save", e);
};
</script>

<template>
    <Dialog
        v-model:visible="visible"
        :header="(props.value.id !== '' ? 'Update' : 'Add') + ' Criteria'"
        modal
        :draggable="false"
        :style="{ minWidth: '70vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
        @hide="onModalHide"
    >
        <div class="space-y-4">
            <div>
                <InputLabel for="title" value="Title" />
                <InputText
                    v-model="props.value.title"
                    id="title"
                    placeholder="Title"
                    class="w-full rounded-md"
                />
                <InputError :message="props.value.errors.title" class="mt-2" />
            </div>
            <div>
                <InputLabel for="description" value="Description" />
                <Textarea
                    v-model="props.value.description"
                    id="description"
                    placeholder="Description"
                    class="w-full rounded-md"
                />
                <InputError
                    :message="props.value.errors.description"
                    class="mt-2"
                />
            </div>
            <div>
                <InputLabel for="value" value="Bobot" />
                <InputNumber
                    v-model="props.value.value"
                    id="value"
                    placeholder="Bobot"
                    class="w-full"
                    inputClass="!rounded-md"
                    inputId="minmaxfraction"
                    :minFractionDigits="0"
                    :maxFractionDigits="3"
                />
                <InputError :message="props.value.errors.value" class="mt-2" />
            </div>
        </div>

        <template #footer>
            <button
                @click="visible = false"
                class="p-button-secondary mr-2 h-10 w-20 inline-flex justify-center items-center rounded-md border border-transparent shadow-sm text-base font-medium text-white bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
            >
                Cancel
            </button>
            <button
                @click="save"
                class="p-button-success w-20 h-10 inline-flex justify-center items-center rounded-md border border-transparent shadow-sm text-base font-medium text-white bg-green-400 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
            >
                Simpan
            </button>
        </template>
    </Dialog>
</template>
