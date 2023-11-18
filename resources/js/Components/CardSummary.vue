<script setup>
defineProps({
    value: Object,
    total: Number,
});
</script>
<template>
    <div
        class="relative flex w-56 !h-[30rem] flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md"
    >
        <div
            class="relative mx-4 mt-4 min-h-[13.5rem] py-1 overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg px-1"
        >
            <div
                class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] w-full"
            >
                <div
                    class="my-auto flex aspect-square overflow-hidden rounded-full bg-gray-100 border-gray-50"
                >
                    <div class="flex-1">
                        <img
                            :src="value?.candidate?.data?.president_image_url"
                            class="h-full w-full object-cover"
                            alt=""
                        />
                    </div>

                    <div class="flex-1">
                        <img
                            :src="
                                value?.candidate?.data?.vice_president_image_url
                            "
                            class="h-full w-full object-cover"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 text-center">
            <h4
                class="mb-2 block font-sans text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased"
            >
                {{ ((value?.total_vote / total || 0) * 100).toFixed(2) }}
                %
            </h4>
            <p
                class="block bg-gradient-to-tr from-pink-600 to-pink-400 bg-clip-text font-sans text-base font-medium leading-relaxed text-transparent antialiased"
            >
                Total Vote :
                {{ value?.total_vote }}
            </p>
            <h4
                class="mb-2 block font-sans text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased"
            >
                {{ value?.candidate?.data?.president_name }}
                &
                {{ value?.candidate?.data?.vice_president_name }}
            </h4>
        </div>
    </div>
</template>
