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
    DocumentTextIcon, 
    PhotoIcon 
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';
import dayjs from 'dayjs';
import 'dayjs/locale/id';

dayjs.locale('id');
defineOptions({ layout: AdminLayout });

const props = defineProps<{
    announcements: any;
    filters: any;
}>();

const search = ref(props.filters?.search || '');

watch(search, debounce((value: string) => {
    router.get((route as Function)('admin.announcements.index'), { 
        search: value 
    }, { 
        preserveState: true, 
        replace: true 
    });
}, 300));

const formattedLinks = computed(() => {
    if (!props.announcements?.links) return [];
    
    const links = props.announcements.links.map((link: any) => {
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
        router.delete((route as Function)('admin.announcements.destroy', itemToDelete.value.id), { 
            onSuccess: () => closeDeleteModal() 
        }); 
    }
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);

watch(flashSuccess, (msg) => { 
    if (msg) { 
        notificationMessage.value = msg as string; 
        showNotification.value = true; 
        setTimeout(() => { showNotification.value = false; }, 3000); 
    } 
}, { immediate: true });

const formatDate = (dateString: string) => {
    return dayjs(dateString).format('DD MMMM YYYY');
};
</script>

<template>
    <div>
        <Head title="Kelola Pengumuman" />

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Pengumuman Resmi</h1>
                <p class="mt-1 text-gray-600">Manajemen surat edaran, poster acara, dan informasi publik FSTI.</p>
            </div>
            <Link :href="(route as Function)('admin.announcements.create')" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" />
                Tambah Pengumuman
            </Link>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search" 
                    type="text" 
                    placeholder="Cari judul pengumuman..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors" 
                />
            </div>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Pengumuman</h3>
            
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr>
                            <th scope="col" class="w-16 text-center">No</th>
                            <th scope="col" class="w-2/5">Judul Pengumuman</th>
                            <th scope="col" class="text-center w-40">Lampiran PDF</th>
                            <th scope="col" class="text-center w-40">Poster / Cover</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="announcements.data && announcements.data.length > 0" v-for="(item, index) in announcements.data" :key="item.id">
                            <td class="text-center font-medium text-gray-500">
                                {{ (Number(announcements.current_page) - 1) * Number(announcements.per_page) + Number(index) + 1 }}
                            </td>
                            <td>
                                <div class="font-bold text-gray-900 line-clamp-2" :title="item.title">{{ item.title }}</div>
                                <div class="text-xs font-medium text-gray-500 mt-1">{{ formatDate(item.created_at) }}</div>
                            </td>
                            <td class="text-center">
                                <span v-if="item.document_path" class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold text-xs">
                                    <DocumentTextIcon class="w-4 h-4 stroke-2"/> Tersedia
                                </span>
                                <span v-else class="text-gray-400 font-bold text-xs bg-gray-100 px-3 py-1 rounded-full">Tidak Ada</span>
                            </td>
                            <td class="text-center">
                                <div v-if="item.poster_path" class="flex justify-center">
                                    <img :src="`/storage/${item.poster_path}`" alt="Poster Pengumuman" class="h-10 w-16 object-cover rounded shadow-sm border border-gray-200" />
                                </div>
                                <span v-else class="text-gray-400 font-bold text-xs bg-gray-100 px-3 py-1 rounded-full inline-flex items-center gap-1">
                                    <PhotoIcon class="w-4 h-4 stroke-2"/> Tanpa Poster
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="(route as Function)('admin.announcements.edit', item.id)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
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
                            <td colspan="5" class="py-8 text-center text-gray-500 font-medium">Belum ada data pengumuman.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="announcements.total > 0" class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan <span class="font-bold text-gray-900">{{ announcements.from }}</span> sampai <span class="font-bold text-gray-900">{{ announcements.to }}</span> dari <span class="font-bold text-gray-900">{{ announcements.total }}</span> hasil
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
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 mx-auto">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Pengumuman?</h2>
                <p class="text-gray-600 mt-2 text-center">
                    File PDF dan gambar terkait juga akan dihapus permanen. Lanjutkan?
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