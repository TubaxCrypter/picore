<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
    showMobile: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:show-mobile']);

const user = usePage().props.auth.user;

// Mobil görünüm için sınıflar
const mobileSidebarClass = computed(() => {
    return props.showMobile ? 'translate-x-0' : '-translate-x-full';
});

// Mobil sidebar kapatma methodu
const closeMobileSidebar = () => {
    emit('update:show-mobile', false);
};
</script>

<template>
    <!-- PC'de sabit, mobilde gizli/gösterilebilir sidebar -->
    <aside class="hidden md:block md:fixed left-0 top-0 w-64 min-h-screen bg-base-200 text-base-content z-30 border-r border-base-300">
        <!-- Sidebar content (PC) -->
        <div class="flex flex-col h-full">
            <!-- Sidebar header -->
            <div class="p-4 border-b border-base-300">
                <div class="flex items-center justify-start pl-2">
                    <span class="text-xl font-bold">PiNet2</span>
                </div>
            </div>

            <!-- User info (PC) -->
            <div class="p-4 border-b border-base-300">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-9 rounded-full bg-primary/20 flex items-center justify-center">
                        {{ user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <div class="font-medium">{{ user.name }}</div>
                        <div class="text-xs opacity-60 truncate">{{ user.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-grow p-4 space-y-1 overflow-y-auto">
                <div class="pb-2 text-xs uppercase font-semibold text-base-content/60">Ana Menü</div>
                
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Gösterge Paneli
                </NavLink>

                <NavLink :href="route('tasks.index')" :active="route().current('tasks.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Görev Yönetimi
                </NavLink>

                <NavLink href="#" :active="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Kullanıcılar
                </NavLink>

                <NavLink href="#" :active="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ayarlar
                </NavLink>

                <div class="pt-4 pb-2 mt-4 text-xs uppercase font-semibold text-base-content/60 border-t border-base-300">Hesap</div>
                
                <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil
                </NavLink>

                <Link :href="route('logout')" 
                    method="post" 
                    as="button" 
                    class="flex items-center w-full px-4 py-2 rounded-lg text-error hover:bg-error hover:text-error-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Çıkış Yap
                </Link>
            </nav>
        </div>
    </aside>

    <!-- Mobil için ayrı sidebar - sadece mobilde gösterilir -->
    <div v-if="showMobile" :class="[mobileSidebarClass, 'bg-base-200 text-base-content w-64 min-h-screen fixed left-0 top-0 z-30 transition-transform duration-300 ease-in-out md:hidden border-r border-base-300']">
        <!-- Sidebar content (Mobil) -->
        <div class="flex flex-col h-full">
            <!-- Sidebar header -->
            <div class="p-4 border-b border-base-300">
                <div class="flex items-center justify-start pl-2">
                    <span class="text-xl font-bold">PiNet</span>
                </div>
            </div>

            <!-- User info (Sadece mobilde gösterilir) -->
            <div class="p-4 border-b border-base-300">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-9 rounded-full bg-primary/20 flex items-center justify-center">
                        {{ user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <div class="font-medium">{{ user.name }}</div>
                        <div class="text-xs opacity-60 truncate">{{ user.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Navigation (Mobil) -->
            <nav class="flex-grow p-4 space-y-1 overflow-y-auto">
                <div class="pb-2 text-xs uppercase font-semibold text-base-content/60">Ana Menü</div>
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Gösterge Paneli
                </NavLink>

                <NavLink :href="route('tasks.index')" :active="route().current('tasks.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Görev Yönetimi
                </NavLink>

                <NavLink href="#" :active="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Kullanıcılar
                </NavLink>

                <NavLink href="#" :active="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ayarlar
                </NavLink>

                <div class="pt-4 pb-2 mt-4 text-xs uppercase font-semibold text-base-content/60 border-t border-base-300">Hesap</div>
                <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil
                </NavLink>

                <Link :href="route('logout')" 
                    method="post" 
                    as="button" 
                    class="flex items-center w-full px-4 py-2 rounded-lg text-error hover:bg-error hover:text-error-content">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Çıkış Yap
                </Link>
            </nav>
        </div>
    </div>

    <!-- Mobil arkaplan - sidebar açıkken tıklanınca kapatır -->
    <div v-if="showMobile" @click="closeMobileSidebar"
         class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden">
    </div>
</template>