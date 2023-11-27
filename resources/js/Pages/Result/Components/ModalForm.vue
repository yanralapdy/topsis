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
            rating: null,
            star: null,
            price: null,
            facility: null,
            descriptions: "",
            errors: {},
        },
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
    props.value.rating = null;
    props.value.star = null;
    props.value.price = null;
    props.value.description = "";
};

const save = (e) => {
    emits("save", e);
};
</script>

<template>
    <Dialog
        v-model:visible="visible"
        header="Generate Result"
        modal
        :draggable="false"
        :style="{ minWidth: '70vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
        @hide="onModalHide"
    >

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
                Generate
            </button>
        </template>
    </Dialog>
</template>
