<script setup>
import { computed } from 'vue';

const props = defineProps({
    task: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close', 'edit', 'delete']);

const priorityClasses = {
    low: 'badge-info',
    normal: 'badge-warning',
    high: 'badge-error',
    urgent: 'badge-error'
};

const priorityLabels = {
    low: 'Düşük',
    normal: 'Normal',
    high: 'Yüksek',
    urgent: 'Acil'
};

const statusClasses = {
    pending: 'badge-warning',
    in_progress: 'badge-info',
    completed: 'badge-success',
    cancelled: 'badge-error'
};

const statusLabels = {
    pending: 'Beklemede',
    in_progress: 'Devam Ediyor',
    completed: 'Tamamlandı',
    cancelled: 'İptal Edildi'
};

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('tr-TR');
};

const handleEdit = () => {
    emit('edit', props.task);
};

const handleDelete = () => {
    emit('delete', props.task);
};

const handleClose = () => {
    emit('close');
};
</script>

<template>
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto p-4">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ task.title }}</h3>
                <div class="flex space-x-2 mb-4">
                    <div class="badge" :class="priorityClasses[task.priority]">
                        {{ priorityLabels[task.priority] }}
                    </div>
                    <div class="badge" :class="statusClasses[task.status]">
                        {{ statusLabels[task.status] }}
                    </div>
                </div>
                <div class="text-sm text-gray-500 mb-2">
                    <span class="font-medium">Bitiş Tarihi:</span> {{ formatDate(task.due_date) }}
                </div>
            </div>

            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Açıklama</h4>
                <div class="text-sm text-gray-600 whitespace-pre-wrap">
                    {{ task.description || 'Açıklama bulunmuyor.' }}
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 p-4 flex justify-end space-x-2">
            <button @click="handleClose" class="btn btn-ghost">
                Kapat
            </button>
            <button @click="handleEdit" class="btn btn-primary">
                Düzenle
            </button>
            <button @click="handleDelete" class="btn btn-error">
                Sil
            </button>
        </div>
    </div>
</template> 