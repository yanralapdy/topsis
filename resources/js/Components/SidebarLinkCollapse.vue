<script setup>
import { ref } from 'vue';

defineProps({
    icon: String,
    label: String,
    active: Boolean,
});

const toggle = ref(false);
</script>

<template>
    <div
        class="w-full cursor-pointer gap-4 rounded-lg px-4 py-2 text-sm text-gray-300 hover:text-gray-100 transition-all ease-linear duration-500"
        :class="{'bg-gray-800': toggle || active}">
        <button class="flex w-full items-center justify-between" @click="toggle = !toggle">
            <div class="flex items-center gap-4">
                <span class="pi pi-megaphone"></span>
                <span>Notifikasi</span>
            </div>

            <span class="pi pi-angle-right transition-all duration-500 ease-in-out" :class="{'rotate-90': toggle}"></span>
        </button>

        <transition name="p-toggleable-content">
            <div v-show="toggle" class="p-toggleable-content">
                <div
                    class="my-2 flex flex-col pl-8 text-gray-400">
                    <slot></slot>
                </div>
            </div>
        </transition>
    </div>
</template>
