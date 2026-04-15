<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { 
    CalendarIcon, 
    MapPinIcon, 
    ClockIcon, 
    UsersIcon, 
    Search, 
    ChevronDown, 
    ListFilter, 
    X,
    FileX2
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
    groupedKegiatan: {
        type: [Object, Array],
        default: () => ({})
    }
});

const searchQuery = ref('');
const selectedYear = ref('Semua');

const isFiltering = computed(() => searchQuery.value !== '' || selectedYear.value !== 'Semua');

const allYears = computed(() => {
    const years = new Set();
    const data = props.groupedKegiatan || {};
    
    Object.values(data).forEach(monthList => {
        if (Array.isArray(monthList)) {
            monthList.forEach(keg => {
                if (keg.start_date) {
                    const year = new Date(keg.start_date).getFullYear().toString();
                    years.add(year);
                }
            });
        }
    });
    const sortedYears = Array.from(years).sort((a, b) => b - a);
    return ['Semua', ...sortedYears];
});

const isOpen = ref(false);
const dropdownRef = ref(null);
const dropdownStyle = ref({});

function selectYear(selected) {
    selectedYear.value = selected;
    isOpen.value = false;
}

function toggleDropdown() {
    if (isOpen.value) {
        isOpen.value = false;
    } else {
        const button = dropdownRef.value;
        if (button) {
            const rect = button.getBoundingClientRect();
            dropdownStyle.value = {
                position: 'absolute',
                top: `${rect.bottom + window.scrollY + 8}px`,
                left: `${rect.left}px`,
                width: `${rect.width}px`,
            };
        }
        isOpen.value = true;
    }
}

const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        const dropdownMenu = document.getElementById('teleported-dropdown-kegiatan');
        if (dropdownMenu && !dropdownMenu.contains(event.target)) {
             isOpen.value = false;
        }
    }
};

onMounted(() => {
    AOS.init({ duration: 800, once: true });
    document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => document.removeEventListener('mousedown', handleClickOutside));


const flatKegiatan = computed(() => {
    const flat = [];
    const data = props.groupedKegiatan || {};
    
    Object.entries(data).forEach(([monthYear, items]) => {
        if (Array.isArray(items)) {
            items.forEach(item => flat.push({ ...item, monthYear }));
        }
    });
    return flat;
});

const filteredKegiatanFlat = computed(() => {
    const query = searchQuery.value.toLowerCase();
    const yearFilter = selectedYear.value;

    return flatKegiatan.value.filter(keg => {
        const matchTitle = keg.title ? keg.title.toLowerCase().includes(query) : false;
        const eventYear = keg.start_date ? new Date(keg.start_date).getFullYear().toString() : '';
        const matchYear = yearFilter === 'Semua' || eventYear === yearFilter;
        return matchTitle && matchYear;
    });
});

const itemsPerPage = 6; 
const currentPage = ref(1);

watch([searchQuery, selectedYear], () => {
    currentPage.value = 1;
});

const totalKegiatans = computed(() => filteredKegiatanFlat.value.length);
const totalPages = computed(() => Math.ceil(totalKegiatans.value / itemsPerPage) || 1);
const showingFrom = computed(() => totalKegiatans.value === 0 ? 0 : (currentPage.value - 1) * itemsPerPage + 1);
const showingTo = computed(() => Math.min(currentPage.value * itemsPerPage, totalKegiatans.value));

const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;

    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    if (current <= 4) return [1, 2, 3, 4, 5, '...', total];
    if (current >= total - 3) return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
    return [1, '...', current - 1, current, current + 1, '...', total];
});

const paginatedKegiatan = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredKegiatanFlat.value.slice(start, end);
});

const paginatedGroupedKegiatan = computed(() => {
    const grouped = {};
    paginatedKegiatan.value.forEach(keg => {
        if (!grouped[keg.monthYear]) {
            grouped[keg.monthYear] = [];
        }
        grouped[keg.monthYear].push(keg);
    });
    return grouped;
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        window.scrollTo({ top: 450, behavior: 'smooth' }); 
    }
};

const formatDay = (dateStr) => {
    if(!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('id-ID', { day: '2-digit' });
};
const formatMonth = (dateStr) => {
    if(!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('id-ID', { month: 'short' }).toUpperCase();
};
const formatDateLengkap = (dateStr) => {
    if(!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
};
</script>

<template>
    <PublicLayout>
        <Head title="Kegiatan Mahasiswa" />
        
        <Banner
            title="KEGIATAN MAHASISWA"
            subtitle="Agenda, Event, dan Aktivitas Organisasi Kemahasiswaan FSTI"
            background-image="/images/background-banner.webp"
        />

        <div class="bg-white py-16 md:py-24 min-h-screen font-public-sans overflow-x-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-primary-hover rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary-hover/50">
                    
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-300/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    <div class="absolute top-[20%] left-[40%] w-[30%] h-[50%] bg-blue-200/15 rounded-full blur-[80px] pointer-events-none"></div>

                   <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-bold mb-6 shadow-sm uppercase tracking-wider">
                            <UsersIcon class="w-4 h-4" /> Kegiatan Mahasiswa
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm">Lihat Kegiatan<br/>Mahasiswa FSTI</h2>
                        <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90">
                            Temukan berbagai kegiatan menarik yang diselenggarakan oleh himpunan serta UKM di FSTI.
                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 hover:scale-105 transition-all duration-500 shadow-2xl">
                        <UsersIcon class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-4 md:mx-8 mb-8 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari nama kegiatan atau event..." 
                            class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 text-slate-800 font-medium hover:bg-white transition-colors"
                            v-model="searchQuery"
                        >
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="relative md:w-80">
                        <button 
                            ref="dropdownRef"
                            @click="toggleDropdown"
                            class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
                        >
                            <span class="truncate">{{ selectedYear === 'Semua' ? 'Semua Tahun' : 'Tahun ' + selectedYear }}</span>
                            <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200" :class="{'rotate-180': isOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <div v-if="isOpen" id="teleported-dropdown-kegiatan" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden">
                            <a 
                                v-for="year in allYears" 
                                :key="year" 
                                @click="selectYear(year)" 
                                class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" 
                                :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedYear === year}"
                            >
                                {{ year === 'Semua' ? 'Tampilkan Semua Tahun' : 'Tahun ' + year }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

               <div v-if="isFiltering" class="mb-8 mx-4 md:mx-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span v-if="searchQuery && selectedYear !== 'Semua'">Pencarian <span class="text-primary">"{{ searchQuery }}"</span> di Tahun <span class="text-primary">"{{ selectedYear }}"</span></span>
                        <span v-else-if="searchQuery">Hasil pencarian untuk <span class="text-primary">"{{ searchQuery }}"</span></span>
                        <span v-else-if="selectedYear !== 'Semua'">Semua kegiatan di Tahun <span class="text-primary">{{ selectedYear }}</span></span>
                    </h3>
                    <button @click="searchQuery = ''; selectedYear = 'Semua'" class="px-5 py-2 bg-gray-50 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl border border-gray-200 transition-colors self-start sm:self-auto">Reset Filter</button>
                </div>

                <div v-if="filteredKegiatanFlat.length === 0" class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm mx-4 md:mx-8" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4">
                        <FileX2 class="h-10 w-10 text-primary" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Kegiatan dengan kriteria pencarian atau tahun tersebut tidak tersedia.</p>
                </div>

                <div v-else v-for="(kegiatanList, monthYear) in paginatedGroupedKegiatan" :key="monthYear" class="mb-16 last:mb-0">
                    
                    <div class="flex items-center gap-5 mb-8 mx-4 md:mx-8" data-aos="fade-right">
                        <div class="w-12 h-1.5 bg-primary rounded-full shadow-sm"></div>
                        <h2 class="text-3xl font-optimus font-bold text-slate-800 capitalize tracking-wide">{{ monthYear }}</h2>
                        <div class="flex-grow h-px bg-slate-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mx-4 md:mx-8">
                        <div 
                            v-for="(keg, index) in kegiatanList" :key="keg.id"
                            class="bg-white rounded-[1.5rem] border border-slate-100 shadow-[0_2px_15px_rgba(0,0,0,0.03)] hover:shadow-[0_12px_30px_rgba(47,77,211,0.08)] hover:border-primary/20 transform hover:-translate-y-1 transition-all duration-300 flex flex-col group relative"
                            data-aos="fade-up" :data-aos-delay="(index % 3) * 50"
                        >
                            <div class="h-28 bg-gradient-to-r from-primary to-primary-hover rounded-t-[1.5rem] relative overflow-hidden">
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>

                                <div class="absolute -bottom-px left-6 bg-white z-10 flex flex-col items-center justify-center min-w-[4.5rem] px-3 pt-3 pb-2.5 rounded-t-[1rem] shadow-[0_-2px_10px_rgba(0,0,0,0.04)] border-t border-x border-slate-100">
                                    <span class="text-[10px] font-bold uppercase text-slate-500 leading-none mb-1.5">{{ formatMonth(keg.start_date) }}</span>
                                    <span class="text-2xl font-black font-optimus text-primary leading-none">{{ formatDay(keg.start_date) }}</span>
                                </div>
                            </div>

                            <div class="pt-6 pb-6 px-6 flex-grow flex flex-col bg-white rounded-b-[1.5rem]">
                                <div class="mb-4 mt-1">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 text-primary font-semibold rounded-md text-[11px] uppercase tracking-wider border border-slate-100">
                                        <UsersIcon class="w-3.5 h-3.5" /> {{ keg.organizer || 'Kemahasiswaan' }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-bold text-slate-800 mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-3 leading-snug">
                                    {{ keg.title }}
                                </h3>
                                
                                <p v-if="keg.description" class="text-sm text-slate-500 line-clamp-2 mb-6 leading-relaxed">
                                    {{ keg.description }}
                                </p>

                                <div class="mt-auto space-y-3 pt-5 border-t border-slate-100">
                                    <div v-if="keg.end_date" class="flex items-start gap-3 text-sm text-slate-600">
                                        <div class="mt-0.5"><ClockIcon class="w-4 h-4 shrink-0 text-primary/70" /></div>
                                        <span>S.d <span class="font-semibold text-slate-700">{{ formatDateLengkap(keg.end_date) }}</span></span>
                                    </div>
                                    <div v-if="keg.location" class="flex items-start gap-3 text-sm text-slate-600">
                                        <div class="mt-0.5"><MapPinIcon class="w-4 h-4 shrink-0 text-primary/70" /></div>
                                        <span class="line-clamp-2 leading-tight">{{ keg.location }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="totalPages > 1 && filteredKegiatanFlat.length > 0" class="mt-16 mx-4 md:mx-8 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-slate-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-slate-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ showingFrom }}</span> - <span class="text-primary font-bold">{{ showingTo }}</span> dari <span class="text-primary font-bold">{{ totalKegiatans }}</span> Kegiatan
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button 
                            @click="changePage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                            :class="currentPage === 1 ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'"
                            v-html="'&laquo; Sebelumnya'"
                        ></button>

                        <template v-for="(page, index) in visiblePages" :key="index">
                            <span 
                                v-if="page === '...'"
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full text-slate-300 bg-slate-50/50 cursor-not-allowed"
                            >
                                ...
                            </span>
                            <button 
                                v-else
                                @click="changePage(page)"
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                                :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'"
                            >
                                {{ page }}
                            </button>
                        </template>

                        <button 
                            @click="changePage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                            :class="currentPage === totalPages ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'"
                            v-html="'Selanjutnya &raquo;'"
                        ></button>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>