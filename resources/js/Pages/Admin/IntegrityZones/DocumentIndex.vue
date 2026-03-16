<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Link, router, usePage, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon, DocumentIcon 
} from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    documents: any;
}>();

// --- Logika Modal & Notifikasi ---
const isModalOpen = ref(false);
const itemToDelete = ref<any>(null);
const openDeleteModal = (item: any) => { itemToDelete.value = item; isModalOpen.value = true; };
const closeDeleteModal = () => { isModalOpen.value = false; itemToDelete.value = null; };

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.zi.document.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
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
        setTimeout(() => { showNotification.value = false; }, 3000);
    }
}, { immediate: true });
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-bold text-black">Kelola Dokumen ZI</h1>
        <p class="mt-1 text-black">Manajemen daftar dokumen Zona Integritas FSTI ITK</p>
      </div>
      <div class="flex items-center gap-3 flex-shrink-0">
        <Link :href="route('admin.zi.document.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">
          <PlusIcon class="h-5 w-5" />
          Tambah Dokumen
        </Link>
      </div>
    </div>

    <div class="bg-white shadow-sm p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-black mb-4">Daftar Dokumen</h3>
      <div class="border rounded-lg overflow-x-auto">
        <table class="w-full min-w-full">
          <thead class="bg-[#CBDCEB]">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black">Judul Dokumen</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black">Tautan / File</th>
              <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-black w-40">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-if="documents.data.length > 0" v-for="item in documents.data" :key="item.id" class="hover:bg-gray-50">
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">{{ item.title }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black">
                <a :href="item.file_url" target="_blank" class="flex items-center gap-1 text-blue-600 hover:underline">
                    <DocumentIcon class="w-4 h-4" />
                    Lihat Dokumen
                </a>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                <div class="flex items-center justify-center gap-2">
                  <Link :href="route('admin.zi.document.edit', item.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                    <PencilSquareIcon class="h-4 w-4" />
                    Edit
                  </Link>
                  <span class="text-gray-300">|</span>
                  <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                    <TrashIcon class="h-4 w-4" />
                    Hapus
                  </button>
                </div>
              </td>
            </tr>
            <tr v-else>
              <td colspan="3" class="text-center py-4 text-gray-500">Belum ada dokumen ZI yang ditambahkan.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex items-center justify-between mt-4">
        <p v-if="documents.total > 0" class="text-sm text-black">
          Menampilkan <span class="font-medium">{{ documents.from }}</span> sampai <span class="font-medium">{{ documents.to }}</span> dari <span class="font-medium">{{ documents.total }}</span> hasil
        </p>
        <div class="flex items-center gap-1">
          <Link v-for="(link, index) in documents.links" :key="index" :href="link.url ?? '#'" v-html="link.label"
            :class="['px-3 py-1 text-sm rounded border border-gray-300', link.active ? 'bg-[#4682A9] text-white' : 'bg-[#CBDCEB] text-gray-800 hover:bg-gray-100', !link.url ? 'text-gray-400 cursor-not-allowed' : '']"
          />
        </div>
      </div>
    </div>
    
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity" @click.self="closeDeleteModal">
      <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-2xl transition-transform transform scale-95" :class="{'scale-100': isModalOpen}">
        <div class="flex flex-col items-center text-center">
          <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
            <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
          </div>
          <h2 class="text-2xl font-bold text-gray-800">Hapus Dokumen</h2>
          <p class="mt-2 text-gray-600">
            Apakah Anda yakin ingin menghapus dokumen <br>
            <span class="font-semibold">"{{ itemToDelete?.title }}"</span>? <br>Aksi ini tidak dapat dibatalkan.
          </p>
        </div>
        <div class="mt-8 flex justify-center gap-4">
          <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300">
            Batal
          </button>
          <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">
            Ya, Hapus
          </button>
        </div>
      </div>
    </div>
    
    <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="showNotification" class="fixed top-5 right-5 z-50">
            <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg">
                <CheckCircleIcon class="h-8 w-8" />
                <p class="font-semibold">{{ notificationMessage }}</p>
            </div>
        </div>
    </transition>

  </div>
</template>