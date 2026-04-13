<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Link, useForm, router, usePage, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon, XMarkIcon, ArrowLeftIcon 
} from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    categories: Array<{ id: number; name: string; is_active: boolean; created_at: string; }>;
}>();

const form = useForm({
    id: null as number | null,
    name: '',
    is_active: true
});

const isModalOpen = ref(false);
const modalMode = ref<'create' | 'edit'>('create');

const openCreateModal = () => {
    modalMode.value = 'create';
    form.clearErrors();
    form.reset();
    form.id = null;
    isModalOpen.value = true;
};

const openEditModal = (category: any) => {
    modalMode.value = 'edit';
    form.clearErrors();
    form.id = category.id;
    form.name = category.name;
    form.is_active = category.is_active;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
    form.clearErrors();
};

const submitForm = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) {
        form.setError('name', 'Nama aspek penilaian wajib diisi.');
        hasError = true;
    }

    if (hasError) return;

    if (modalMode.value === 'create') {
        form.post(route('admin.survey-categories.store'), { onSuccess: () => closeModal() });
    } else {
        form.put(route('admin.survey-categories.update', form.id as number), { onSuccess: () => closeModal() });
    }
};

const isDeleteModalOpen = ref(false);
const categoryToDelete = ref<number | null>(null);

const openDeleteModal = (id: number) => {
    categoryToDelete.value = id;
    isDeleteModalOpen.value = true;
};
const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    categoryToDelete.value = null;
};
const confirmDelete = () => {
    if (categoryToDelete.value) {
        router.delete(route('admin.survey-categories.destroy', categoryToDelete.value), { onSuccess: () => closeDeleteModal() });
    }
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => showNotification.value = false, 3000);
    }
}, { immediate: true });
</script>

<template>
    <div>
        <Head title="Kelola Aspek Penilaian" />

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <Link :href="route('admin.satisfaction-surveys.index')" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-4">
                    <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar Survei
                </Link>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Aspek Penilaian</h1>
                <p class="mt-1 text-gray-600">Atur kategori atau aspek layanan yang akan dinilai pada formulir Survei Kepuasan.</p>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <button @click="openCreateModal" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover flex-shrink-0 transition-colors">
                    <PlusIcon class="h-5 w-5 stroke-2" /> Tambah Aspek
                </button>
            </div>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Aspek Layanan</h3>
            
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[600px]">
                    <thead>
                        <tr>
                            <th scope="col" class="w-16 text-center">No</th>
                            <th scope="col">Nama Aspek Penilaian</th>
                            <th scope="col" class="text-center w-40">Status Publikasi</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="categories.length > 0" v-for="(category, index) in categories" :key="category.id">
                            <td class="text-center font-medium text-gray-500">
                                {{ index + 1 }}
                            </td>
                            <td>
                                <div class="font-bold text-gray-900">{{ category.name }}</div>
                            </td>
                            <td class="text-center">
                                <span v-if="category.is_active" class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">Aktif</span>
                                <span v-else class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">Nonaktif</span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <button @click="openEditModal(category)" type="button" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(category.id)" type="button" class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="4" class="py-8 text-center text-gray-500 font-medium">Belum ada aspek penilaian yang ditambahkan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeModal">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl flex flex-col transform transition-all scale-100">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50 rounded-t-2xl">
                <h2 class="text-xl font-bold text-gray-900">{{ modalMode === 'create' ? 'Tambah Aspek Penilaian' : 'Edit Aspek Penilaian' }}</h2>
                <button @click="closeModal" type="button" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-200">
                    <XMarkIcon class="h-6 w-6" />
                </button>
            </div>
            <form @submit.prevent="submitForm" novalidate>
                <div class="p-6 sm:p-8 space-y-6">
                    
                    <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl flex items-start gap-3">
                        <ExclamationTriangleIcon class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5 stroke-2" />
                        <p class="text-xs text-blue-800 leading-relaxed">
                            <span class="font-bold block mb-1">Aturan Pengisian:</span> 
                            Nama aspek harus jelas dan padat. Jika status diatur menjadi <b>Aktif</b>, aspek ini akan otomatis muncul sebagai opsi pilihan di formulir Survei Publik.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Nama Aspek Layanan <span class="text-red-600">*</span></label>
                        <input v-model="form.name" type="text" required placeholder="Contoh: Kualitas Konten Website" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                        />
                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>
                    
                    <div v-if="modalMode === 'edit'">
                        <label class="block text-sm font-bold text-gray-800 mb-2">Status Publikasi</label>
                        <label class="relative inline-flex items-center cursor-pointer mt-1">
                            <input type="checkbox" v-model="form.is_active" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            <span class="ml-3 text-sm font-bold text-gray-700">{{ form.is_active ? 'Aktif (Ditampilkan)' : 'Nonaktif (Disembunyikan)' }}</span>
                        </label>
                    </div>
                </div>
                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 flex flex-col-reverse sm:flex-row justify-end gap-3 rounded-b-2xl">
                    <button type="button" @click="closeModal" class="w-full sm:w-auto rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">Batal</button>
                    <button type="submit" :disabled="form.processing" class="w-full sm:w-auto rounded-lg bg-primary px-8 py-2.5 font-bold text-white hover:bg-primary-hover shadow-sm transition-colors disabled:opacity-50">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeDeleteModal">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 sm:p-8 shadow-2xl transform transition-all scale-100">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Aspek?</h2>
                <p class="mt-2 text-gray-600 text-center">Tindakan ini tidak dapat dibatalkan. Pastikan aspek ini sudah tidak relevan lagi.</p>
            </div>
            <div class="mt-8 flex flex-col-reverse sm:flex-row justify-center gap-3">
                <button @click="closeDeleteModal" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto">Batal</button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2.5 font-bold text-white hover:bg-red-700 transition-colors shadow-sm w-full sm:w-auto">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div v-if="showNotification" class="fixed top-5 right-5 sm:top-8 sm:right-8 z-50">
        <div class="flex items-center gap-3 rounded-xl bg-green-600 px-5 py-4 text-white shadow-xl">
            <CheckCircleIcon class="h-6 w-6" />
            <p class="font-bold text-sm tracking-wide">{{ notificationMessage }}</p>
        </div>
    </div>
</template>