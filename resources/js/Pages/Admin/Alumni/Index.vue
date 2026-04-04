<script setup>
import { ref, watch, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { 
    MagnifyingGlassIcon, PlusIcon, PencilSquareIcon, TrashIcon, 
    ExclamationTriangleIcon, CheckCircleIcon, FunnelIcon 
} from '@heroicons/vue/24/outline';
import { throttle } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    alumnis: Object,
    filters: Object,
    prodis: Array,
    years: Array
});

const search = ref(props.filters.search || '');
const selectedProdi = ref(props.filters.prodi || '');
const selectedYear = ref(props.filters.year || '');

watch([search, selectedProdi, selectedYear], throttle(([newSearch, newProdi, newYear]) => {
    router.get(route('admin.alumni.index'), { 
        search: newSearch,
        prodi: newProdi,
        year: newYear
    }, { preserveState: true, replace: true });
}, 300));

// Modal Hapus Logic
const isModalOpen = ref(false);
const itemToDelete = ref(null);

const openDeleteModal = (item) => {
    itemToDelete.value = item;
    isModalOpen.value = true;
};
const closeDeleteModal = () => {
    isModalOpen.value = false;
    itemToDelete.value = null;
};
const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.alumni.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal()
        });
    }
};

// Flash Message Logic
const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => page.props.flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message;
        showNotification.value = true;
        setTimeout(() => { showNotification.value = false; }, 3000);
    }
}, { immediate: true });
</script>

<template>
    <Head title="Kelola Data Alumni" />
    <div>
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Data Alumni</h1>
                <p class="mt-1 text-black">Manajemen direktori kelulusan mahasiswa Fakultas Sains dan Teknologi <br> Institut Teknologi Kalimantan</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <Link :href="route('admin.alumni.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90">
                    <PlusIcon class="h-5 w-5" />
                    Tambah Alumni
                </Link>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow w-full">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search" 
                    type="text" 
                    placeholder="Cari nama atau NIM alumni..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9]" 
                />
            </div>
            <div class="relative flex-shrink-0 w-full md:w-64">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="selectedProdi" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <option value="">Semua Program Studi</option>
                    <option v-for="prodi in prodis" :key="prodi" :value="prodi">{{ prodi }}</option>
                </select>
            </div>
            <div class="relative flex-shrink-0 w-full md:w-48">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="selectedYear" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <option value="">Semua Tahun</option>
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Alumni</h3>
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black">NIM</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black">Nama Lengkap</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-48">Program Studi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-black w-32">Tahun Lulus</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-black w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="alumnis.data.length > 0" v-for="item in alumnis.data" :key="item.id" class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">{{ item.nim }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ item.name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800">{{ item.study_program }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black text-center">{{ item.graduation_year }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <Link :href="route('admin.alumni.edit', item.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data alumni.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="flex items-center justify-between mt-4">
                <p v-if="alumnis.total > 0" class="text-sm text-black">
                    Menampilkan <span class="font-medium">{{ alumnis.from }}</span> sampai <span class="font-medium">{{ alumnis.to }}</span> dari <span class="font-medium">{{ alumnis.total }}</span> hasil
                </p>
                <div class="flex items-center gap-1">
                    <Link 
                        v-for="(link, index) in alumnis.links" 
                        :key="index" 
                        :href="link.url ?? '#'" 
                        v-html="link.label"
                        :class="['px-3 py-1 text-sm rounded border border-gray-300', link.active ? 'bg-[#4682A9] text-white' : 'bg-[#CBDCEB] text-gray-800 hover:bg-gray-100', !link.url ? 'text-gray-400 cursor-not-allowed' : '']"
                    />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity" @click.self="closeDeleteModal">
      <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-2xl transition-transform transform scale-95" :class="{'scale-100': isModalOpen}">
        <div class="flex flex-col items-center text-center">
          <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
            <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
          </div>
          <h2 class="text-2xl font-bold text-gray-800">Hapus Data Alumni</h2>
          <p class="mt-2 text-gray-600">
            Apakah Anda yakin ingin menghapus data kelulusan milik <br>
            <span class="font-semibold">"{{ itemToDelete?.name }}"</span>? Aksi ini tidak dapat dibatalkan.
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
</template>