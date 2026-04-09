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
        status: string | null;
    };
}>();

const search = ref(props.filters.search);
const typeFilter = ref(props.filters.type || '');
const statusFilter = ref(props.filters.status || ''); 

watch([search, typeFilter, statusFilter], throttle(function ([searchVal, typeVal, statusVal]: [(string | null), (string | null), (string | null)]) {
    router.get(route('admin.staff.index'), {
        search: searchVal,
        type: typeVal === '' ? null : typeVal,
        status: statusVal === '' ? null : statusVal,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const formattedLinks = computed(() => {
    const links = props.staff.links.map(link => {
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
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Civitas</h1>
                <p class="mt-1 text-gray-600">Manajemen data dosen dan tenaga kependidikan FSTI ITK.</p>
            </div>
            <Link :href="route('admin.staff.create')" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" />
                Tambah Civitas
            </Link>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full md:flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari nama atau NIP..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors" 
                />
            </div>
            
            <div class="flex flex-col sm:flex-row w-full md:w-auto items-center gap-4 flex-shrink-0">
                <div class="relative w-full sm:w-48">
                    <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                    <select v-model="typeFilter" class="w-full rounded-lg border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-primary focus:ring-primary transition-colors">
                        <option value="">Semua Tipe</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Tendik">Tendik</option>
                    </select>
                </div>

                <div class="relative w-full sm:w-48">
                    <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                    <select v-model="statusFilter" class="w-full rounded-lg border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-primary focus:ring-primary transition-colors">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr>
                            <th>Profil</th>
                            <th>Tipe & Jabatan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="props.staff.data.length > 0" v-for="person in props.staff.data" :key="person.id">
                            <td>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full border border-gray-200 overflow-hidden bg-gray-100">
                                        <img v-if="person.display_image" :src="person.display_image" alt="" class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-bold text-gray-900 line-clamp-1">{{ person.name }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">NIP: {{ person.nip || '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider mb-1.5" :class="person.type === 'Dosen' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800'">
                                    {{ person.type }}
                                </span>
                                <div class="text-xs text-gray-700 mt-1 truncate max-w-[200px]">{{ person.structural_position || person.functional_position || 'Belum ada jabatan' }}</div>
                            </td>
                            <td class="text-center">
                                <span v-if="person.is_active" class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">
                                    Aktif
                                </span>
                                <span v-else class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-800">
                                    Nonaktif
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="route('admin.staff.edit', person.id)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(person)" type="button" class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="4" class="py-8 text-center text-gray-500 font-medium">Tidak ada data civitas yang cocok dengan pencarian Anda.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="props.staff.total > 0" class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-gray-900">{{ props.staff.from }}</span> sampai <span class="font-bold text-gray-900">{{ props.staff.to }}</span> dari <span class="font-bold text-gray-900">{{ props.staff.total }}</span> hasil
                </p>
                <p v-else></p>

                <div class="flex flex-wrap items-center justify-center gap-1.5">
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
                <h2 class="text-2xl font-bold text-gray-900">Hapus Civitas</h2>
                <p class="mt-2 text-gray-600 text-center">
                    Apakah Anda yakin ingin menghapus data <br>
                    <span class="font-bold text-gray-900">"{{ staffToDelete?.name }}"</span>?
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