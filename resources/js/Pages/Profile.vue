<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Profil" />
    
    <MainLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Profil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex">
                    <div class="w-64 bg-gray-100 p-4 rounded-lg mr-6">
                        <h2 class="font-bold mb-4">Menü</h2>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-blue-500">Profil Bilgileri</a></li>
                            <li><a href="#" class="hover:text-blue-500">Ayarlar</a></li>
                            <li><a href="#" class="hover:text-blue-500">Geçmiş</a></li>
                            <li><a href="#" class="hover:text-blue-500">Çıkış Yap</a></li>
                        </ul>
                    </div>

                    <div class="flex-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="text-2xl font-bold mb-4">Profil Sayfası</h1>
                            <!-- Profil içeriğiniz buraya gelecek -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>