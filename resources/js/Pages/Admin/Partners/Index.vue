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
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Kerjasama Mitra</h1>
                <p class="mt-1 text-black">Manajemen direktori institusi dan kegiatan kerjasama Fakultas Sains dan Teknologi Institut Teknologi Kalimantan</p>
            </div>
            <Link :href="route('admin.partners.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0">
                <PlusIcon class="h-5 w-5" />
                Tambah Mitra
            </Link>
        </div>

        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari institusi atau nama mitra kerjasama..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                />
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Mitra Kerjasama</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Logo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black w-1/3">Nama Institusi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Jumlah Kegiatan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-black w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="item in partners.data" :key="item.id" class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <img v-if="item.logo" :src="`/images/mitra/${item.logo}`" class="h-12 w-20 object-contain bg-white border border-gray-200 rounded p-1" />
                                <span v-else class="text-xs text-gray-500 font-bold bg-gray-100 px-2.5 py-1 rounded">Tanpa Logo</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-black">{{ item.name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">
                                <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full font-bold text-xs">{{ item.activities ? item.activities.length : 0 }} Kegiatan</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <Link :href="route('admin.partners.edit', item.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="partners.data.length === 0"><td colspan="4" class="text-center py-4 text-gray-500">Belum ada daftar kerjasama yang ditambahkan.</td></tr>
                    </tbody>
                </table>
            </div>
            
            <div class="flex items-center justify-between mt-4">
                <p v-if="partners.total > 0" class="text-sm text-black">
                    Menampilkan <span class="font-medium">{{ partners.from }}</span> sampai <span class="font-medium">{{ partners.to }}</span> dari <span class="font-medium">{{ partners.total }}</span> hasil
                </p>
                <div class="flex items-center gap-1">
                    <Link v-for="(link, index) in partners.links" :key="index" :href="link.url ?? '#'" v-html="link.label" :class="['px-3 py-1 text-sm rounded border border-gray-300', link.active ? 'bg-[#4682A9] text-white border-[#4682A9]' : 'bg-[#CBDCEB] text-gray-800 hover:bg-opacity-80', !link.url ? 'text-gray-400 cursor-not-allowed opacity-50' : '']" />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity">
        <div class="w-full max-w-md bg-white p-8 rounded-lg text-center shadow-xl">
            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 mx-auto">
                <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Hapus Mitra?</h2>
            <p class="text-gray-600 mt-2">Apakah Anda yakin ingin menghapus data <br><strong>{{ itemToDelete?.name }}</strong>?</p>
            <div class="mt-8 flex justify-center gap-4">
                <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300">Batal</button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
    
    <div v-if="showNotification" class="fixed top-5 right-5 z-50 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg">
            <CheckCircleIcon class="h-8 w-8" />
            <p class="font-semibold">{{ notificationMessage }}</p>
        </div>
    </div>
</template>