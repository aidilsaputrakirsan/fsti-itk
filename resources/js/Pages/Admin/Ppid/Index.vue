<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon,
    MagnifyingGlassIcon, FunnelIcon, DocumentTextIcon, LinkIcon 
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
  documents: any;
  filters: any;
}>();

// --- Logika Filter & Pencarian ---
const search = ref(props.filters.search || '');
const jenis = ref(props.filters.jenis || '');

watch([search, jenis], debounce(() => {
    router.get(route('admin.ppid.index'), {
        search: search.value,
        jenis: jenis.value,
    }, { preserveState: true, replace: true });
}, 300));

// --- Logika Modal & Notifikasi Hapus ---
const isModalOpen = ref(false);
const itemToDelete = ref<any>(null);
const openDeleteModal = (item: any) => { itemToDelete.value = item; isModalOpen.value = true; };
const closeDeleteModal = () => { isModalOpen.value = false; itemToDelete.value = null; };
const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.ppid.destroy', itemToDelete.value.id), {
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
        <h1 class="text-3xl font-bold text-black">Kelola Dokumen PPID</h1>
        <p class="mt-1 text-black">Manajemen daftar informasi publik dan dokumen PPID Fakultas Sains dan Teknologi <br> Institut Teknologi Kalimantan</p>
      </div>
      <div class="flex items-center gap-3 flex-shrink-0">
        <Link :href="route('admin.ppid.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition">
          <PlusIcon class="h-5 w-5" />
          Tambah Dokumen
        </Link>
      </div>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <div class="relative flex-grow w-full md:w-auto">
            <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
            <input 
                v-model="search"
                type="text" 
                placeholder="Cari judul dokumen..." 
                class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition" 
            />
        </div>
        <div class="relative flex-shrink-0 w-full md:w-64">
            <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
            <select v-model="jenis" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition cursor-pointer">
                <option value="">Semua Jenis Informasi</option>
                <option value="Berkala">Informasi Berkala</option>
                <option value="Setiap Saat">Informasi Setiap Saat</option>
            </select>
        </div>
    </div>

    <div class="bg-white shadow-sm p-6 rounded-xl border border-gray-100">
      <h3 class="text-lg font-semibold text-black mb-4">Daftar Dokumen</h3>
      <div class="border rounded-lg overflow-x-auto">
        <table class="w-full min-w-full text-left">
          <thead class="bg-[#CBDCEB]">
            <tr>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black w-2/5">Judul Dokumen</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black w-1/4">Kategori Induk</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black text-center">Jenis</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black text-center">Tautan</th>
              <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-if="documents.data.length > 0" v-for="item in documents.data" :key="item.id" class="hover:bg-blue-50/50 transition-colors group">
              <td class="px-6 py-4 text-sm font-semibold text-gray-800 leading-snug">
                {{ item.judul_dokumen }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-600 leading-snug">
                {{ item.kategori?.nama_kategori || '-' }}
              </td>
              <td class="px-6 py-4 text-center">
                <span 
                    class="rounded-full px-3 py-1 text-xs font-semibold" 
                    :class="item.kategori?.jenis_informasi === 'Berkala' ? 'bg-indigo-100 text-indigo-700' : 'bg-teal-100 text-teal-700'"
                >
                    {{ item.kategori?.jenis_informasi || '-' }}
                </span>
              </td>
              <td class="px-6 py-4 text-center">
                <a v-if="item.file_url" :href="item.file_url" target="_blank" class="inline-flex items-center text-[#4682A9] hover:text-[#133E87] bg-gray-50 hover:bg-white px-3 py-1.5 rounded-md border border-gray-200 transition" title="Lihat Tautan">
                    <DocumentTextIcon v-if="item.file_url.includes('.pdf')" class="w-4 h-4 mr-1.5" />
                    <LinkIcon v-else class="w-4 h-4 mr-1.5" />
                    <span class="text-xs font-bold">Akses</span>
                </a>
                <span v-else class="text-xs text-gray-400 italic">Belum ada file</span>
              </td>
              <td class="px-6 py-4 text-sm font-medium text-center">
                <div class="flex items-center justify-center gap-3">
                  <Link :href="route('admin.ppid.edit', item.id)" class="flex items-center gap-1 text-[#4682A9] hover:text-[#133E87] transition">
                    <PencilSquareIcon class="h-5 w-5" />
                  </Link>
                  <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:text-red-700 transition">
                    <TrashIcon class="h-5 w-5" />
                  </button>
                </div>
              </td>
            </tr>
            <tr v-else>
              <td colspan="5" class="text-center py-8 text-gray-500">Belum ada dokumen yang ditambahkan.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex flex-col md:flex-row items-center justify-between mt-6 gap-4">
        <p v-if="documents.total > 0" class="text-sm text-gray-600">
          Menampilkan <span class="font-bold text-gray-900">{{ documents.from }}</span> sampai <span class="font-bold text-gray-900">{{ documents.to }}</span> dari <span class="font-bold text-gray-900">{{ documents.total }}</span> dokumen
        </p>
        <div class="flex items-center gap-1 overflow-x-auto">
          <Link v-for="(link, index) in documents.links" :key="index" :href="link.url ?? '#'" v-html="link.label"
            class="px-3 py-1.5 text-sm font-medium rounded-md border transition-colors"
            :class="[link.active ? 'bg-[#133E87] text-white border-[#133E87]' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50', !link.url ? 'text-gray-400 cursor-not-allowed bg-gray-50' : '']"
          />
        </div>
      </div>
    </div>
    
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity backdrop-blur-sm" @click.self="closeDeleteModal">
      <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl transition-transform transform scale-95" :class="{'scale-100': isModalOpen}">
        <div class="flex flex-col items-center text-center">
          <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-red-50 border-4 border-red-100">
            <ExclamationTriangleIcon class="h-8 w-8 text-red-500" />
          </div>
          <h2 class="text-2xl font-bold text-gray-900">Hapus Dokumen</h2>
          <p class="mt-2 text-gray-600 text-sm leading-relaxed">
            Apakah Anda yakin ingin menghapus dokumen <br>
            <span class="font-bold text-gray-900">"{{ itemToDelete?.judul_dokumen }}"</span>? Aksi ini akan menghapus file secara permanen.
          </p>
        </div>
        <div class="mt-8 flex justify-center gap-3">
          <button @click="closeDeleteModal" class="rounded-lg bg-white border border-gray-300 px-5 py-2.5 font-semibold text-gray-700 hover:bg-gray-50 transition">
            Batal
          </button>
          <button @click="confirmDelete" class="rounded-lg bg-[#DC645E] px-5 py-2.5 font-semibold text-white hover:bg-red-700 transition shadow-sm">
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
        <div v-if="showNotification" class="fixed bottom-10 right-10 z-50">
            <div class="flex items-center gap-3 rounded-xl bg-green-500 px-6 py-4 text-white shadow-xl">
                <CheckCircleIcon class="h-6 w-6" />
                <p class="font-semibold">{{ notificationMessage }}</p>
            </div>
        </div>
    </transition>

  </div>
</template>