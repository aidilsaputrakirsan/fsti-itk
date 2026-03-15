<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    kategoris: any[];
}>();

// Aksi Modal Hapus (Hanya Hapus yang pakai modal, sesuai standar layoutmu)
const isDeleteModalOpen = ref(false);
const itemToDelete = ref<any>(null);

const openDeleteModal = (item: any) => {
    itemToDelete.value = item;
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    itemToDelete.value = null;
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.kategori-ppid.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};

// Notifikasi
const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => { showNotification.value = false; }, 3000);
    }
}, { immediate: true });
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Kategori PPID</h1>
                <p class="mt-1 text-black">Manajemen kelompok/kategori dokumen untuk halaman PPID.</p>
            </div>
            <Link :href="route('admin.kategori-ppid.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition">
                <PlusIcon class="h-5 w-5" />
                Tambah Kategori
            </Link>
        </div>

<div class="bg-white shadow-sm p-6 rounded-xl border border-gray-100">
            <div class="mb-5">
                <h2 class="text-xl font-bold text-gray-800">Daftar Kategori Dokumen PPID</h2>
            </div>            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full text-left">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black w-16 text-center">No</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black">Nama Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black">Jenis Informasi</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black text-center">Urutan</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="kategoris.length > 0" v-for="(item, index) in kategoris" :key="item.id" class="hover:bg-blue-50/50 transition-colors group">
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ item.nama_kategori }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-xs font-semibold">
                                    {{ item.jenis_informasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ item.urutan }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="route('admin.kategori-ppid.edit', item.id)" class="text-[#4682A9] hover:text-[#133E87] transition">
                                        <PencilSquareIcon class="h-5 w-5" />
                                    </Link>
                                    <button @click="openDeleteModal(item)" class="text-[#DC645E] hover:text-red-700 transition">
                                        <TrashIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="5" class="text-center py-8 text-gray-500">Belum ada kategori yang ditambahkan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity backdrop-blur-sm">
            <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl text-center">
                <div class="mb-5 mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 border-4 border-red-100">
                    <ExclamationTriangleIcon class="h-8 w-8 text-red-500" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Kategori</h2>
                <p class="mt-2 text-gray-600 text-sm leading-relaxed">
                    Yakin ingin menghapus kategori <span class="font-bold">"{{ itemToDelete?.nama_kategori }}"</span>? <br>
                    <span class="text-red-600 font-semibold">Semua dokumen di dalamnya juga akan ikut terhapus!</span>
                </p>
                <div class="mt-8 flex justify-center gap-3">
                    <button @click="closeDeleteModal" class="rounded-lg bg-white border border-gray-300 px-5 py-2.5 font-semibold text-gray-700 hover:bg-gray-50">Batal</button>
                    <button @click="confirmDelete" class="rounded-lg bg-[#DC645E] px-5 py-2.5 font-semibold text-white hover:bg-red-700">Ya, Hapus</button>
                </div>
            </div>
        </div>

        <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="showNotification" class="fixed bottom-10 right-10 z-50 flex items-center gap-3 rounded-xl bg-green-500 px-6 py-4 text-white shadow-xl">
                <CheckCircleIcon class="h-6 w-6" />
                <p class="font-semibold">{{ notificationMessage }}</p>
            </div>
        </transition>
    </div>
</template>