<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineEmits(['toggle-sidebar']);

const user = usePage().props.auth.user;
</script>

<template>
    <header class="bg-base-100 border-b border-base-200 shadow-sm">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo ve Sidebar Toggle -->
                <div class="flex items-center">
                    <button @click="$emit('toggle-sidebar')" 
                            class="mr-2 p-2 rounded-md hover:bg-base-200 focus:outline-none lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <Link :href="route('dashboard')" class="flex items-center">
                        <ApplicationLogo class="block h-9 w-auto text-gray-800" />
                        <span class="ml-2 text-lg font-semibold">PiNet</span>
                    </Link>
                </div>

                <!-- Sağ Menü -->
                <div class="flex items-center">
                    <!-- Bildirimler Ikonu -->
                    <button class="mr-4 rounded-full p-1 hover:bg-base-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <!-- Kullanıcı Dropdown -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center text-sm font-medium transition hover:text-primary focus:outline-none">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-2">
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <div>
                                        <span>{{ user.name }}</span>
                                    </div>
                                </div>
                                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="p-2 text-sm text-gray-500">
                                <div class="font-semibold">{{ user.email }}</div>
                            </div>
                            <hr class="my-1">
                            <DropdownLink :href="route('profile.edit')">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil
                                </div>
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Çıkış Yap
                                </div>
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>
    </header>
</template>