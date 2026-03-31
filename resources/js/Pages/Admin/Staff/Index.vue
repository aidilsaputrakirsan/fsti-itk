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
import { ref, watch, computed } from 'vue';
import { throttle } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    staff: {
        data: Array<{
            id: number;
            name: string;
            nip: string | null;
            type: string;
            structural_position: string | null;
            functional_position: string | null;
            is_active: boolean;
            display_image: string;
        }>;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        from: number;
        to: number;
        total: number;
    };
    filters: {
        search: string | null;
        type: string | null;
    };
}>();

const search = ref(props.filters.search);
const typeFilter = ref(props.filters.type || '');

watch([search, typeFilter], throttle(function ([searchVal, typeVal]: [(string | null), (string | null)]) {
    router.get(route('admin.staff.index'), {
        search: searchVal,
        type: typeVal === '' ? null : typeVal,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const isModalOpen = ref(false);
const staffToDelete = ref<typeof props.staff.data[0] | null>(null);

const openDeleteModal = (staff: typeof props.staff.data[0]) => {
    staffToDelete.value = staff;
    isModalOpen.value = true;
};

const closeDeleteModal = () => {
    isModalOpen.value = false;
    staffToDelete.value = null;
};

const confirmDelete = () => {
    if (staffToDelete.value) {
        router.delete(route('admin.staff.destroy', staffToDelete.value.id), {
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
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Civitas</h1>
                <p class="mt-1 text-black">Manajemen data dosen dan tenaga kependidikan Fakultas Sains dan Teknologi.</p>
            </div>
            <Link :href="route('admin.staff.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0">
                <PlusIcon class="h-5 w-5" />
                Tambah Civitas
            </Link>
        </div>

        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari nama atau NIP..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                />
            </div>
            
            <div class="relative flex-shrink-0">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="typeFilter" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <option value="">Semua Tipe</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Tendik">Tendik</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Civitas Akademika</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Profil</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Tipe & Jabatan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-black">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="props.staff.data.length > 0" v-for="person in props.staff.data" :key="person.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full border border-gray-200 overflow-hidden bg-gray-100">
                                        <img :src="person.display_image" alt="" class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ person.name }}</div>
                                        <div class="text-xs text-gray-500 mt-1">NIP: {{ person.nip || '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium mb-1" :class="person.type === 'Dosen' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
                                    {{ person.type }}
                                </span>
                                <div class="text-xs text-gray-700 mt-1 truncate max-w-xs">{{ person.structural_position || person.functional_position || 'Belum ada jabatan' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span v-if="person.is_active" class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                                    Aktif
                                </span>
                                <span v-else class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800">
                                    Nonaktif
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <Link :href="route('admin.staff.edit', person.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                                        <PencilSquareIcon class="h-4 w-4" />
                                        Edit
                                    </Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(person)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                        <TrashIcon class="h-4 w-4" />
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data civitas yang cocok dengan pencarian Anda.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-4">
                <p v-if="props.staff.total > 0" class="text-sm text-black">
                    Menampilkan <span class="font-medium">{{ props.staff.from }}</span> sampai <span class="font-medium">{{ props.staff.to }}</span> dari <span class="font-medium">{{ props.staff.total }}</span> hasil
                </p>
                <p v-else></p>

                <div class="flex items-center gap-1">
                    <Link 
                        v-for="(link, index) in props.staff.links" 
                        :key="index"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        :class="[
                            'px-3 py-1 text-sm rounded border border-gray-300',
                            link.active ? 'bg-[#4682A9] text-white' : 'bg-[#CBDCEB] text-gray-800 hover:bg-opacity-80',
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
                <h2 class="text-2xl font-bold text-gray-800">Hapus Civitas</h2>
                <p class="mt-2 text-gray-600">
                    Apakah Anda yakin ingin menghapus data <br>
                    <span class="font-semibold">"{{ staffToDelete?.name }}"</span>?
                </p>
            </div>
            <div class="mt-8 flex justify-center gap-4">
                <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300">
                    Batal
                </button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">
                    Ya, Hapus
                </button>
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