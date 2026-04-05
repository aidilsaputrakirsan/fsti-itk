<script setup>
import { ref, watch, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { MagnifyingGlassIcon, PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon, DocumentTextIcon, PhotoIcon } from '@heroicons/vue/24/outline';
import { throttle } from 'lodash';

defineOptions({ layout: AdminLayout });
const props = defineProps({ announcements: Object, filters: Object });
const search = ref(props.filters.search || '');

watch(search, throttle((newSearch) => {
    router.get(route('admin.announcements.index'), { search: newSearch }, { preserveState: true, replace: true });
}, 300));

const isModalOpen = ref(false);
const itemToDelete = ref(null);
const openDeleteModal = (item) => { itemToDelete.value = item; isModalOpen.value = true; };
const closeDeleteModal = () => { isModalOpen.value = false; itemToDelete.value = null; };
const confirmDelete = () => { if (itemToDelete.value) router.delete(route('admin.announcements.destroy', itemToDelete.value.id), { onSuccess: () => closeDeleteModal() }); };

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => page.props.flash?.success);
watch(flashSuccess, (msg) => { if (msg) { notificationMessage.value = msg; showNotification.value = true; setTimeout(() => { showNotification.value = false; }, 3000); } }, { immediate: true });
</script>

<template>
    <Head title="Kelola Pengumuman" />
    <div>
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Pengumuman Resmi</h1>
                <p class="mt-1 text-black">Manajemen surat edaran, poster acara, dan informasi publik FSTI</p>
            </div>
            <Link :href="route('admin.announcements.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0">
                <PlusIcon class="h-5 w-5" />
                Tambah Pengumuman
            </Link>
        </div>

        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input v-model="search" type="text" placeholder="Cari judul pengumuman..." class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black w-2/5">Judul Pengumuman</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Lampiran PDF</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Poster / Cover</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-black w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="item in announcements.data" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-black">
                                <div class="line-clamp-2" :title="item.title">{{ item.title }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ new Date(item.created_at).toLocaleDateString('id-ID') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span v-if="item.document_path" class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-2.5 py-1 rounded-md font-bold text-xs"><DocumentTextIcon class="w-4 h-4"/> PDF Tersedia</span>
                                <span v-else class="text-gray-400 font-bold text-xs bg-gray-100 px-2.5 py-1 rounded">Tidak Ada</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <img v-if="item.poster_path" :src="`/storage/${item.poster_path}`" class="h-10 w-16 object-cover rounded shadow-sm border border-gray-200" />
                                <span v-else class="text-gray-400 font-bold text-xs bg-gray-100 px-2.5 py-1 rounded inline-flex items-center gap-1"><PhotoIcon class="w-4 h-4"/> Tanpa Poster</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <Link :href="route('admin.announcements.edit', item.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80"><PencilSquareIcon class="h-4 w-4" /> Edit</Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80"><TrashIcon class="h-4 w-4" /> Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="announcements.data.length === 0"><td colspan="4" class="text-center py-6 text-gray-500">Belum ada data pengumuman.</td></tr>
                    </tbody>
                </table>
            </div>
            
            <div class="flex items-center justify-between mt-4">
                <p v-if="announcements.total > 0" class="text-sm text-black">Menampilkan <span class="font-medium">{{ announcements.from }}</span> sampai <span class="font-medium">{{ announcements.to }}</span> dari <span class="font-medium">{{ announcements.total }}</span> hasil</p>
                <div class="flex items-center gap-1">
                    <Link v-for="(link, index) in announcements.links" :key="index" :href="link.url ?? '#'" v-html="link.label" :class="['px-3 py-1 text-sm rounded border border-gray-300', link.active ? 'bg-[#4682A9] text-white border-[#4682A9]' : 'bg-[#CBDCEB] text-gray-800 hover:bg-opacity-80', !link.url ? 'text-gray-400 cursor-not-allowed opacity-50' : '']" />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity">
        <div class="w-full max-w-md bg-white p-8 rounded-lg text-center shadow-xl">
            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 mx-auto"><ExclamationTriangleIcon class="h-10 w-10 text-red-500" /></div>
            <h2 class="text-2xl font-bold text-gray-800">Hapus Pengumuman?</h2>
            <p class="text-gray-600 mt-2">File PDF dan gambar terkait juga akan dihapus permanen. Lanjutkan?</p>
            <div class="mt-8 flex justify-center gap-4">
                <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300">Batal</button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>
    
    <div v-if="showNotification" class="fixed top-5 right-5 z-50 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg"><CheckCircleIcon class="h-8 w-8" /><p class="font-semibold">{{ notificationMessage }}</p></div>
    </div>
</template>