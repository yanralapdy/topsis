<script setup>
import { inject } from 'vue';
import { router } from '@inertiajs/vue3';
import Button from 'primevue/button';

const props = defineProps({
    message: String,
    href: String,
});

const swal = inject('$swal');

const destroy = () => {
    swal.mixin({
        customClass: {
            confirmButton: 'p-button p-component p-button-danger !mr-2',
            cancelButton: 'p-button p-component !bg-slate-600 hover:!bg-slate-600/90',
        },
        buttonsStyling: false,
    })
    .fire({
        icon: 'warning',
        title: 'Peringatan',
        text: props.message,
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus Data!',
    })
    .then((result) => {
        if (result.isConfirmed) {
            router.delete(props.href, {
                preserveScroll: true,
                onSuccess() {
                    swal.fire('Deleted!', 'Sukses Hapus Data.', 'success');
                },
            });
        }
    });
};
</script>

<template>
    <Button icon="pi pi-trash" severity="danger" text @click="destroy" v-tooltip.bottom="'Hapus'" />
</template>
