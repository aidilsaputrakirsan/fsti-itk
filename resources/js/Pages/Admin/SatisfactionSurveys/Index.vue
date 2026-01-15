<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { MagnifyingGlassIcon, EyeIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import { throttle } from 'lodash';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    surveys: {
        data: Array<{
            id: number;
            respondent_name: string | null;
            respondent_email: string | null;
            respondent_type: string;
            service_category: string;
            rating: number;
            feedback: string | null;
            created_at: string;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean; }>;
        from: number;
        to: number;
        total: number;
    };
    filters: {
        search: string | null;
        respondent_type: string | null;
    };
}>();

const search = ref(props.filters.search);
const respondentType = ref(props.filters.respondent_type || '');

watch([search, respondentType], throttle(function ([searchVal, typeVal]: [(string | null), (string | null)]) {
    router.get(route('admin.satisfaction-surveys.index'), {
        search: searchVal,
        respondent_type: typeVal === '' ? null : typeVal,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const isModalOpen = ref(false);
const surveyToDelete = ref<typeof props.surveys.data[0] | null>(null);

const openDeleteModal = (survey: typeof props.surveys.data[0]) => {
    surveyToDelete.value = survey;
    isModalOpen.value = true;
};

const closeDeleteModal = () => {
    isModalOpen.value = false;
    surveyToDelete.value = null;
};

const confirmDelete = () => {
    if (surveyToDelete.value) {
        router.delete(route('admin.satisfaction-surveys.destroy', surveyToDelete.value.id), {
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

const formatDate = (datetime: string) => {
    const date = new Date(datetime);
    return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

const respondentTypes = [
    'Mahasiswa',
    'Dosen',
    'Tenaga Kependidikan',
    'Alumni',
    'Mitra/Pengguna',
    'Masyarakat Umum'
];

const getRatingStars = (rating: number) => {
    return '⭐'.repeat(rating);
};
</script>

<template>
    <div>
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Hasil Survei Kepuasan</h1>
                <p class="mt-1 text-black">Data survei kepuasan layanan dari pengguna</p>
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari berdasarkan nama atau email" 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                />
            </div>
            
            <div class="relative flex-shrink-0">
                <select v-model="respondentType" class="w-full rounded-lg border border-gray-300 bg-white py-3 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <option value="">Semua Responden</option>
                    <option v-for="type in respondentTypes" :key="type" :value="type">{{ type }}</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Survei</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Tipe Responden</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Layanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Rating</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="props.surveys.data.length > 0" v-for="survey in props.surveys.data" :key="survey.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-black">
                                {{ survey.respondent_name || 'Anonim' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-medium text-purple-800">{{ survey.respondent_type }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-black">{{ survey.service_category }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="text-yellow-500 font-medium">{{ getRatingStars(survey.rating) }}</span>
                                <span class="text-gray-600 ml-1">({{ survey.rating }}/5)</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-black">{{ formatDate(survey.created_at) }}</td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <button @click="openDeleteModal(survey)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                    <TrashIcon class="h-4 w-4" />
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data survei.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-4">
                <p v-if="props.surveys.total > 0" class="text-sm text-black">
                    Menampilkan
                    <span class="font-medium">{{ props.surveys.from }}</span>
                    sampai
                    <span class="font-medium">{{ props.surveys.to }}</span>
                    dari
                    <span class="font-medium">{{ props.surveys.total }}</span>
                    hasil
                </p>
                <p v-else></p>

                <div class="flex items-center gap-1">
                    <Link 
                        v-for="(link, index) in props.surveys.links" 
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

    <!-- Modal Konfirmasi Hapus -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-2xl">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Hapus Survei</h2>
                <p class="mt-2 text-gray-600">
                    Apakah Anda yakin ingin menghapus survei ini?
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
    
    <!-- Notifikasi Sukses -->
    <div v-if="showNotification" class="fixed top-5 right-5 z-50 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg">
            <CheckCircleIcon class="h-8 w-8" />
            <p class="font-semibold">{{ notificationMessage }}</p>
        </div>
    </div>
</template>
