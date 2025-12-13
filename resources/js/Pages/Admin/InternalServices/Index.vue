<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { MagnifyingGlassIcon, PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon, LinkIcon } from '@heroicons/vue/24/outline';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import { throttle } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    services: {
        data: Array<{
            id: number;
            name: string;
            description: string | null;
            link_url: string;
            category: string | null;
            sort_order: number;
            is_active: boolean;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean; }>;
        from: number;
        to: number;
        total: number;
    };
    filters: { search: string | null; category: string | null; };
}>();

const search = ref(props.filters.search);
const category = ref(props.filters.category || '');

watch([search, category], throttle(function ([searchVal, categoryVal]: [(string | null), (string | null)]) {
    router.get(route('admin.internal-services.index'), {
        search: searchVal,
        category: categoryVal === '' ? null : categoryVal,
    }, { preserveState: true, replace: true });
}, 300));

const isModalOpen = ref(false);
const serviceToDelete = ref<typeof props.services.data[0] | null>(null);

const openDeleteModal = (service: typeof props.services.data[0]) => {
    serviceToDelete.value = service;
    isModalOpen.value = true;
};

const closeDeleteModal = () => {
    isModalOpen.value = false;
    serviceToDelete.value = null;
};

const confirmDelete = () => {
    if (serviceToDelete.value) {
        router.delete(route('admin.internal-services.destroy', serviceToDelete.value.id), {
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
        setTimeout(() => { showNotification.value = false; }, 3000);
    }
}, { immediate: true });
</script>

<template>
    <div>
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Layanan Internal</h1>
                <p class="mt-1 text-black">Manajemen link layanan internal fakultas</p>
            </div>
            <Link :href="route('admin.internal-services.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0">
                <PlusIcon class="h-5 w-5" />
                Tambah Layanan
            </Link>
        </div>

        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input v-model="search" type="text" placeholder="Cari Layanan" class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>
            <div class="relative flex-shrink-0">
                <input v-model="category" type="text" placeholder="Filter Kategori" class="w-full rounded-lg border border-gray-300 bg-white py-3 px-4 text-sm font-medium text-gray-700 shadow-sm" />
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Layanan</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">URL</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Urutan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="props.services.data.length > 0" v-for="service in props.services.data" :key="service.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-black">{{ service.name }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a :href="service.link_url" target="_blank" class="flex items-center gap-1 text-blue-600 hover:underline">
                                    <LinkIcon class="h-4 w-4" />
                                    Link
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span v-if="service.category" class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-800">{{ service.category }}</span>
                                <span v-else class="text-gray-400">-</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-black">{{ service.sort_order }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span :class="[
                                    'rounded-full px-3 py-1 text-xs font-medium',
                                    service.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                                ]">{{ service.is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <Link :href="route('admin.internal-services.edit', service.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                                        <PencilSquareIcon class="h-4 w-4" />
                                        Edit
                                    </Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(service)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                        <TrashIcon class="h-4 w-4" />
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="6" class="text-center py-4 text-gray-500">Belum ada layanan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-4">
                <p v-if="props.services.total > 0" class="text-sm text-black">
                    Menampilkan <span class="font-medium">{{ props.services.from }}</span> sampai <span class="font-medium">{{ props.services.to }}</span> dari <span class="font-medium">{{ props.services.total }}</span> hasil
                </p>
                <p v-else></p>
                <div class="flex items-center gap-1">
                    <Link v-for="(link, index) in props.services.links" :key="index" :href="link.url ?? '#'" v-html="link.label"
                        :class="[
                            'px-3 py-1 text-sm rounded border border-gray-300',
                            link.active ? 'bg-[#4682A9] text-white' : 'bg-[#CBDCEB] text-gray-800 hover:bg-opacity-80',
                            !link.url ? 'text-gray-400 cursor-not-allowed' : ''
                        ]" />
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
                <h2 class="text-2xl font-bold text-gray-800">Hapus Layanan</h2>
                <p class="mt-2 text-gray-600">Apakah Anda yakin ingin menghapus layanan <br><span class="font-semibold">"{{ serviceToDelete?.name }}"</span>?</p>
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
