<script setup>
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
import { throttle } from 'lodash';
import dayjs from 'dayjs';
import 'dayjs/locale/id';

dayjs.locale('id');
defineOptions({ layout: AdminLayout });

const props = defineProps({
    agendas: Object,
    filters: Object,
    availableYears: Array,
});

const search = ref(props.filters.search || '');
const year = ref(props.filters.year || '');

watch([search, year], throttle(function ([searchVal, yearVal]) {
    router.get(route('admin.agenda-fakultas.index'), { 
        search: searchVal,
        year: yearVal === '' ? null : yearVal
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

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
        router.delete(route('admin.agenda-fakultas.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => page.props.flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message;
        showNotification.value = true;
        setTimeout(() => showNotification.value = false, 3000);
    }
}, { immediate: true });

const formatDate = (dateString) => {
    return dayjs(dateString).format('DD MMM YYYY');
};
</script>

<template>
    <Head title="Kelola Agenda Fakultas" />

    <div>
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Agenda Fakultas</h1>
                <p class="mt-1 text-black">Manajemen jadwal resmi, akademik, dan institusi FSTI</p>
            </div>
            <Link :href="route('admin.agenda-fakultas.create')" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-hover flex-shrink-0 transition-colors">
                <PlusIcon class="h-5 w-5" />
                Tambah Agenda
            </Link>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow w-full">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari judul atau penyelenggara..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary" 
                />
            </div>
            
            <div class="relative flex-shrink-0 w-full md:w-64">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="year" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 cursor-pointer">
                    <option value="">Semua Tahun</option>
                    <option v-for="y in availableYears" :key="y" :value="y">{{ y }}</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Agenda</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Judul Agenda</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Penyelenggara</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="agendas.data.length > 0" v-for="item in agendas.data" :key="item.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-normal min-w-[250px]">
                                <p class="text-sm font-medium text-black">{{ item.title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ item.location || 'Lokasi belum ditentukan' }}</p>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ item.organizer || '-' }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">
                                {{ formatDate(item.start_date) }}
                                <span v-if="item.end_date" class="block text-xs text-gray-500 mt-0.5"> s.d {{ formatDate(item.end_date) }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <Link :href="route('admin.agenda-fakultas.edit', item.id)" class="flex items-center gap-1 text-primary hover:opacity-80">
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
                            <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada agenda yang ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-4">
                <p v-if="agendas.total > 0" class="text-sm text-black">
                    Menampilkan <span class="font-medium">{{ agendas.from }}</span> sampai <span class="font-medium">{{ agendas.to }}</span> dari <span class="font-medium">{{ agendas.total }}</span> hasil
                </p>
                <p v-else></p>

                <div class="flex items-center gap-1">
                    <Link 
                        v-for="(link, index) in agendas.links" :key="index" :href="link.url ?? '#'" v-html="link.label"
                        :class="[
                            'px-3 py-1 text-sm rounded border border-gray-300',
                            link.active ? 'bg-primary text-white border-primary' : 'bg-[#CBDCEB] text-gray-800 hover:bg-opacity-80',
                            !link.url ? 'text-gray-400 cursor-not-allowed' : ''
                        ]"
                    />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-2xl">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Hapus Agenda</h2>
                <p class="mt-2 text-gray-600">
                    Apakah Anda yakin ingin menghapus agenda <br>
                    <span class="font-semibold">"{{ itemToDelete?.title }}"</span>?
                </p>
            </div>
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