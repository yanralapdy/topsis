<template>
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div
            class="modal fixed top-0 left-0 w-full h-full bg-black opacity-50"
            @click="closeModal"
        ></div>
        <div class="modal-dialog relative bg-white vw-50 rounded-lg shadow-lg">
            <div class="modal-content p-4">
                <div class="modal-header pb-4 border-b">
                    <h2 class="text-xl font-semibold">{{ title }}</h2>
                    <button
                        @click="closeModal"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            ></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <img :src="imageUrl" alt="Image" class="!max-h-[90vh]" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        imageUrl: String,
        title: String,
    },
    setup(props, { emit }) {
        const closeModal = () => {
            emit("close");
        };

        return {
            closeModal,
        };
    },
};
</script>
