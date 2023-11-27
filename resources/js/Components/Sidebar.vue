<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import SidebarLink from '@/Components/SidebarLink.vue';

</script>

<template>
    <aside class="hidden md:block min-w-[265px] bg-gray-900 h-screen sticky top-0">
        <div class="relative">
            <div class="h-16 px-6 flex items-center border-b border-dashed border-slate-700">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <Link :href="route('dashboard')">
                        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-300" />
                    </Link>

                    <h2 class="text-gray-300 font-black text-lg">Kelompok 5</h2>
                </div>
            </div>

            <div class="absolute top-0 -right-3 h-full flex items-center">
                <!-- <button class="bg-white rounded-md shadow-md p-1.5 flex items-center justify-center text-gray-500">
                    <span class="pi pi-angle-double-left"></span>
                </button> -->
            </div>
        </div>

        <div class="p-4 space-y-3">
            <SidebarLink :href="route('dashboard')" :active="route().current('dashboard')">
                <span class="pi pi-th-large"></span>
                <span>Dashboard</span>
            </SidebarLink>

            <SidebarLink :href="route('subject-item.index')" :active="route().current('subject-item.*')">
                <span class="pi pi-building"></span>
                <span>Hotel</span>
            </SidebarLink>
            <SidebarLink :href="route('criteria.index')" :active="route().current('criteria.*')">
                <span class="pi pi-book"></span>
                <span>Kriteria</span>
            </SidebarLink>
            <SidebarLink :href="route('result.index')" :active="route().current('result.*')">
                <span class="pi pi-sort-numeric-down"></span>
                <span>Result</span>
            </SidebarLink>

            <!-- <SidebarLinkCollapse :active="route().current('notification.*')">
                <Link :href="route('notification.index')" class="hover:text-gray-300 w-full py-2">
                    List Notifikasi
                </Link>

                <Link :href="route('notification.group.index')" class="hover:text-gray-300 w-full py-2">
                    Group
                </Link>
            </SidebarLinkCollapse> -->

        </div>
    </aside>
</template>
