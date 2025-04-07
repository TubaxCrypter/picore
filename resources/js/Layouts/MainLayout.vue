<script setup>
import { ref } from 'vue';
import Header from '@/Layouts/Header.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';
import { ToastContainer } from 'vue-toast-notification';

// Mobil görünümde sidebar varsayılan olarak kapalı, PC'de açık
const showMobileSidebar = ref(false);

const toggleMobileSidebar = () => {
    showMobileSidebar.value = !showMobileSidebar.value;
};
</script>

<template>
    <div class="min-h-screen bg-base-100">
        <!-- Toast Container -->
        <ToastContainer />
        
        <!-- PC ve mobil için ayrı sidebar bileşenleri -->
        <Sidebar :show-mobile="showMobileSidebar" @update:show-mobile="showMobileSidebar = $event" />
        
        <!-- Header - PC'de margin var, mobilde yok -->
        <div class="md:ml-64">
            <Header @toggle-sidebar="toggleMobileSidebar" />
            
            <!-- Ana içerik alanı -->
            <main class="transition-all duration-300 py-6">
                <slot name="header"></slot>
                <div class="container mx-auto px-4">
                    <slot></slot>
                </div>
            </main>
            
            <!-- Footer -->
            <Footer class="mt-auto" />
        </div>
    </div>
</template>