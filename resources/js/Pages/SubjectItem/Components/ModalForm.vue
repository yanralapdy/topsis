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
    props.value.facility = null;
    props.value.description = "";
};

const save = (e) => {
    emits("save", e);
};
</script>

<template>
    <Dialog
        v-model:visible="visible"
        :header="(props.value.id !== '' ? 'Update' : 'Add') + ' Subject Item'"
        modal
        :draggable="false"
        :style="{ minWidth: '70vw' }"
        overlayStyle="background-color: #383833"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
        @hide="onModalHide"
    >
        <div class="space-y-4">
            <div>
                <InputLabel for="title" value="Name" />
                <InputText
                    v-model="props.value.title"
                    id="title"
                    placeholder="Name"
                    class="w-full rounded-md"
                />
                <InputError :message="props.value.errors.title" class="mt-2" />
            </div>
            <div>
                <InputLabel for="descriptions" value="Descriptions" />
                <Textarea
                    v-model="props.value.descriptions"
                    id="descriptions"
                    placeholder="Descriptions"
                    class="w-full rounded-md"
                />
                <InputError
                    :message="props.value.errors.descriptions"
                    class="mt-2"
                />
            </div>
            <div>
                <InputLabel
                    for="facility"
                    value="Facility Value of The Hotel"
                />
                <InputNumber
                    v-model="props.value.facility"
                    id="facility"
                    placeholder="Facility Value of The Hotel"
                    class="w-full"
                    inputClass="!rounded-md"
                    inputId="minmaxfraction"
                    :minFractionDigits="0"
                    :maxFractionDigits="10"
                />
                <InputError
                    :message="props.value.errors.facility"
                    class="mt-2"
                />
            </div>
            <div>
                <InputLabel for="rating" value="Rating From App" />
                <InputNumber
                    v-model="props.value.rating"
                    id="rating"
                    placeholder="Rating From App"
                    class="w-full"
                    inputClass="!rounded-md"
                    inputId="minmaxfraction"
                    :minFractionDigits="0"
                    :maxFractionDigits="10"
                />
                <InputError :message="props.value.errors.rating" class="mt-2" />
            </div>
            <div>
                <InputLabel for="star" value="Hotel Star" />
                <InputNumber
                    v-model="props.value.star"
                    id="star"
                    placeholder="Hotel Star"
                    class="w-full"
                    inputClass="!rounded-md"
                    inputId="minmaxfraction"
                    :minFractionDigits="0"
                    :maxFractionDigits="10"
                />
                <InputError :message="props.value.errors.rating" class="mt-2" />
            </div>
            <div>
                <InputLabel for="price" value="Hotel Price" />
                <InputNumber
                    v-model="props.value.price"
                    id="price"
                    placeholder="Hotel Price"
                    class="w-full"
                    inputClass="!rounded-md"
                    inputId="minmaxfraction"
                    :minFractionDigits="0"
                    :maxFractionDigits="10"
                />
                <InputError :message="props.value.errors.rating" class="mt-2" />
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
