<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    MagnifyingGlassIcon, 
    PlusIcon, 
    FunnelIcon,
    PencilSquareIcon,
    TrashIcon,
    ExclamationTriangleIcon,
    CheckCircleIcon,
} from '@heroicons/vue/24/outline';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    studyPrograms: Array<any>;
}>();

// --- Logika Filter & Search Lokal ---
const search = ref('');
const statusFilter = ref(''); // Untuk Jenjang (S1/S2)
const departmentFilter = ref(''); // Untuk Jurusan

// Otomatis mengambil daftar jurusan yang unik dari database
const uniqueDepartments = computed(() => {
    const deps = props.studyPrograms.map(p => p.department);
    return [...new Set(deps)].filter(Boolean); // Menghapus duplikasi dan data kosong
});

// Menyaring data berdasarkan Pencarian, Jenjang, DAN Jurusan
const filteredPrograms = computed(() => {
    return props.studyPrograms.filter(prodi => {
        const matchSearch = prodi.name.toLowerCase().includes(search.value.toLowerCase()) || 
                            (prodi.department && prodi.department.toLowerCase().includes(search.value.toLowerCase()));
        
        const matchStatus = statusFilter.value === '' ? true : prodi.degree === statusFilter.value;
        
        const matchDepartment = departmentFilter.value === '' ? true : prodi.department === departmentFilter.value;
        
        return matchSearch && matchStatus && matchDepartment;
    });
});

// --- Logika Modal Delete ---
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
        router.delete(route('admin.study-programs.destroy', itemToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => closeDeleteModal(),
        });
    }
};

// --- Logika Notifikasi Flash ---
const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => {
            showNotification.value = false;
        }, 3000);
    }
}, { immediate: true });
</script>

<template>
    <div>
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Program Studi</h1>
                <p class="mt-1 text-gray-600">Manajemen daftar Program Studi beserta sertifikat akreditasinya</p>
            </div>
            <Link :href="route('admin.study-programs.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0 transition-colors">
                <PlusIcon class="h-5 w-5" />
                Tambah Prodi
            </Link>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow w-full">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari Program Studi atau Jurusan..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] transition-all" 
                />
            </div>
            
            <div class="relative flex-shrink-0 w-full md:w-64">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="departmentFilter" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-[#4682A9] focus:ring-[#4682A9] transition-all">
                    <option value="">Semua Jurusan</option>
                    <option v-for="dep in uniqueDepartments" :key="dep" :value="dep">{{ dep }}</option>
                </select>
            </div>

            <div class="relative flex-shrink-0 w-full md:w-48">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="statusFilter" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-[#4682A9] focus:ring-[#4682A9] transition-all">
                    <option value="">Semua Jenjang</option>
                    <option value="S1">S1 (Sarjana)</option>
                    <option value="S2">S2 (Magister)</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg border border-gray-100">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Program Studi</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full text-left">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black w-24">Jenjang</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black">Nama Prodi</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black">Jurusan</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black">Profil Ringkas</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black text-center w-28">Sertifikat</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-black text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-if="filteredPrograms.length > 0" v-for="prodi in filteredPrograms" :key="prodi.id" class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="rounded-md px-2.5 py-1 text-xs font-bold bg-blue-100 text-[#4682A9]">{{ prodi.degree }}</span>
                            </td>
                            
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900">{{ prodi.name }}</td>
                            
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ prodi.department || '-' }}
                            </td>
                            
                            <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-[200px]">
                                {{ prodi.description ? prodi.description.substring(0, 50) + '...' : '-' }}
                            </td>
                            
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-center">
                                <span v-if="prodi.accreditation_certificate_image" class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Tersedia
                                </span>
                                <span v-else class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 ring-1 ring-inset ring-red-600/10">
                                    Kosong
                                </span>
                            </td>
                            
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="route('admin.study-programs.edit', prodi.id)" class="text-[#4682A9] hover:opacity-80 bg-blue-50 hover:bg-blue-100 p-1.5 rounded transition-colors" title="Edit">
                                        <PencilSquareIcon class="h-5 w-5" />
                                    </Link>
                                    <button @click="openDeleteModal(prodi)" class="text-[#DC645E] hover:opacity-80 bg-red-50 hover:bg-red-100 p-1.5 rounded transition-colors" title="Hapus">
                                        <TrashIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr v-else>
                            <td colspan="6" class="text-center py-10 text-gray-500 bg-gray-50/50 rounded-b-lg">
                                <p class="font-medium text-base">Tidak ada program studi yang ditemukan.</p>
                                <p class="text-sm mt-1">Coba sesuaikan kata kunci pencarian atau filter Anda.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-5">
                <p class="text-sm text-gray-600 font-medium">
                    Menampilkan total <span class="font-bold text-gray-900">{{ filteredPrograms.length }}</span> program studi
                </p>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl transform transition-all" data-aos="zoom-in" data-aos-duration="200">
            <div class="flex flex-col items-center text-center">
                <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-red-50 border-8 border-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-[#DC645E]" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Program Studi?</h2>
                <p class="mt-3 text-gray-600 leading-relaxed">
                    Anda akan menghapus <br/>
                    <span class="font-bold text-gray-900 text-lg">{{ itemToDelete?.degree }} {{ itemToDelete?.name }}</span>.<br/> 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="mt-8 flex justify-center gap-3">
                <button @click="closeDeleteModal" class="rounded-xl bg-gray-100 px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-200 transition-colors w-full">
                    Batal
                </button>
                <button @click="confirmDelete" class="rounded-xl bg-[#DC645E] px-6 py-2.5 font-bold text-white hover:bg-red-700 transition-colors w-full shadow-sm">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    
    <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="showNotification" class="fixed bottom-10 right-10 z-[60]">
            <div class="flex items-center gap-4 rounded-xl bg-green-600 px-6 py-4 text-white shadow-2xl border border-green-500">
                <CheckCircleIcon class="h-8 w-8 text-green-100" />
                <p class="font-bold text-lg tracking-wide">{{ notificationMessage }}</p>
            </div>
        </div>
    </transition>
</template>