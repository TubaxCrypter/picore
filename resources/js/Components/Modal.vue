<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);
const modalRef = ref(null);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.classList.add('overflow-hidden');
        } else {
            document.body.classList.remove('overflow-hidden');
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show && props.closeable) {
        close();
    }
};

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.classList.remove('overflow-hidden');
});

const modalWidth = computed(() => {
    const widthMap = {
        'sm': 'max-w-sm',
        'md': 'max-w-md',
        'lg': 'max-w-lg',
        'xl': 'max-w-xl',
        '2xl': 'max-w-2xl',
        '3xl': 'max-w-3xl',
        '4xl': 'max-w-4xl',
        '5xl': 'max-w-5xl',
        '6xl': 'max-w-6xl',
        '7xl': 'max-w-7xl',
    };
    
    return widthMap[props.maxWidth] || 'max-w-2xl';
});
</script>

<template>
    <Teleport to="body">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- Backdrop -->
            <div 
                class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 ease-in-out" 
                @click="closeable ? close() : null"
            ></div>
            
            <!-- Modal Dialog -->
            <div 
                ref="modalRef"
                :class="['modal-box bg-base-100 shadow-lg', modalWidth]"
                class="z-10 transform transition-all duration-300 ease-in-out"
            >
                <!-- Close Button (if closeable) -->
                <button 
                    v-if="closeable" 
                    @click="close" 
                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                >
                    ✕
                </button>
                
                <!-- Modal Content -->
                <div>
                    <slot></slot>
                </div>
            </div>
        </div>
    </Teleport>
</template>
