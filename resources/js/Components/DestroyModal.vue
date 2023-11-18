<script setup>
import { computed } from "vue";
import Dialog from "primevue/dialog";
import Button from "primevue/button";

const props = defineProps({
    visible: Boolean,
    value: {
        type: Object,
        default: {
            id: "",
            title: "Delete",
        },
    },
});

const emits = defineEmits(["update:visible", "destroy"]);

const visible = computed({
    get() {
        return props.visible;
    },
    set(newValue) {
        emits("update:visible", newValue);
    },
});

const onModalHide = () => {
    props.value.is_active = false;
};

const destroy = (status) => {
    props.value.status = status;
    emits("destroy");
};
</script>

<template>
    <Dialog
        v-model:visible="visible"
        :header="props.value.title"
        modal
        :draggable="false"
        :style="{ minWidth: '70vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
        @hide="onModalHide"
    >
        <template #footer>
            <Button
                class="!bg-green-500 !hover:bg-green-700 !border-green-500 !hover:border-green-700"
                label="Cancel"
                @click="props.visible = false"
            />
            <Button
                class="!bg-red-500 !hover:bg-red-700 !border-red-500 !hover:border-red-700"
                label="Delete"
                @click="destroy"
            />
        </template>
    </Dialog>
</template>
