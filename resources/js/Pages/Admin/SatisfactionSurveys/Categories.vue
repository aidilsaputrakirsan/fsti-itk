<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { Link, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    categories: Array<{ id: number; name: string; is_active: boolean; created_at: string; }>;
}>();

// Form Create & Edit
const form = useForm({
    id: null as number | null,
    name: '',
    is_active: true
});

const isModalOpen = ref(false);
const modalMode = ref<'create' | 'edit'>('create');

const openCreateModal = () => {
    modalMode.value = 'create';
    form.reset();
    form.id = null;
    isModalOpen.value = true;
};

const openEditModal = (category: any) => {
    modalMode.value = 'edit';
    form.id = category.id;
    form.name = category.name;
    form.is_active = category.is_active;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const submitForm = () => {
    if (modalMode.value === 'create') {
        form.post(route('admin.survey-categories.store'), { onSuccess: () => closeModal() });
    } else {
        form.put(route('admin.survey-categories.update', form.id as number), { onSuccess: () => closeModal() });
    }
};

// Modal Delete
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

// Notification
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
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Aspek Penilaian</h1>
                <p class="mt-1 text-black">Atur kategori atau aspek layanan yang akan dinilai pada Survei Kepuasan Publik.</p>
            </div>
            <div class="flex gap-2">
                <Link :href="route('admin.satisfaction-surveys.index')" class="flex items-center gap-2 rounded-lg bg-white border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 flex-shrink-0 transition-colors">
                    Kembali
                </Link>
                <button @click="openCreateModal" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0 transition-colors">
                    <PlusIcon class="h-5 w-5" /> Tambah Aspek
                </button>
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Aspek Layanan</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Nama Aspek Penilaian</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-black">Status Publikasi</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="categories.length > 0" v-for="category in categories" :key="category.id" class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">{{ category.name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span v-if="category.is_active" class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">Aktif</span>
                                <span v-else class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-800">Nonaktif</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openEditModal(category)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(category.id)" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="3" class="text-center py-4 text-gray-500">Belum ada aspek penilaian yang ditambahkan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="closeModal">
        <div class="w-full max-w-lg bg-white rounded-lg shadow-xl flex flex-col">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50 rounded-t-lg">
                <h2 class="text-lg font-bold text-gray-800">{{ modalMode === 'create' ? 'Tambah Aspek Penilaian' : 'Edit Aspek Penilaian' }}</h2>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors"><XMarkIcon class="h-5 w-5" /></button>
            </div>
            <form @submit.prevent="submitForm">
                <div class="p-6 space-y-4">
                    
                    <div class="bg-blue-50 border border-blue-100 p-3 rounded-lg flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-xs text-blue-800 leading-relaxed">
                            <b>Aturan Pengisian:</b> Nama aspek harus jelas dan padat. Jika status diatur menjadi <b>Aktif</b>, aspek ini akan otomatis muncul sebagai opsi pilihan di formulir Survei Publik.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Aspek Layanan <span class="text-red-500">*</span></label>
                        <input v-model="form.name" type="text" required placeholder="Cth: Kualitas Konten Website" class="w-full rounded-lg border border-gray-300 py-2.5 px-4 text-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-20" />
                    </div>
                    <div v-if="modalMode === 'edit'">
                        <label class="flex items-center gap-2 cursor-pointer mt-2">
                            <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-[#4682A9] focus:ring-[#4682A9]">
                            <span class="text-sm font-medium text-gray-700">Aktifkan (Tampilkan di Formulir Publik)</span>
                        </label>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-3 rounded-b-lg">
                    <button type="button" @click="closeModal" class="rounded-lg bg-gray-200 px-4 py-2 font-semibold text-gray-800 hover:bg-gray-300">Batal</button>
                    <button type="submit" :disabled="form.processing" class="rounded-lg bg-[#133E87] px-4 py-2 font-semibold text-white hover:bg-opacity-90 disabled:opacity-50">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="closeDeleteModal">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl p-6">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Hapus Aspek?</h2>
                <p class="mt-2 text-gray-600">Tindakan ini tidak dapat dibatalkan. Pastikan aspek ini sudah tidak relevan lagi.</p>
            </div>
            <div class="mt-8 flex justify-center gap-4">
                <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300">Batal</button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div v-if="showNotification" class="fixed top-5 right-5 z-50 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg">
            <CheckCircleIcon class="h-8 w-8" />
            <p class="font-semibold">{{ notificationMessage }}</p>
        </div>
    </div>
</template>