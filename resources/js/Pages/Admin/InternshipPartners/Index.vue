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
    BuildingOffice2Icon,
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';

defineOptions({ layout: AdminLayout });

interface PartnerRow {
    id: number;
    name: string;
    business_field: string;
    location: string;
    type_label: string;
    study_programs: string[];
    logo_url: string | null;
    is_active: boolean;
}

const props = defineProps<{
    partners: {
        data: PartnerRow[];
        links: { url: string | null; label: string; active: boolean }[];
        current_page: number;
        per_page: number;
        from: number;
        to: number;
        total: number;
    };
    filters: { search?: string };
}>();

const search = ref(props.filters?.search || '');

watch(search, debounce((value: string) => {
    router.get(route('admin.internship-partners.index'), { search: value }, { preserveState: true, replace: true });
}, 300));

const formattedLinks = computed(() =>
    (props.partners?.links ?? []).map((link) => {
        let label = link.label;
        if (label.includes('Previous') || label.includes('&laquo;')) label = 'Sebelumnya';
        if (label.includes('Next') || label.includes('&raquo;')) label = 'Selanjutnya';
        return { ...link, label };
    })
);

const isModalOpen = ref(false);
const itemToDelete = ref<PartnerRow | null>(null);

const openDeleteModal = (item: PartnerRow) => {
    itemToDelete.value = item;
    isModalOpen.value = true;
};

const closeDeleteModal = () => {
    isModalOpen.value = false;
    itemToDelete.value = null;
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.internship-partners.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success || (page.props as any).flash?.message);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => (showNotification.value = false), 3000);
    }
}, { immediate: true });
</script>

<template>
    <div>
        <Head title="Kelola Mitra KP/Magang" />

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Mitra KP/Magang</h1>
                <p class="mt-1 text-gray-600">Daftar perusahaan dan instansi tempat mahasiswa FSTI pernah Kerja Praktik atau Magang.</p>
            </div>
            <Link :href="route('admin.internship-partners.create')" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" />
                Tambah Mitra
            </Link>
        </div>

        <div class="relative w-full mb-6">
            <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
            <input
                v-model="search"
                type="text"
                placeholder="Cari nama mitra, bidang usaha, atau lokasi..."
                class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors"
            />
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Mitra KP/Magang</h3>

            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[900px]">
                    <thead>
                        <tr>
                            <th scope="col" class="w-16 text-center">No</th>
                            <th scope="col">Mitra</th>
                            <th scope="col">Bidang Usaha</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Prodi</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="partners.data.length > 0">
                            <tr v-for="(item, index) in partners.data" :key="item.id">
                                <td class="text-center font-medium text-gray-500">
                                    {{ (Number(partners.current_page) - 1) * Number(partners.per_page) + Number(index) + 1 }}
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 shrink-0 rounded-lg border border-gray-200 bg-white p-1 flex items-center justify-center">
                                            <img v-if="item.logo_url" :src="item.logo_url" :alt="item.name" class="max-h-full max-w-full object-contain">
                                            <BuildingOffice2Icon v-else class="h-5 w-5 text-gray-400" />
                                        </div>
                                        <span class="font-bold text-gray-900">{{ item.name }}</span>
                                    </div>
                                </td>
                                <td class="text-sm text-gray-700">{{ item.business_field }}</td>
                                <td class="text-sm text-gray-700">{{ item.location }}</td>
                                <td>
                                    <span class="inline-flex rounded-full bg-primary/10 px-2.5 py-1 text-xs font-bold text-primary whitespace-nowrap">{{ item.type_label }}</span>
                                </td>
                                <td class="text-xs text-gray-600 max-w-[220px]">
                                    {{ item.study_programs.length ? item.study_programs.join(', ') : '-' }}
                                </td>
                                <td class="text-center">
                                    <span v-if="item.is_active" class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-bold text-green-700">Tampil</span>
                                    <span v-else class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-500">Disembunyikan</span>
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-3">
                                        <Link :href="route('admin.internship-partners.edit', item.id)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
                                            <PencilSquareIcon class="h-4 w-4" /> Edit
                                        </Link>
                                        <span class="text-gray-300">|</span>
                                        <button @click="openDeleteModal(item)" type="button" class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors">
                                            <TrashIcon class="h-4 w-4" /> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td colspan="8" class="py-8 text-center text-gray-500 font-medium">Belum ada data mitra KP/magang.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="partners.total > 0" class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan <span class="font-bold text-gray-900">{{ partners.from }}</span> sampai <span class="font-bold text-gray-900">{{ partners.to }}</span> dari <span class="font-bold text-gray-900">{{ partners.total }}</span> mitra
                </p>
                <p v-else></p>

                <div v-if="formattedLinks.length > 3" class="flex flex-wrap justify-center items-center gap-1.5">
                    <Link
                        v-for="(link, index) in formattedLinks"
                        :key="index"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        :class="[
                            'px-3.5 py-1.5 rounded-lg border text-sm font-medium transition-colors',
                            link.active ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:text-primary',
                            !link.url && 'opacity-50 bg-gray-50 cursor-not-allowed hover:bg-gray-50 hover:text-gray-700',
                        ]"
                    />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" @click.self="closeDeleteModal">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 sm:p-8 shadow-2xl">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Mitra?</h2>
                <p class="mt-2 text-gray-600">
                    Yakin ingin menghapus <span class="font-bold text-gray-900">"{{ itemToDelete?.name }}"</span>?<br>
                    <span class="text-sm">Kalau hanya ingin menyembunyikan, ubah statusnya lewat Edit.</span>
                </p>
            </div>
            <div class="mt-8 flex flex-col-reverse sm:flex-row justify-center gap-3">
                <button @click="closeDeleteModal" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto">Batal</button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2.5 font-bold text-white hover:bg-red-700 transition-colors shadow-sm w-full sm:w-auto">Ya, Hapus</button>
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
