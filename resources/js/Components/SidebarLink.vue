<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});
</script>

<template>
    <Link
        :href="href"
        :class="[
            'flex cursor-pointer items-center gap-4 rounded-lg px-4 py-2 text-sm text-gray-300 hover:text-gray-100',
            { 'bg-gray-800 text-gray-100': active },
        ]">
        <slot />
    </Link>
</template>
