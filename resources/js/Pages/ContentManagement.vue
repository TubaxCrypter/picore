<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, reactive, computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import ContentModal from '@/Components/Content/ContentModal.vue';
import ContentView from '@/Components/Content/ContentView.vue';
import DeleteConfirmModal from '@/Components/Content/DeleteConfirmModal.vue';
import { usePage, Inertia } from '@inertiajs/vue3';

const page = usePage();
const props = defineProps({
    contents: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            meta: {
                total: 0,
                per_page: 10,
                current_page: 1,
                last_page: 1
            }
        })
    },
    categories: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({
            search: '',
            category: '',
            status: ''
        })
    }
});

// UI State
const contentModalOpen = ref(false);
const deleteModalOpen = ref(false);
const viewModalOpen = ref(false);
const modalMode = ref('create');
const selectedContent = ref(null);

// Filters
const formFilters = reactive({
    search: props.filters.search || '',
    category: props.filters.category || '',
    status: props.filters.status || ''
});

// Modal işlemleri
const openCreateModal = () => {
    modalMode.value = 'create';
    selectedContent.value = {};
    contentModalOpen.value = true;
};

const openEditModal = (content) => {
    modalMode.value = 'edit';
    selectedContent.value = content;
    contentModalOpen.value = true;
};

const openContentView = (content) => {
    selectedContent.value = content;
    viewModalOpen.value = true;
};

const openDeleteModal = (content) => {
    selectedContent.value = content;
    deleteModalOpen.value = true;
};

const closeModal = () => {
    contentModalOpen.value = false;
    deleteModalOpen.value = false;
    viewModalOpen.value = false;
    selectedContent.value = null;
};

// Filtreleme işlemi
const applyFilters = () => {
    Inertia.get(route('content.management'), formFilters, {
        preserveState: true,
        replace: true
    });
};

// Filtreleri temizleme
const clearFilters = () => {
    formFilters.search = '';
    formFilters.category = '';
    formFilters.status = '';
    applyFilters();
};

// Sayfalama işlemi
const goToPage = (page) => {
    Inertia.get(route('content.management'), {
        ...formFilters,
        page
    }, {
        preserveState: true,
        replace: true
    });
};

// Durum sınıfları
const getStatusClass = (status) => {
    const statusClasses = {
        'draft': 'bg-yellow-100 text-yellow-800',
        'review': 'bg-red-100 text-red-800',
        'planning': 'bg-blue-100 text-blue-800',
        'published': 'bg-green-100 text-green-800'
    };
    
    return statusClasses[status] || 'bg-gray-100 text-gray-800';
};

// Durum etiketleri
const getStatusLabel = (status) => {
    const statusLabels = {
        'draft': 'Taslak',
        'review': 'İnceleme',
        'planning': 'Planlama',
        'published': 'Yayında'
    };
    
    return statusLabels[status] || status;
};
</script>

<template>
    <Head title="İçerik Yönetimi" />

    <MainLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                İçerik Yönetimi
            </h2>
        </template>

        <div class="py-6">
            <!-- Filtreler -->
            <div class="bg-white rounded-lg shadow-sm mb-6 p-4 border border-gray-200">
                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Ara</label>
                        <input
                            id="search"
                            type="text"
                            v-model="formFilters.search"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-primary-200 focus:border-primary"
                            placeholder="Başlık veya içerik ara..."
                        />
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select
                            id="category"
                            v-model="formFilters.category"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-primary-200 focus:border-primary"
                        >
                            <option value="">Tüm Kategoriler</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                        <select
                            id="status"
                            v-model="formFilters.status"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-primary-200 focus:border-primary"
                        >
                            <option value="">Tüm Durumlar</option>
                            <option value="draft">Taslak</option>
                            <option value="review">İnceleme</option>
                            <option value="planning">Planlama</option>
                            <option value="published">Yayında</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-4 space-x-2">
                    <button
                        @click="clearFilters"
                        class="btn btn-ghost btn-sm"
                    >
                        Filtreleri Temizle
                    </button>
                    <button
                        @click="applyFilters"
                        class="btn btn-primary btn-sm"
                    >
                        Filtrele
                    </button>
                </div>
            </div>

            <!-- İçerik Listesi -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-lg">İçerikler</h3>
                    <button @click="openCreateModal" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Yeni İçerik
                    </button>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Başlık</th>
                                    <th scope="col" class="px-4 py-3">Kategori</th>
                                    <th scope="col" class="px-4 py-3">Durum</th>
                                    <th scope="col" class="px-4 py-3">Yazar</th>
                                    <th scope="col" class="px-4 py-3">Tarih</th>
                                    <th scope="col" class="px-4 py-3 text-right">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody v-if="contents.data && contents.data.length > 0">
                                <tr v-for="content in contents.data" :key="content.id" class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ content.title }}
                                    </td>
                                    <td class="px-4 py-3">{{ content.category ? content.category.name : '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span :class="[getStatusClass(content.status), 'text-xs font-medium px-2.5 py-0.5 rounded']">
                                            {{ getStatusLabel(content.status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ content.author ? content.author.name : '-' }}</td>
                                    <td class="px-4 py-3">{{ content.published_at || content.created_at }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <button @click="openContentView(content)" class="text-blue-600 hover:text-blue-900 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button @click="openEditModal(content)" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button @click="openDeleteModal(content)" class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        Herhangi bir içerik bulunamadı. Yeni bir içerik oluşturmak için "Yeni İçerik" butonuna tıklayın.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Sayfalama -->
                    <div v-if="contents.data && contents.data.length > 0" class="flex items-center justify-between mt-4">
                        <div class="text-sm text-gray-700">
                            <span>Toplam <span class="font-medium">{{ contents.meta.total }}</span> kayıttan 
                            <span class="font-medium">{{ contents.data.length }}</span> kayıt gösteriliyor</span>
                        </div>
                        <div class="flex space-x-2">
                            <button
                                v-for="(link, i) in contents.links"
                                :key="i"
                                @click="link.url ? goToPage(link.label) : null"
                                :class="[
                                    'px-3 py-1 border rounded-md text-sm',
                                    link.active 
                                        ? 'border-blue-500 text-white bg-blue-500 hover:bg-blue-600' 
                                        : 'border-gray-300 text-gray-500 bg-white hover:bg-gray-50',
                                    !link.url ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
                                ]"
                                :disabled="!link.url"
                            >
                                <span v-if="link.label === '&laquo; Previous'">&laquo; Önceki</span>
                                <span v-else-if="link.label === 'Next &raquo;'">Sonraki &raquo;</span>
                                <span v-else>{{ link.label }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>

    <!-- İçerik Ekleme/Düzenleme Modal -->
    <ContentModal
        :show="contentModalOpen"
        :mode="modalMode"
        :content="selectedContent"
        :categories="categories"
        @close="closeModal"
    />

    <!-- İçerik Görüntüleme Modal -->
    <ContentView
        :show="viewModalOpen"
        :content="selectedContent"
        @close="closeModal"
    />

    <!-- İçerik Silme Modal -->
    <DeleteConfirmModal
        :show="deleteModalOpen"
        :content="selectedContent"
        @close="closeModal"
    />
</template>