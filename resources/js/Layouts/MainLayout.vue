<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Header from '@/Layouts/Header.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

// Mobil görünümde sidebar varsayılan olarak kapalı, PC'de açık
const showMobileSidebar = ref(false);

const toggleMobileSidebar = () => {
    showMobileSidebar.value = !showMobileSidebar.value;
};
</script>

<template>
    <div class="flex min-h-screen bg-base-200">
        <!-- Sidebar - PC'de her zaman görünür, mobilde gizli -->
        <Sidebar :show-mobile="showMobileSidebar" @update:show-mobile="showMobileSidebar = $event" />

        <!-- Main Content -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Header -->
            <Header @toggle-sidebar="toggleMobileSidebar" />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-base-100 p-4 md:p-6">
                <!-- Page Heading -->
                <header class="mb-6" v-if="$slots.header">
                    <div class="mx-auto">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <div class="mx-auto">
                    <slot />
                </div>
            </main>

            <!-- Footer -->
            <Footer />
        </div>
    </div>
</template>