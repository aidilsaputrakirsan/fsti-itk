<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Link, router, usePage, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    FunnelIcon,
    MagnifyingGlassIcon,
    PlusIcon, 
    PencilSquareIcon, 
    TrashIcon, 
    ExclamationTriangleIcon, 
    CheckCircleIcon 
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    categories: any;
    filters: any;
    existingTypes: string[];
}>();

const search = ref(props.filters?.search || '');
const filterJenis = ref(props.filters?.jenis || '');

watch([search, filterJenis], debounce(([searchValue, jenisValue]) => {
    router.get(route('admin.kategori-ppid.index'), { search: searchValue, jenis: jenisValue }, { preserveState: true, replace: true });
}, 300));


watch(search, debounce((value: string) => {
    router.get(route('admin.kategori-ppid.index'), { 
        search: value 
    }, { 
        preserveState: true, 
        replace: true 
    });
}, 300));

const formattedLinks = computed(() => {
    if (!props.categories?.links) return [];
    
    const links = props.categories.links.map((link: any) => {
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
        router.delete(route('admin.kategori-ppid.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const notificationType = ref('success'); 

const flashSuccess = computed(() => (page.props as any).flash?.success);
const flashError = computed(() => (page.props as any).flash?.error);

watch([flashSuccess, flashError], ([successMsg, errorMsg]) => {
    if (successMsg) {
        notificationMessage.value = successMsg as string;
        notificationType.value = 'success';
        showNotification.value = true;
        setTimeout(() => { showNotification.value = false; }, 4000);
    } else if (errorMsg) {
        notificationMessage.value = errorMsg as string;
        notificationType.value = 'error';
        showNotification.value = true;
        setTimeout(() => { showNotification.value = false; }, 6000); 
    }
}, { immediate: true });
</script>

<template>
    <div>
        <Head title="Kelola Kategori Dokumen PPID" />

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Kategori Dokumen PPID</h1>
                <p class="mt-1 text-gray-600">Manajemen kelompok dan kategori dokumen untuk halaman PPID.</p>
            </div>
            <Link :href="route('admin.kategori-ppid.create')" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" />
                Tambah Kategori
            </Link>
        </div>

        <div class="flex flex-col lg:flex-row items-center justify-between gap-4 mb-6">
    <div class="relative w-full lg:flex-grow">
        <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
        <input v-model="search" type="text" placeholder="Cari nama kategori..." class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors" />
    </div>
    
    <div class="flex flex-col sm:flex-row w-full lg:w-auto items-center gap-4 flex-shrink-0">
        <div class="relative w-full sm:flex-1 lg:flex-none lg:w-64">
    <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
    <select v-model="filterJenis" class="w-full rounded-lg border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-primary focus:ring-primary transition-colors cursor-pointer">
        <option value="">Semua Jenis</option>
        <option v-for="type in existingTypes" :key="type" :value="type">
            Informasi {{ type }}
        </option>
    </select>
</div>
    </div>
</div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Kategori Dokumen PPID</h3>

            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr>
                            <th scope="col" class="w-16 text-center">No</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col" class="w-48 text-center">Jenis Informasi</th>
                            <th scope="col" class="w-24 text-center">Urutan</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="categories.data && categories.data.length > 0" v-for="(item, index) in categories.data" :key="item.id">
                            <td class="text-center font-medium text-gray-500">
                                {{ (Number(categories.current_page) - 1) * Number(categories.per_page) + Number(index) + 1 }}
                            </td>
                            <td>
                                <div class="font-bold text-gray-900">{{ item.nama_kategori }}</div>
                            </td>
                            <td class="text-center">
                                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">
                                    {{ item.jenis_informasi }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="font-bold text-gray-900">{{ item.urutan }}</div>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="route('admin.kategori-ppid.edit', item.id)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
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
                            <td colspan="5" class="py-8 text-center text-gray-500 font-medium">Belum ada kategori yang ditambahkan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="categories.total > 0" class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan <span class="font-bold text-gray-900">{{ categories.from }}</span> sampai <span class="font-bold text-gray-900">{{ categories.to }}</span> dari <span class="font-bold text-gray-900">{{ categories.total }}</span> hasil
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

        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeDeleteModal">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 sm:p-8 shadow-2xl transform transition-all scale-100">
                <div class="flex flex-col items-center text-center">
                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                        <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Hapus Kategori?</h2>
                    <p class="mt-2 text-gray-600 text-center">
                        Apakah Anda yakin ingin menghapus kategori <br>
                        <span class="font-bold text-gray-900 mt-1 line-clamp-2">"{{ itemToDelete?.nama_kategori }}"</span>?
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
            <div class="flex items-center gap-3 rounded-xl px-5 py-4 text-white shadow-xl transition-all"
                 :class="notificationType === 'error' ? 'bg-red-600' : 'bg-green-600'">
                <CheckCircleIcon v-if="notificationType === 'success'" class="h-6 w-6 flex-shrink-0" />
                <ExclamationTriangleIcon v-else class="h-6 w-6 flex-shrink-0" />
                
                <p class="font-bold text-sm tracking-wide max-w-[280px] sm:max-w-sm leading-snug">
                    {{ notificationMessage }}
                </p>
            </div>
        </div>

    </div>
</template>