<script setup>
import { ref, onMounted, watch } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import TaskList from '@/Components/Tasks/TaskList.vue';
import TaskForm from '@/Components/Tasks/TaskForm.vue';
import TaskView from '@/Components/Tasks/TaskView.vue';
import SideDrawer from '@/Components/SideDrawer.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useToast } from 'vue-toast-notification';
import ConfirmModal from '@/Components/ConfirmModal.vue';

const props = defineProps({
    tasks: {
        type: Object,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
    flash: Object
});

const drawer = ref(null);
const currentTask = ref(null);
const isEditing = ref(false);
const isDrawerOpen = ref(false);
const isSubmitting = ref(false);

const form = useForm({
    title: '',
    description: '',
    priority: 'normal',
    status: 'pending',
    due_date: '',
    user_id: props.auth.user.id,
});

const toast = useToast();
const page = usePage();

// Flash mesajlarını izle
watch(() => page.props.flash, (flash) => {
    if (flash && flash.success) {
        toast.success(flash.success, {
            position: 'top-right',
            duration: 3000,
        });
    }
    if (flash && flash.error) {
        toast.error(flash.error, {
            position: 'top-right',
            duration: 3000,
        });
    }
}, { deep: true });

// Form hatalarını izle
watch(() => form.errors, (errors) => {
    if (Object.keys(errors).length > 0) {
        // Hata mesajlarını toast ile göster
        Object.keys(errors).forEach(key => {
            toast.error(`${key}: ${errors[key]}`, {
                position: 'top-right',
                duration: 3000,
            });
        });
        isSubmitting.value = false;
    }
}, { deep: true });

// Sayfa yüklendiğinde drawer'ı kapat
onMounted(() => {
    isDrawerOpen.value = false;
    if (drawer.value) {
        drawer.value.close();
    }
});

const handleCreate = () => {
    currentTask.value = null;
    isEditing.value = false;
    form.reset();
    form.user_id = props.auth.user.id;
    isDrawerOpen.value = true;
    drawer.value?.open();
};

const handleEdit = (task) => {
    currentTask.value = task;
    isEditing.value = true;
    form.title = task.title;
    form.description = task.description || '';
    form.priority = task.priority;
    form.status = task.status;
    form.due_date = task.due_date || '';
    form.user_id = props.auth.user.id;
    isDrawerOpen.value = true;
    drawer.value?.open();
};

const handleView = (task) => {
    currentTask.value = task;
    isEditing.value = false;
    isDrawerOpen.value = true;
    drawer.value?.open();
};

// Silme işlemi için onay modalı
const showDeleteConfirm = ref(false);
const taskToDelete = ref(null);

const handleDeleteClick = (task) => {
    taskToDelete.value = task;
    showDeleteConfirm.value = true;
};

const handleDeleteConfirm = () => {
    if (!taskToDelete.value) return;
    
    const deleteForm = useForm({});
    deleteForm.delete(`/tasks/${taskToDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Görev başarıyla silindi.');
            showDeleteConfirm.value = false;
            taskToDelete.value = null;
            isDrawerOpen.value = false;
            drawer.value?.close();
        },
        onError: (errors) => {
            Object.keys(errors).forEach(key => {
                toast.error(errors[key]);
            });
        }
    });
};

const handleDeleteCancel = () => {
    showDeleteConfirm.value = false;
    taskToDelete.value = null;
};

const handleSubmit = (formData) => {
    // Form verilerini güncelle
    form.title = formData.title;
    form.description = formData.description;
    form.priority = formData.priority;
    form.status = formData.status;
    form.due_date = formData.due_date;
    form.user_id = props.auth.user.id;

    isSubmitting.value = true;
    
    if (formData.id) {
        form.put(`/tasks/${formData.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                isSubmitting.value = false;
                toast.success('Görev başarıyla güncellendi', {
                    position: 'top-right',
                    duration: 3000,
                });
                isDrawerOpen.value = false;
                drawer.value?.close();
                form.reset();
                currentTask.value = null;
                isEditing.value = false;
            },
            onError: (errors) => {
                if (errors.priority) {
                    toast.error('Geçersiz öncelik değeri: ' + errors.priority, {
                        position: 'top-right',
                        duration: 3000,
                    });
                } else {
                    toast.error('Görev güncellenirken bir hata oluştu', {
                        position: 'top-right',
                        duration: 3000,
                    });
                }
            },
            onFinish: () => {
                isSubmitting.value = false;
            }
        });
    } else {
        form.post('/tasks', {
            preserveScroll: true,
            onSuccess: () => {
                isSubmitting.value = false;
                toast.success('Görev başarıyla oluşturuldu', {
                    position: 'top-right',
                    duration: 3000,
                });
                isDrawerOpen.value = false;
                drawer.value?.close();
                form.reset();
                currentTask.value = null;
                isEditing.value = false;
            },
            onError: (errors) => {
                if (errors.priority) {
                    toast.error('Geçersiz öncelik değeri: ' + errors.priority, {
                        position: 'top-right',
                        duration: 3000,
                    });
                } else {
                    toast.error('Görev oluşturulurken bir hata oluştu', {
                        position: 'top-right',
                        duration: 3000,
                    });
                }
            },
            onFinish: () => {
                isSubmitting.value = false;
            }
        });
    }
};

const handleCancel = () => {
    isDrawerOpen.value = false;
    drawer.value?.close();
    form.reset();
    currentTask.value = null;
    isEditing.value = false;
    isSubmitting.value = false;
};

const handleFormError = (errors) => {
    Object.keys(errors).forEach(key => {
        form.setError(key, errors[key]);
    });
    
    // Hata mesajlarını toast ile göster
    Object.keys(errors).forEach(key => {
        toast.error(`${key}: ${errors[key]}`);
    });
};
</script>

<template>
    <Head title="Görevler" />

    <MainLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Görevler
                </h2>
                <PrimaryButton @click="handleCreate">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Yeni Görev
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-base-content">
                        <TaskList 
                            :tasks="tasks.data"
                            @view="handleView"
                            @edit="handleEdit"
                            @delete="handleDeleteClick"
                        />
                    </div>
                </div>
            </div>
        </div>

        <SideDrawer 
            ref="drawer" 
            :title="isEditing ? 'Görev Düzenle' : (currentTask ? 'Görev Detayı' : 'Yeni Görev')"
            :is-open="isDrawerOpen"
            @close="handleCancel"
            class="w-80 md:w-96"
        >
            <template #content>
                <TaskView
                    v-if="currentTask && !isEditing" 
                    :task="currentTask"
                    @close="handleCancel"
                    @edit="handleEdit"
                    @delete="handleDeleteClick"
                />
                <TaskForm 
                    v-else 
                    :task="currentTask || {}" 
                    :errors="form.errors" 
                    :is-submitting="isSubmitting"
                    @submit="handleSubmit"
                    @cancel="handleCancel"
                    @error="handleFormError"
                />
            </template>
        </SideDrawer>

        <!-- Silme onay modalı -->
        <ConfirmModal
            :is-open="showDeleteConfirm"
            title="Görevi Sil"
            message="Bu görevi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz."
            confirm-text="Sil"
            cancel-text="İptal"
            confirm-button-class="btn-error"
            @confirm="handleDeleteConfirm"
            @cancel="handleDeleteCancel"
            @close="handleDeleteCancel"
        />
    </MainLayout>
</template> 