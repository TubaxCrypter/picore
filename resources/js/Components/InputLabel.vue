<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="label">
        <span class="label-text font-medium" v-if="value">{{ value }}</span>
        <span class="label-text font-medium" v-else><slot /></span>
    </label>
</template>
