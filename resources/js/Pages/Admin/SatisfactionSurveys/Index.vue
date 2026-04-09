<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { Link, router, usePage, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    MagnifyingGlassIcon, 
    FunnelIcon,
    EyeIcon,
    TrashIcon,
    ExclamationTriangleIcon,
    CheckCircleIcon,
    Cog6ToothIcon,
    XMarkIcon
} from '@heroicons/vue/24/outline';
import { debounce } from 'lodash';
import dayjs from 'dayjs';
import 'dayjs/locale/id';

dayjs.locale('id');
defineOptions({ layout: AdminLayout });

const props = defineProps<{
    surveys: any;
    filters: any;
}>();

const search = ref(props.filters?.search || '');
const respondentType = ref(props.filters?.respondent_type || '');

const respondentTypes = [
    'Mahasiswa', 'Dosen', 'Tenaga Kependidikan', 'Alumni', 'Masyarakat Umum'
];

watch([search, respondentType], debounce(() => {
    router.get((route as Function)('admin.satisfaction-surveys.index'), {
        search: search.value,
        respondent_type: respondentType.value === '' ? null : respondentType.value,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const formattedLinks = computed(() => {
    if (!props.surveys?.links) return [];
    
    const links = props.surveys.links.map((link: any) => {
        let label = link.label;
        if (label.includes('Previous') || label.includes('&laquo;')) label = 'Sebelumnya';
        if (label.includes('Next') || label.includes('&raquo;')) label = 'Selanjutnya';
        return { ...link, label };
    });

    if (links.length <= 7) return links;

    const activeIndex = links.findIndex((l: any) => l.active);
    const result = [];
    
    result.push(links[0]);

    links.forEach((link: any, index: number) => {
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

const isDetailModalOpen = ref(false);
const selectedSurvey = ref<any | null>(null);

const openDetailModal = (survey: any) => {
    selectedSurvey.value = survey;
    isDetailModalOpen.value = true;
};
const closeDetailModal = () => {
    isDetailModalOpen.value = false;
    selectedSurvey.value = null;
};

const isModalOpen = ref(false);
const surveyToDelete = ref<any | null>(null);

const openDeleteModal = (survey: any) => {
    surveyToDelete.value = survey;
    isModalOpen.value = true;
};
const closeDeleteModal = () => {
    isModalOpen.value = false;
    surveyToDelete.value = null;
};
const confirmDelete = () => {
    if (surveyToDelete.value) {
        router.delete((route as Function)('admin.satisfaction-surveys.destroy', surveyToDelete.value.id), {
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

const formatDate = (dateString: string) => {
    return dayjs(dateString).format('DD MMMM YYYY');
};

const getRatingStars = (rating: number) => {
    return '⭐'.repeat(rating);
};
</script>

<template>
    <div>
        <Head title="Hasil Survei Kepuasan" />

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Hasil Survei Kepuasan</h1>
                <p class="mt-1 text-gray-600">Manajemen data respons survei layanan Informasi Publik dan Zona Integritas FSTI.</p>
            </div>
            
            <Link :href="(route as Function)('admin.survey-categories.index')" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <Cog6ToothIcon class="h-5 w-5 stroke-2" />
                Kelola Aspek Penilaian
            </Link>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full sm:flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari nama atau email responden..." 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-primary focus:ring-primary transition-colors" 
                />
            </div>
            
            <div class="relative w-full sm:w-64 flex-shrink-0">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="respondentType" class="w-full rounded-lg border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:border-primary focus:ring-primary transition-colors cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option v-for="type in respondentTypes" :key="type" :value="type">{{ type }}</option>
                </select>
            </div>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Survei Masuk</h3>
            
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[900px]">
                    <thead>
                        <tr>
                            <th scope="col" class="w-16 text-center">No</th>
                            <th scope="col">Responden</th>
                            <th scope="col" class="w-40 text-center">Kategori</th>
                            <th scope="col" class="w-60">Fokus Penilaian</th>
                            <th scope="col" class="w-28 text-center">Rating</th>
                            <th scope="col" class="w-32 text-center">Tanggal</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="surveys.data && surveys.data.length > 0" v-for="(survey, index) in surveys.data" :key="survey.id">
                            <td class="text-center font-medium text-gray-500">
                                {{ (Number(surveys.current_page) - 1) * Number(surveys.per_page) + Number(index) + 1 }}
                            </td>
                            <td>
                                <div class="font-bold text-gray-900">{{ survey.respondent_name || 'Anonim' }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ survey.respondent_email || 'Tidak menyertakan email' }}</div>
                            </td>
                            <td class="text-center">
                                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">
                                    {{ survey.respondent_type }}
                                </span>
                            </td>
                            <td>
                                <div class="text-sm font-medium text-gray-700 truncate max-w-[200px]" :title="survey.service_category">{{ survey.service_category }}</div>
                            </td>
                            <td class="text-center">
                                <span class="text-sm" :title="`${survey.rating} dari 5 Bintang`">{{ getRatingStars(survey.rating) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="text-sm font-medium text-gray-900">{{ formatDate(survey.created_at) }}</div>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <button @click="openDetailModal(survey)" type="button" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
                                        <EyeIcon class="h-4 w-4" /> Detail
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(survey)" type="button" class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="7" class="py-8 text-center text-gray-500 font-medium">Belum ada data respons survei.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <p v-if="surveys.total > 0" class="text-sm text-gray-600 text-center sm:text-left">
                    Menampilkan <span class="font-bold text-gray-900">{{ surveys.from }}</span> sampai <span class="font-bold text-gray-900">{{ surveys.to }}</span> dari <span class="font-bold text-gray-900">{{ surveys.total }}</span> hasil
                </p>
                <p v-else></p>

                <div v-if="formattedLinks.length > 0" class="flex flex-wrap justify-center items-center gap-1.5">
                    <Link 
                        v-for="(link, index) in formattedLinks" 
                        :key="index"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        :class="[
                            'px-3.5 py-1.5 rounded-lg border text-sm font-medium transition-colors',
                            link.active ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:text-primary',
                            !link.url && 'opacity-50 bg-gray-50 cursor-not-allowed hover:bg-gray-50 hover:text-gray-700'
                        ]"
                    />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isDetailModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeDetailModal">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] transform transition-all scale-100">
            <div class="px-6 sm:px-8 py-5 border-b border-gray-100 bg-gray-50 rounded-t-2xl flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <EyeIcon class="w-6 h-6 mr-2 text-primary stroke-2" /> Detail Respons Survei
                </h2>
                <button @click="closeDetailModal" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-full hover:bg-gray-200">
                    <XMarkIcon class="h-6 w-6" />
                </button>
            </div>
            
            <div class="p-6 sm:p-8 overflow-y-auto" v-if="selectedSurvey">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8 bg-blue-50/50 p-5 rounded-xl border border-blue-100">
                    <div>
                        <p class="text-xs font-bold text-gray-500 mb-1 uppercase tracking-wide">Nama Responden</p>
                        <p class="text-base font-bold text-gray-900">{{ selectedSurvey.respondent_name || 'Anonim' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 mb-1 uppercase tracking-wide">Email</p>
                        <p class="text-sm font-medium text-gray-800">{{ selectedSurvey.respondent_email || 'Tidak menyertakan email' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Kategori / Status</p>
                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">{{ selectedSurvey.respondent_type }}</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 mb-1 uppercase tracking-wide">Waktu Pengisian</p>
                        <p class="text-sm font-medium text-gray-800">{{ formatDate(selectedSurvey.created_at) }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Fokus Aspek Layanan</p>
                    <p class="text-lg font-bold text-gray-900 bg-gray-50 p-4 rounded-xl border border-gray-100">{{ selectedSurvey.service_category }}</p>
                </div>

                <div class="mb-8">
                    <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Tingkat Kepuasan</p>
                    <div class="flex items-center bg-gray-50 p-4 rounded-xl border border-gray-100 w-fit">
                        <span class="text-2xl mr-3 tracking-widest">{{ getRatingStars(selectedSurvey.rating) }}</span>
                        <span class="font-bold text-lg" :class="selectedSurvey.rating >= 4 ? 'text-primary' : selectedSurvey.rating === 3 ? 'text-orange-500' : 'text-red-500'">{{ selectedSurvey.rating }} / 5</span>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Kritik, Saran & Masukan</p>
                    <div class="bg-gray-50 border border-gray-200 p-5 rounded-xl text-sm text-gray-800 whitespace-pre-wrap leading-relaxed min-h-[100px]">
                        {{ selectedSurvey.feedback || 'Responden tidak memberikan masukan secara tertulis.' }}
                    </div>
                </div>
            </div>
            
            <div class="px-6 sm:px-8 py-5 border-t border-gray-100 bg-gray-50 flex justify-end rounded-b-2xl">
                <button @click="closeDetailModal" class="px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary-hover transition-colors shadow-sm w-full sm:w-auto">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeDeleteModal">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 sm:p-8 shadow-2xl transform transition-all scale-100">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Survei?</h2>
                <p class="mt-2 text-gray-600 text-center">
                    Apakah Anda yakin ingin menghapus data respons survei dari <br>
                    <span class="font-bold text-gray-900 mt-1">"{{ surveyToDelete?.respondent_name || 'Anonim' }}"</span>?
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