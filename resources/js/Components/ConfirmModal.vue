<script setup>
import { watch } from 'vue';

const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true
    },
    title: {
        type: String,
        required: true
    },
    message: {
        type: String,
        required: true
    },
    confirmText: {
        type: String,
        default: 'Onayla'
    },
    cancelText: {
        type: String,
        default: 'İptal'
    },
    confirmButtonClass: {
        type: String,
        default: 'btn-primary'
    }
});

const emit = defineEmits(['confirm', 'cancel', 'close']);

watch(() => props.isOpen, (value) => {
    if (value) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
});

const handleConfirm = () => {
    emit('confirm');
};

const handleCancel = () => {
    emit('cancel');
};

const handleClose = () => {
    emit('close');
};
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="handleClose"></div>
            
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ title }}
                    </h3>
                    
                    <p class="text-sm text-gray-500 mb-6">
                        {{ message }}
                    </p>
                    
                    <div class="flex justify-end space-x-3">
                        <button 
                            class="btn btn-ghost" 
                            @click="handleCancel"
                        >
                            {{ cancelText }}
                        </button>
                        
                        <button 
                            :class="['btn', confirmButtonClass]" 
                            @click="handleConfirm"
                        >
                            {{ confirmText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template> 