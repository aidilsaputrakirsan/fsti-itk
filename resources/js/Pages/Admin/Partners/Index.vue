<script setup>
import { ref, watch, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { MagnifyingGlassIcon, PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';
import { throttle } from 'lodash';

defineOptions({ layout: AdminLayout });
const props = defineProps({ partners: Object, filters: Object });
const search = ref(props.filters.search || '');

watch(search, throttle((newSearch) => {
    router.get(route('admin.partners.index'), { search: newSearch }, { preserveState: true, replace: true });
}, 300));

const formattedLinks = computed(() => {
    const links = props.partners.links.map(link => {
        let label = link.label;
        if (label.includes('Previous')) label = 'Sebelumnya';
        if (label.includes('Next')) label = 'Selanjutnya';
        return { ...link, label };
    });

    if (links.length <= 7) return links;

    const activeIndex = links.findIndex(l => l.active);
    const result = [];
    
    result.push(links[0]);

    links.forEach((link, index) => {
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
const itemToDelete = ref(null);
const openDeleteModal = (item) => { itemToDelete.value = item; isModalOpen.value = true; };
const closeDeleteModal = () => { isModalOpen.value = false; itemToDelete.value = null; };
const confirmDelete = () => { if (itemToDelete.value) router.delete(route('admin.partners.destroy', itemToDelete.value.id), { onSuccess: () => closeDeleteModal() }); };

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => page.props.flash?.success);
watch(flashSuccess, (msg) => { if (msg) { notificationMessage.value = msg; showNotification.value = true; setTimeout(() => { showNotification.value = false; }, 3000); } }, { immediate: true });
</script>

<template>
    <Head title="Kelola Daftar Kerjasama" />
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Kerjasama Mitra</h1>
                <p class="mt-1 text-gray-600">Manajemen direktori institusi dan kegiatan kerjasama FSTI ITK.</p>
            </div>
            <Link :href="route('admin.partners.create')" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" />
                Tambah Mitra
            </Link>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full lg:flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari institusi atau nama mitra kerjasama..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors" 
                />
            </div>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Mitra Kerjasama</h3>
            
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr>
                            <th scope="col">Logo</th>
                            <th scope="col" class="w-1/3">Nama Institusi</th>
                            <th scope="col">Jumlah Kegiatan</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="partners.data.length > 0" v-for="item in partners.data" :key="item.id">
                            <td>
                                <div class="flex-shrink-0 h-12 w-20 flex items-center justify-center overflow-hidden bg-white rounded border border-gray-200 p-1">
                                    <img v-if="item.logo" :src="`/storage/${item.logo}`" class="h-full w-full object-contain mix-blend-multiply" />
                                    <span v-else class="text-[10px] text-gray-500 font-bold bg-gray-100 px-2 py-1 rounded">Tanpa Logo</span>
                                </div>
                            </td>
                            <td>
                                <div class="font-bold text-gray-900">{{ item.name }}</div>
                            </td>
                            <td>
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold bg-blue-100 text-blue-800 tracking-wide">
                                    {{ item.activities ? item.activities.length : 0 }} Kegiatan
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="route('admin.partners.edit', item.id)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
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
                            <td colspan="4" class="py-8 text-center text-gray-500 font-medium">Belum ada daftar kerjasama yang ditambahkan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="partners.total > 0" class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan <span class="font-bold text-gray-900">{{ partners.from }}</span> sampai <span class="font-bold text-gray-900">{{ partners.to }}</span> dari <span class="font-bold text-gray-900">{{ partners.total }}</span> hasil
                </p>
                <p v-else></p>

                <div class="flex flex-wrap justify-center items-center gap-1.5">
                    <Link 
                        v-for="(link, index) in formattedLinks" 
                        :key="index"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        :class="[
                            'px-3.5 py-1.5 rounded-lg border text-sm font-medium transition-colors',
                            link.active ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:text-primary',
                            !link.url && 'opacity-50 bg-gray-50 cursor-not-allowed hover:bg-gray-50'
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
                <h2 class="text-2xl font-bold text-gray-900">Hapus Mitra?</h2>
                <p class="mt-2 text-gray-600 text-center">
                    Apakah Anda yakin ingin menghapus data <br>
                    <span class="font-bold text-gray-900">"{{ itemToDelete?.name }}"</span>?
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