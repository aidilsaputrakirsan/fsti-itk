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

const search = ref('');
const statusFilter = ref(''); 
const departmentFilter = ref(''); 

const uniqueDepartments = computed(() => {
    const deps = props.studyPrograms.map(p => p.department);
    return [...new Set(deps)].filter(Boolean);
});

const filteredPrograms = computed(() => {
    return props.studyPrograms.filter(prodi => {
        const matchSearch = prodi.name.toLowerCase().includes(search.value.toLowerCase()) || 
                            (prodi.department && prodi.department.toLowerCase().includes(search.value.toLowerCase()));
        const matchStatus = statusFilter.value === '' ? true : prodi.degree === statusFilter.value;
        const matchDepartment = departmentFilter.value === '' ? true : prodi.department === departmentFilter.value;
        
        return matchSearch && matchStatus && matchDepartment;
    });
});

const currentPage = ref(1);
const itemsPerPage = 10;

watch([search, statusFilter, departmentFilter], () => {
    currentPage.value = 1;
});

const paginatedPrograms = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredPrograms.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredPrograms.value.length / itemsPerPage));

const formattedLinks = computed(() => {
    if (totalPages.value <= 1) return [];
    
    const links = [];
    
    links.push({
        url: currentPage.value > 1 ? '#' : null,
        label: 'Sebelumnya',
        active: false,
        page: currentPage.value - 1
    });

    for (let i = 1; i <= totalPages.value; i++) {
        if (i === 1 || i === totalPages.value || (i >= currentPage.value - 1 && i <= currentPage.value + 1)) {
            links.push({
                url: '#',
                label: String(i),
                active: i === currentPage.value,
                page: i
            });
        } else if (i === currentPage.value - 2 || i === currentPage.value + 2) {
            links.push({ url: null, label: '...', active: false, page: i });
        }
    }

    links.push({
        url: currentPage.value < totalPages.value ? '#' : null,
        label: 'Selanjutnya',
        active: false,
        page: currentPage.value + 1
    });

    return links;
});

const changePage = (pageNumber: number | null, event: Event) => {
    event.preventDefault();
    if (pageNumber && pageNumber >= 1 && pageNumber <= totalPages.value) {
        currentPage.value = pageNumber;
    }
};

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
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Program Studi</h1>
                <p class="mt-1 text-gray-600">Manajemen daftar Program Studi beserta sertifikat akreditasinya.</p>
            </div>
            <Link :href="route('admin.study-programs.create')" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" />
                Tambah Prodi
            </Link>
        </div>

        <div class="flex flex-col lg:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full lg:flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari Program Studi atau Jurusan..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors" 
                />
            </div>
            
            <div class="flex flex-col sm:flex-row w-full lg:w-auto items-center gap-4 flex-shrink-0">
                <div class="relative w-full sm:w-56">
                    <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                    <select v-model="departmentFilter" class="w-full rounded-lg border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-primary focus:ring-primary transition-colors">
                        <option value="">Semua Jurusan</option>
                        <option v-for="dep in uniqueDepartments" :key="dep" :value="dep">{{ dep }}</option>
                    </select>
                </div>

                <div class="relative w-full sm:w-48">
                    <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                    <select v-model="statusFilter" class="w-full rounded-lg border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-primary focus:ring-primary transition-colors">
                        <option value="">Semua Jenjang</option>
                        <option value="S1">S1 (Sarjana)</option>
                        <option value="S2">S2 (Magister)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Program Studi</h3>
            
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr>
                            <th scope="col" class="w-24">Jenjang</th>
                            <th scope="col">Nama Prodi</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col" class="text-center w-28">Sertifikat</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="paginatedPrograms.length > 0">
                            <tr v-for="prodi in paginatedPrograms" :key="prodi.id">
                                <td>
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider mb-1.5 bg-blue-100 text-blue-800">
                                        {{ prodi.degree }}
                                    </span>
                                </td>
                                <td>
                                    <div class="font-bold text-gray-900">{{ prodi.name }}</div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-700 font-medium">{{ prodi.department || '-' }}</div>
                                </td>
                                <td class="text-center">
                                    <span v-if="prodi.accreditation_certificate_image" class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">
                                        Tersedia
                                    </span>
                                    <span v-else class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-800">
                                        Kosong
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-3">
                                        <Link :href="route('admin.study-programs.edit', prodi.id)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
                                            <PencilSquareIcon class="h-4 w-4" /> Edit
                                        </Link>
                                        <span class="text-gray-300">|</span>
                                        <button @click="openDeleteModal(prodi)" type="button" class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors">
                                            <TrashIcon class="h-4 w-4" /> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td colspan="5" class="py-8 text-center text-gray-500 font-medium">Tidak ada program studi yang cocok dengan pencarian Anda.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="filteredPrograms.length > 0" class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan <span class="font-bold text-gray-900">{{ (currentPage - 1) * itemsPerPage + 1 }}</span> sampai <span class="font-bold text-gray-900">{{ Math.min(currentPage * itemsPerPage, filteredPrograms.length) }}</span> dari <span class="font-bold text-gray-900">{{ filteredPrograms.length }}</span> hasil
                </p>
                <p v-else></p>

                <div v-if="formattedLinks.length > 0" class="flex flex-wrap justify-center items-center gap-1.5">
                    <a 
                        v-for="(link, index) in formattedLinks" 
                        :key="index"
                        :href="link.url ?? '#'"
                        @click="changePage(link.page, $event)"
                        v-html="link.label"
                        :class="[
                            'px-3.5 py-1.5 rounded-lg border text-sm font-medium transition-colors',
                            link.active ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:text-primary',
                            !link.url && 'opacity-50 bg-gray-50 cursor-not-allowed hover:bg-gray-50 hover:text-gray-700'
                        ]"
                    />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeDeleteModal">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 sm:p-8 shadow-2xl transform transition-all scale-100">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Program Studi?</h2>
                <p class="mt-2 text-gray-600 text-center">
                    Apakah Anda yakin ingin menghapus data <br>
                    <span class="font-bold text-gray-900">"{{ itemToDelete?.degree }} {{ itemToDelete?.name }}"</span>?
                </p>
            </div>
            <div class="mt-8 flex flex-col-reverse sm:flex-row justify-center gap-3">
                <button @click="closeDeleteModal" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto">
                    Batal
                </button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2.5 font-bold text-white hover:bg-red-700 transition-colors shadow-sm w-full sm:w-auto">
                    Ya, Hapus
                </button>
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