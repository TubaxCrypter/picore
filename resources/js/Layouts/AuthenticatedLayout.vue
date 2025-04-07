<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" v-model="showingNavigationDropdown" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 shadow-md lg:hidden">
                <div class="flex-none">
                    <label for="my-drawer-2" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1">
                    <Link :href="route('dashboard')" class="btn btn-ghost normal-case text-xl">
                        <ApplicationLogo class="block h-9 w-auto fill-current" />
                    </Link>
                </div>
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <div class="text-center leading-10 bg-primary text-primary-content font-bold">
                                    {{ $page.props.auth.user.name.charAt(0) }}
                                </div>
                            </div>
                        </label>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <Link :href="route('profile.edit')" class="justify-between">
                                    Profile
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('logout')" method="post" as="button" class="justify-between">
                                    Log Out
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Heading -->
            <header class="bg-base-100 shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                <slot />
            </main>
        </div>
        <div class="drawer-side z-40">
            <label for="my-drawer-2" class="drawer-overlay"></label> 
            <div class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
                <!-- Sidebar content here -->
                <div class="flex items-center mb-6">
                    <Link :href="route('dashboard')" class="btn btn-ghost normal-case text-xl">
                        <ApplicationLogo class="block h-9 w-auto fill-current" />
                    </Link>
                </div>
                <ul class="menu menu-lg gap-2">
                    <li>
                        <Link :href="route('dashboard')" :class="{ 'active': route().current('dashboard') }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('tasks.index')" :class="{ 'active': route().current('tasks.*') }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Görevler
                        </Link>
                    </li>
                </ul>
                <div class="mt-auto">
                    <div class="divider"></div>
                    <div class="flex items-center gap-2 p-2">
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-10">
                                <span class="text-xl">{{ $page.props.auth.user.name.charAt(0) }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold">{{ $page.props.auth.user.name }}</div>
                            <div class="text-xs opacity-70">{{ $page.props.auth.user.email }}</div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <ul class="menu menu-sm">
                        <li>
                            <Link :href="route('profile.edit')" :class="{ 'active': route().current('profile.edit') }">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('logout')" method="post" as="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
