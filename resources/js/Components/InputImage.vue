<script setup>
import { computed, ref } from 'vue';

const props = defineProps(['modelValue'])
const emits = defineEmits(['update:modelValue'])

const image = computed({
    get() {
        return props.modelValue
    },
    set(newImage) {
        emits('update:modelValue', newImage)
    }
})

const profilePictureUrl = computed(() => {
    const value = image.value;

    if (value) {
        return typeof value === 'string' || value instanceof String ? value : URL.createObjectURL(value);
    }

    return null;
});

const inputImage = ref(null);

const onImageSelect = (e) => {
    const [file] = inputImage.value.files;

    image.value = file || null;
};
</script>

<template>
    <div
        class="group relative flex aspect-square w-32 cursor-pointer items-center justify-center overflow-hidden rounded-full border bg-gray-500"
        v-tooltip.bottom="{ value: `<span class='text-sm'>Click to update photo</span>`, escape: true }"
        @click="inputImage.click()">

        <input ref="inputImage" type="file" class="hidden" accept="image/*" @input="onImageSelect($event)" />

        <div
            class="absolute bottom-0 flex h-1/3 w-full items-center justify-center bg-black/70 opacity-0 transition-all duration-200 ease-in group-hover:opacity-100">
            <span class="pi pi-camera !text-lg !text-gray-100"></span>
        </div>

        <img :src="profilePictureUrl" class="h-full w-full object-cover" v-if="image" />
        <span class="pi pi-user text-gray-400" v-else></span>
    </div>
</template>
