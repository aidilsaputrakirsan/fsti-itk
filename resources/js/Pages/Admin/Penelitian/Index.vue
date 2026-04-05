<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon, 
    MagnifyingGlassIcon, FunnelIcon 
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';

defineOptions({ layout: AdminLayout });

// Mendefinisikan tipe data props yang diterima dari Controller
const props = defineProps<{ 
    penelitians: any; 
    filters: any; 
    prodis: { id: number; name: string }[];
}>();

// --- Logika Filter & Pencarian ---
const search = ref(props.filters.search || '');
const prodi = ref(props.filters.prodi || ''); // Menyimpan ID Prodi

watch([search, prodi], debounce(() => {
    router.get(route('admin.penelitian.index'), { 
        search: search.value, 
        prodi: prodi.value 
    }, { 
        preserveState: true, 
        replace: true 
    });
}, 300));

// --- Logika Modal Hapus & Notifikasi ---
const isModalOpen = ref(false);
const itemToDelete = ref<any | null>(null);

const openDeleteModal = (item: any) => { 
    itemToDelete.value = item; 
    isModalOpen.value = true; 
};

const closeDeleteModal = () => { 
    isModalOpen.value = false; 
    itemToDelete.value = null; 
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.penelitian.destroy', itemToDelete.value.id), { 
            onSuccess: () => closeDeleteModal() 
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
        <h1 class="text-3xl font-bold text-black">Kelola Daftar Penelitian</h1>
        <p class="mt-1 text-black">Manajemen daftar penelitian dosen untuk website Fakultas Sains dan Teknologi <br> Institut Teknologi Kalimantan</p>
      </div>
      <div class="flex items-center gap-3 flex-shrink-0">
      <Link :href="route('admin.penelitian.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition-opacity">
          <PlusIcon class="h-5 w-5" />
          Tambah Penelitian
        </Link>
      </div>
    </div>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="relative flex-grow">
            <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
            <input 
                v-model="search" 
                type="text" 
                placeholder="Cari judul penelitian atau nama dosen..." 
                class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
            />
        </div>
        <div class="relative flex-shrink-0 w-64">
            <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
            <select 
                v-model="prodi" 
                class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-blue-500 focus:ring-blue-500"
            >
                <option value="">Semua Program Studi</option>
                <option v-for="p in prodis" :key="p.id" :value="p.id">{{ p.name }}</option>
            </select>
        </div>
    </div>

    <div class="bg-white shadow-sm p-6 rounded-lg">
      <h3 class="text-lg font-semibold text-black mb-4">Daftar Penelitian</h3>
      <div class="border rounded-lg overflow-x-auto">
        <table class="w-full min-w-full">
          <thead class="bg-[#CBDCEB]">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-48">Nama Dosen</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black">Judul Penelitian</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-40">Program Studi</th>
              <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-black w-24">Tahun</th>
              <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-32">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-if="penelitians.data.length > 0" v-for="item in penelitians.data" :key="item.id" class="hover:bg-gray-50 transition-colors">
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">{{ item.nama_dosen }}</td>
              <td class="whitespace-pre-line px-6 py-4 text-sm text-black leading-relaxed">{{ item.judul }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black">
                <span class="rounded-full px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800">
                    {{ item.study_program?.name || '-' }}
                </span>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-black text-center">{{ item.tahun }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                <div class="flex items-center gap-2">
                 <Link :href="route('admin.penelitian.edit', item.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80 transition-opacity">
                    <PencilSquareIcon class="h-4 w-4" /> Edit
                  </Link>
                  <span class="text-gray-300">|</span>
                  <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80 transition-opacity">
                    <TrashIcon class="h-4 w-4" /> Hapus
                  </button>
                </div>
              </td>
            </tr>
            <tr v-else>
              <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data penelitian.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex items-center justify-between mt-4">
        <p v-if="penelitians.total > 0" class="text-sm text-black">
          Menampilkan <span class="font-medium">{{ penelitians.from }}</span> sampai <span class="font-medium">{{ penelitians.to }}</span> dari <span class="font-medium">{{ penelitians.total }}</span> hasil
        </p>
        <div class="flex items-center gap-1">
          <Link v-for="(link, index) in penelitians.links" :key="index" :href="link.url ?? '#'" v-html="link.label"
            :class="[
                'px-3 py-1 text-sm rounded border border-gray-300 transition-colors', 
                link.active ? 'bg-[#4682A9] text-white' : 'bg-[#CBDCEB] text-gray-800 hover:bg-gray-100', 
                !link.url ? 'text-gray-400 cursor-not-allowed' : ''
            ]"
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
          <h2 class="text-2xl font-bold text-gray-800">Hapus Penelitian</h2>
          <p class="mt-2 text-gray-600">
              Apakah Anda yakin ingin menghapus penelitian oleh <br>
              <span class="font-semibold">"{{ itemToDelete?.nama_dosen }}"</span>?
          </p>
        </div>
        <div class="mt-8 flex justify-center gap-4">
          <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300 transition-colors">
              Batal
          </button>
          <button @click="confirmDelete" class="rounded-lg bg-[#DC645E] px-6 py-2 font-semibold text-white hover:bg-red-700 transition-colors">
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