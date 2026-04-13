<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { 
    MagnifyingGlassIcon, 
    PlusIcon, 
    PencilSquareIcon, 
    TrashIcon, 
    ExclamationTriangleIcon, 
    CheckCircleIcon,
    FunnelIcon
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';
import dayjs from 'dayjs';
import 'dayjs/locale/id';

dayjs.locale('id');
defineOptions({ layout: AdminLayout });

const props = defineProps<{
    activities: any;
    filters: any;
    availableYears: any[];
}>();

const search = ref(props.filters?.search || '');
const year = ref(props.filters?.year || '');

watch([search, year], debounce(() => {
    router.get(route('admin.kegiatan-mahasiswa.index'), { 
        search: search.value,
        year: year.value === '' ? null : year.value
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const formattedLinks = computed(() => {
    if (!props.activities?.links) return [];
    
    const links = props.activities.links.map((link: any) => {
        let label = link.label;
        if (label.includes('Previous') || label.includes('&laquo;')) label = 'Sebelumnya';
        if (label.includes('Next') || label.includes('&raquo;')) label = 'Selanjutnya';
        return { ...link, label };
    });

    if (links.length <= 7) return links;

    const activeIndex = links.findIndex((l: any) => l.active);
    const result = [];
    
    result.push(links[0]);

    links.forEach((link: any, index: number) => {
        if (index === 0 || index === links.length - 1) return;

        if (
            index === 1 || 
            index === links.length - 2 ||
            (index >= activeIndex - 1 && index <= activeIndex + 1)
        ) {
            result.push(link);
        } else if (
            index === activeIndex - 2 || 
            index === activeIndex + 2
        ) {
            result.push({ url: null, label: '...', active: false });
        }
    });

    result.push(links[links.length - 1]);
    return result;
});

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
        router.delete(route('admin.kegiatan-mahasiswa.destroy', itemToDelete.value.id), {
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
        setTimeout(() => showNotification.value = false, 3000);
    }
}, { immediate: true });

const formatDate = (dateString: string) => {
    return dayjs(dateString).format('DD MMM YYYY');
};
</script>

<template>
    <div>
        <Head title="Kelola Kegiatan Mahasiswa" />

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Kegiatan Mahasiswa</h1>
                <p class="mt-1 text-gray-600">Manajemen daftar agenda dan aktivitas kemahasiswaan FSTI ITK.</p>
            </div>
            <Link :href="route('admin.kegiatan-mahasiswa.create')" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" />
                Tambah Kegiatan
            </Link>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full sm:flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari judul atau penyelenggara..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors" 
                />
            </div>
            
            <div class="relative w-full sm:w-56 flex-shrink-0">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="year" class="w-full rounded-lg border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-primary focus:ring-primary transition-colors cursor-pointer">
                    <option value="">Semua Tahun</option>
                    <option v-for="y in availableYears" :key="y" :value="y">{{ y }}</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Kegiatan</h3>
            
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr>
                            <th scope="col">Judul Kegiatan</th>
                            <th scope="col">Penyelenggara</th>
                            <th scope="col" class="w-48">Tanggal</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="activities.data && activities.data.length > 0" v-for="item in activities.data" :key="item.id">
                            <td>
                                <div class="font-bold text-gray-900">{{ item.title }}</div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    {{ item.location || 'Lokasi belum ditentukan' }}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm font-medium text-gray-700">{{ item.organizer || '-' }}</div>
                            </td>
                            <td>
                                <div class="text-sm font-bold text-gray-900">{{ formatDate(item.start_date) }}</div>
                                <div v-if="item.end_date" class="text-xs text-gray-500 mt-0.5 font-medium">s/d {{ formatDate(item.end_date) }}</div>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="route('admin.kegiatan-mahasiswa.edit', item.id)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="4" class="py-8 text-center text-gray-500 font-medium">Tidak ada kegiatan yang ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="activities.total > 0" class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan <span class="font-bold text-gray-900">{{ activities.from }}</span> sampai <span class="font-bold text-gray-900">{{ activities.to }}</span> dari <span class="font-bold text-gray-900">{{ activities.total }}</span> hasil
                </p>
                <p v-else></p>

                <div v-if="formattedLinks.length > 0" class="flex flex-wrap justify-center items-center gap-1.5">
                    <Link 
                        v-for="(link, index) in formattedLinks" 
                        :key="index"
                        :href="link.url ?? '#'"
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
                <h2 class="text-2xl font-bold text-gray-900">Hapus Kegiatan?</h2>
                <p class="mt-2 text-gray-600 text-center">
                    Apakah Anda yakin ingin menghapus kegiatan <br>
                    <span class="font-bold text-gray-900">"{{ itemToDelete?.title }}"</span>?
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