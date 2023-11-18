<template>
    <div class="mb-12 min-h-[50vh] border rounded-lg p-6">
        
    </div>

    <div class="flex items-center gap-2">
        <input type="text" class="w-full border rounded-md flex-1">
        <button class="bg-blue-500 cursor-pointer px-4 py-2 hover:bg-blue-600 rounded-md text-white">
            Send
        </button>
    </div>
</template>

<script setup>
import axios from 'axios';
import { onMounted } from 'vue';
import { ref } from 'vue';

const messages = ref([]);

const fetchMessage = () => {
    axios.post(route('get-message'), {
        sender: 1
    })
    .then(res => res.data)
    .then(res => {
        console.log(res)
    })
    .catch(err => console.log(err));
}

onMounted(() => {
    fetchMessage()
})
</script>