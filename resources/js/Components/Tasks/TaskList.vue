<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    tasks: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['view', 'edit', 'delete']);

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

const handleView = (task) => {
    emit('view', task);
};

const handleEdit = (task) => {
    emit('edit', task);
};

const handleDelete = (task) => {
    emit('delete', task);
};

const validTasks = computed(() => {
    console.log('Tasks prop:', props.tasks);
   
    return Array.isArray(props.tasks) ? props.tasks.filter(task => task && task.id) : 
           props.tasks?.data?.filter(task => task && task.id) || [];
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Öncelik</th>
                    <th>Durum</th>
                    <th>Bitiş Tarihi</th>
                    <th class="text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in validTasks" :key="task.id">
                    <td>{{ task.title }}</td>
                    <td>
                        <div class="badge" :class="priorityClasses[task.priority]">
                            {{ priorityLabels[task.priority] }}
                        </div>
                    </td>
                    <td>
                        <div class="badge" :class="statusClasses[task.status]">
                            {{ statusLabels[task.status] }}
                        </div>
                    </td>
                    <td>{{ formatDate(task.due_date) }}</td>
                    <td class="text-right">
                        <div class="flex justify-end space-x-1">
                            <button @click="handleView(task)" class="btn btn-ghost btn-xs" title="Görüntüle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button @click="handleEdit(task)" class="btn btn-ghost btn-xs" title="Düzenle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button @click="handleDelete(task)" class="btn btn-ghost btn-xs text-error" title="Sil">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr v-if="validTasks.length === 0">
                    <td colspan="5" class="text-center py-4">Henüz görev bulunmuyor.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template> 