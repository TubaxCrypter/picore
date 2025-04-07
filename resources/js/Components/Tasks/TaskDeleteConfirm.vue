<script setup>
import { useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['close', 'deleted']);

const form = useForm({});

const deleteTask = () => {
    form.delete(route('tasks.destroy', { task: props.task.id }), {
        onSuccess: () => {
            emit('deleted');
            emit('close');
            window.location.reload();
        },
    });
};

const cancel = () => {
    emit('close');
};
</script>

<template>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-error">Görev Silme</h2>
            <button @click="cancel" class="btn btn-sm btn-circle btn-ghost">
                ✕
            </button>
        </div>

        <div class="divider"></div>

        <div class="py-4">
            <div class="flex items-center mb-4 text-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="ml-4">
                    <h3 class="text-lg font-bold">Görevi silmek istediğinize emin misiniz?</h3>
                    <p class="text-sm opacity-90">Bu işlem geri alınamaz.</p>
                </div>
            </div>
            
            <div class="bg-base-200 p-4 rounded-lg mb-6">
                <div class="font-medium">{{ props.task.title }}</div>
                <div class="text-sm text-base-content/70 mt-1 truncate" v-if="props.task.description" v-html="props.task.description.substring(0, 100) + (props.task.description.length > 100 ? '...' : '')"></div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="flex justify-end space-x-3">
            <SecondaryButton @click="cancel" :disabled="form.processing" class="btn btn-sm">
                Vazgeç
            </SecondaryButton>
            <DangerButton @click="deleteTask" :disabled="form.processing" class="btn btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Evet, Sil
            </DangerButton>
        </div>
    </div>
</template> 