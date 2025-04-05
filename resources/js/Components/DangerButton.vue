<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false
    },
    size: {
        type: String,
        default: null // null, sm, md, lg
    }
});
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        :class="[
            'btn btn-error',
            size ? `btn-${size}` : '',
            disabled ? 'opacity-70 cursor-not-allowed' : ''
        ]"
    >
        <slot />
    </button>
</template>
