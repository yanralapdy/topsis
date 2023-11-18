<script setup>
defineProps({
    title: String,
    subtitle: String
})
</script>

<template>
    <section class="grid sm:grid-cols-3">
        <header>
            <slot name="header">
                <h2 class="text-lg font-semibold leading-7 text-gray-900">{{ title }}</h2>
    
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    {{ subtitle }}
                </p>
            </slot>
        </header>

        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 sm:col-span-2">
            <slot></slot>
        </div>
    </section>
</template>