<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
// FIX: Gunakan warna primary dari config untuk ikon tambah
import { PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });
defineProps({ services: Object });

const isModalOpen = ref(false);
const itemToDelete = ref(null);

const openDeleteModal = (item) => { itemToDelete.value = item; isModalOpen.value = true; };
const closeDeleteModal = () => { isModalOpen.value = false; itemToDelete.value = null; };
const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.internal-services.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-bold text-black">Kelola Portal Layanan</h1>
        <p class="mt-1 text-black">Manajemen tautan cepat untuk mahasiswa FSTI.</p>
      </div>
      <Link :href="route('admin.internal-services.create')" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-opacity-90 transition">
        <PlusIcon class="h-5 w-5" /> Tambah Layanan
      </Link>
    </div>

    <div class="bg-white shadow-sm p-6 rounded-lg border border-gray-100">
      <h2 class="text-lg font-bold text-black mb-4">Daftar Layanan</h2>
      
      <div class="overflow-x-auto rounded-lg border">
        <table class="w-full min-w-full text-sm text-left">
          <thead class="bg-[#CBDCEB] text-black">
            <tr>
              <th class="px-6 py-4 font-bold uppercase tracking-wider">Nama Layanan</th>
              <th class="px-6 py-4 font-bold uppercase tracking-wider">URL Tautan</th>
              <th class="px-6 py-4 font-bold uppercase tracking-wider">Deskripsi Singkat</th>
              <th class="px-6 py-4 font-bold uppercase tracking-wider w-32">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="item in services.data" :key="item.id" class="hover:bg-gray-50 transition">
              <td class="px-6 py-4 font-semibold text-gray-800">{{ item.name }}</td>
              <td class="px-6 py-4 text-blue-600 truncate max-w-[200px]"><a :href="item.link_url" target="_blank" class="hover:underline">{{ item.link_url }}</a></td>
              <td class="px-6 py-4 text-gray-500 truncate max-w-[250px]">{{ item.description || '-' }}</td>
              <td class="px-6 py-4 font-medium flex gap-3">
                <Link :href="route('admin.internal-services.edit', item.id)" class="text-primary hover:opacity-70 flex items-center gap-1"><PencilSquareIcon class="w-4 h-4"/> Edit</Link>
                <button @click="openDeleteModal(item)" class="text-red-500 hover:opacity-70 flex items-center gap-1"><TrashIcon class="w-4 h-4"/> Hapus</button>
              </td>
            </tr>
            <tr v-if="services.data.length === 0">
              <td colspan="4" class="text-center py-8 text-gray-500">Belum ada layanan yang ditambahkan.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="closeDeleteModal">
      <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl">
        <ExclamationTriangleIcon class="w-16 h-16 text-red-500 mx-auto mb-4 bg-red-50 rounded-full p-3" />
        <h2 class="text-xl font-bold text-gray-800 mb-2">Hapus Layanan?</h2>
        <p class="text-gray-500 text-sm mb-8">Tautan "{{ itemToDelete?.name }}" akan dihapus permanen.</p>
        <div class="flex justify-center gap-3">
          <button @click="closeDeleteModal" class="px-6 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 transition">Batal</button>
          <button @click="confirmDelete" class="px-6 py-2 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</template>