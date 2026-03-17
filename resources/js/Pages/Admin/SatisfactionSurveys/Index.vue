<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    MagnifyingGlassIcon, 
    FunnelIcon,
    EyeIcon,
    TrashIcon,
    ExclamationTriangleIcon,
    CheckCircleIcon,
    Cog6ToothIcon // Tambahan ikon gerigi untuk tombol kelola
} from '@heroicons/vue/24/outline';
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

// Modal Detail
const isDetailModalOpen = ref(false);
const selectedSurvey = ref<typeof props.surveys.data[0] | null>(null);

const openDetailModal = (survey: typeof props.surveys.data[0]) => {
    selectedSurvey.value = survey;
    isDetailModalOpen.value = true;
};
const closeDetailModal = () => {
    isDetailModalOpen.value = false;
    selectedSurvey.value = null;
};

// Modal Delete
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
    'Mahasiswa', 'Dosen', 'Tenaga Kependidikan', 'Alumni', 'Masyarakat Umum'
];

const getRatingStars = (rating: number) => {
    return '⭐'.repeat(rating);
};
</script>

<template>
    <div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-black">Hasil Survei Kepuasan</h1>
                <p class="mt-1 text-black">Manajemen data respons survei layanan Informasi Publik dan Zona Integritas</p>
            </div>
            
            <Link :href="route('admin.survey-categories.index')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0 transition-colors">
                <Cog6ToothIcon class="h-5 w-5" />
                Kelola Aspek Penilaian
            </Link>
        </div>

        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari nama atau email responden" 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9]" 
                />
            </div>
            
            <div class="relative flex-shrink-0">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="respondentType" class="w-full rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-[#4682A9] focus:ring-[#4682A9]">
                    <option value="">Semua Kategori Responden</option>
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Responden</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Fokus Penilaian</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Rating</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="props.surveys.data.length > 0" v-for="survey in props.surveys.data" :key="survey.id" class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">
                                <div>{{ survey.respondent_name || 'Anonim' }}</div>
                                <div class="text-xs text-gray-500 font-normal">{{ survey.respondent_email || '-' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">{{ survey.respondent_type }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ survey.service_category }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">
                                <span class="flex items-center gap-1">{{ getRatingStars(survey.rating) }} ({{ survey.rating }})</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ formatDate(survey.created_at) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <button @click="openDetailModal(survey)" type="button" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                                        <EyeIcon class="h-4 w-4" />
                                        Detail
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(survey)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                        <TrashIcon class="h-4 w-4" />
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada survei yang cocok dengan pencarian Anda.</td>
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

    <div v-if="isDetailModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="closeDetailModal">
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-xl flex flex-col max-h-[90vh]">
            
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <h2 class="text-lg font-bold text-[#133E87] flex items-center">
                    <EyeIcon class="w-5 h-5 mr-2" /> Detail Evaluasi Survei
                </h2>
            </div>
            
            <div class="p-6 overflow-y-auto" v-if="selectedSurvey">
                <div class="grid grid-cols-2 gap-4 mb-6 bg-[#CBDCEB]/20 p-4 rounded-lg border border-[#CBDCEB]/50">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-1">Nama Responden</p>
                        <p class="text-sm font-medium text-gray-900">{{ selectedSurvey.respondent_name || 'Anonim' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-1">Kategori</p>
                        <span class="inline-block bg-blue-100 text-[#133E87] text-xs font-medium px-2 py-0.5 rounded">{{ selectedSurvey.respondent_type }}</span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-1">Email</p>
                        <p class="text-sm text-gray-800">{{ selectedSurvey.respondent_email || '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 mb-1">Waktu Pengisian</p>
                        <p class="text-sm text-gray-800">{{ formatDate(selectedSurvey.created_at) }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Fokus Aspek Layanan</p>
                    <p class="text-base font-semibold text-[#133E87]">{{ selectedSurvey.service_category }}</p>
                </div>

                <div class="mb-6">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Tingkat Kepuasan</p>
                    <div class="flex items-center">
                        <span class="text-xl mr-2">{{ getRatingStars(selectedSurvey.rating) }}</span>
                        <span class="font-semibold text-sm" :class="selectedSurvey.rating >= 4 ? 'text-[#4682A9]' : selectedSurvey.rating === 3 ? 'text-amber-500' : 'text-red-500'">{{ selectedSurvey.rating }} / 5</span>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-2">Kritik, Saran & Masukan</p>
                    <div class="bg-[#F8FAFC] border border-[#CBDCEB]/60 p-4 rounded-lg text-sm text-gray-800 whitespace-pre-wrap leading-relaxed">
                        {{ selectedSurvey.feedback }}
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end rounded-b-lg">
                <button @click="closeDetailModal" class="px-6 py-2 bg-[#133E87] text-white rounded-lg text-sm font-semibold hover:bg-[#4682A9] transition-colors shadow-sm">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-2xl">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Hapus Survei</h2>
                <p class="mt-2 text-gray-600">
                    Apakah Anda yakin ingin menghapus data survei dari <br>
                    <span class="font-semibold">"{{ surveyToDelete?.respondent_name || 'Anonim' }}"</span>?
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