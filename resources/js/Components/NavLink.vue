<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex items-center w-full px-4 py-2 rounded-lg bg-primary text-primary-content font-medium'
        : 'flex items-center w-full px-4 py-2 rounded-lg hover:bg-primary/10 text-base-content hover:text-primary'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
