<script setup>
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    task: {
        type: Object,
        default: () => ({})
    },
    errors: {
        type: Object,
        default: () => ({})
    },
    isSubmitting: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['submit', 'cancel', 'error']);

const form = ref({
    id: props.task.id || null,
    title: props.task.title || '',
    description: props.task.description || '',
    priority: props.task.priority || 'normal',
    status: props.task.status || 'pending',
    due_date: props.task.due_date || '',
    user_id: props.task.user_id || null
});

const handleSubmit = () => {
    // Boş değerleri temizle
    if (!form.value.description) form.value.description = null;
    if (!form.value.due_date) form.value.due_date = null;
    
    emit('submit', form.value);
};

const handleCancel = () => {
    emit('cancel');
};
</script>

<template>
    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto p-4">
            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div class="form-control w-full">
                    <label for="title" class="label">
                        <span class="label-text">Başlık</span>
                    </label>
                    <input 
                        id="title" 
                        v-model="form.title" 
                        type="text" 
                        class="input input-bordered w-full"
                        :class="{'input-error': errors.title}"
                        required
                    />
                    <InputError v-if="errors.title" :message="errors.title" class="mt-1" />
                </div>

                <div class="form-control w-full">
                    <label for="description" class="label">
                        <span class="label-text">Açıklama</span>
                    </label>
                    <textarea 
                        id="description" 
                        v-model="form.description" 
                        rows="3" 
                        class="textarea textarea-bordered w-full"
                        :class="{'textarea-error': errors.description}"
                    ></textarea>
                    <InputError v-if="errors.description" :message="errors.description" class="mt-1" />
                </div>

                <div class="form-control w-full">
                    <label for="priority" class="label">
                        <span class="label-text">Öncelik</span>
                    </label>
                    <select 
                        id="priority" 
                        v-model="form.priority" 
                        class="select select-bordered w-full"
                        :class="{'select-error': errors.priority}"
                        required
                    >
                        <option value="low">Düşük</option>
                        <option value="normal">Normal</option>
                        <option value="high">Yüksek</option>
                        <option value="urgent">Acil</option>
                    </select>
                    <InputError v-if="errors.priority" :message="errors.priority" class="mt-1" />
                </div>

                <div class="form-control w-full">
                    <label for="status" class="label">
                        <span class="label-text">Durum</span>
                    </label>
                    <select 
                        id="status" 
                        v-model="form.status" 
                        class="select select-bordered w-full"
                        :class="{'select-error': errors.status}"
                        required
                    >
                        <option value="pending">Beklemede</option>
                        <option value="in_progress">Devam Ediyor</option>
                        <option value="completed">Tamamlandı</option>
                        <option value="cancelled">İptal Edildi</option>
                    </select>
                    <InputError v-if="errors.status" :message="errors.status" class="mt-1" />
                </div>

                <div class="form-control w-full">
                    <label for="due_date" class="label">
                        <span class="label-text">Bitiş Tarihi</span>
                    </label>
                    <input 
                        id="due_date" 
                        v-model="form.due_date" 
                        type="date" 
                        class="input input-bordered w-full"
                        :class="{'input-error': errors.due_date}"
                    />
                    <InputError v-if="errors.due_date" :message="errors.due_date" class="mt-1" />
                </div>
            </form>
        </div>

        <div class="border-t border-base-300 p-4 flex justify-end space-x-2">
            <button @click="handleCancel" class="btn btn-ghost" :disabled="isSubmitting">
                İptal
            </button>
            <button @click="handleSubmit" class="btn btn-primary" :disabled="isSubmitting">
                <span v-if="isSubmitting" class="loading loading-spinner loading-xs mr-2"></span>
                {{ isSubmitting ? 'Kaydediliyor...' : 'Kaydet' }}
            </button>
        </div>
    </div>
</template> 