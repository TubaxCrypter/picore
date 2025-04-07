<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const drawer = ref(null);

const open = () => {
    if (drawer.value) {
        drawer.value.checked = true;
    }
};

const close = () => {
    if (drawer.value) {
        drawer.value.checked = false;
    }
};

// isOpen prop'u değiştiğinde drawer'ı aç/kapat
watch(() => props.isOpen, (newValue) => {
    if (newValue) {
        open();
    } else {
        close();
    }
}, { immediate: true });

// Bileşen yüklendiğinde drawer'ı kapat
onMounted(() => {
    close();
});

defineExpose({
    open,
    close,
});
</script>

<template>
    <div class="drawer drawer-end">
        <input 
            id="drawer" 
            type="checkbox" 
            class="drawer-toggle" 
            ref="drawer"
            @change="(e) => !e.target.checked && emit('close')"
        />
        <div class="drawer-content">
            <slot></slot>
        </div>
        <div class="drawer-side z-50">
            <label for="drawer" class="drawer-overlay"></label>
            <div class="menu p-4 w-96 min-h-full bg-base-200 text-base-content overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">{{ title }}</h3>
                    <button @click="close" class="btn btn-ghost btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="divider"></div>

                <div class="p-4">
                    <slot name="content"></slot>
                </div>
            </div>
        </div>
    </div>
</template> 