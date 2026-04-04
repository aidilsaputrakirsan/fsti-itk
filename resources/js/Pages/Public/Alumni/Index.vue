<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, router } from '@inertiajs/vue3';
import { 
    Search, 
    Users, 
    GraduationCap, 
    ChevronDown, 
    ListFilter, 
    X,
    BookOpen
} from 'lucide-vue-next';
import { throttle } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
    alumnis: Object,
    filters: Object,
    prodis: Array,
    years: Array
});

const searchQuery = ref(props.filters.search || '');
const selectedProdi = ref(props.filters.prodi || '');
const selectedYear = ref(props.filters.year || '');

// --- LOGIKA DROPDOWN (TELEPORT) ---
const isProdiOpen = ref(false);
const isYearOpen = ref(false);

const prodiBtnRef = ref(null);
const yearBtnRef = ref(null);

const prodiDropdownStyle = ref({});
const yearDropdownStyle = ref({});

const toggleDropdown = (type) => {
    if (type === 'prodi') {
        isYearOpen.value = false;
        if (isProdiOpen.value) {
            isProdiOpen.value = false;
        } else {
            const button = prodiBtnRef.value;
            if (button) {
                const rect = button.getBoundingClientRect();
                prodiDropdownStyle.value = {
                    position: 'absolute',
                    top: `${rect.bottom + window.scrollY + 8}px`,
                    left: `${rect.left}px`,
                    width: `${rect.width}px`,
                };
            }
            isProdiOpen.value = true;
        }
    } else if (type === 'year') {
        isProdiOpen.value = false;
        if (isYearOpen.value) {
            isYearOpen.value = false;
        } else {
            const button = yearBtnRef.value;
            if (button) {
                const rect = button.getBoundingClientRect();
                yearDropdownStyle.value = {
                    position: 'absolute',
                    top: `${rect.bottom + window.scrollY + 8}px`,
                    left: `${rect.left}px`,
                    width: `${rect.width}px`,
                };
            }
            isYearOpen.value = true;
        }
    }
};

function selectOption(type, value) {
    if (type === 'prodi') {
        selectedProdi.value = value;
        isProdiOpen.value = false;
    } else if (type === 'year') {
        selectedYear.value = value;
        isYearOpen.value = false;
    }
}

const handleClickOutside = (event) => {
    if (prodiBtnRef.value && !prodiBtnRef.value.contains(event.target)) {
        const menu = document.getElementById('prodi-dropdown-menu');
        if (menu && !menu.contains(event.target)) isProdiOpen.value = false;
    }
    if (yearBtnRef.value && !yearBtnRef.value.contains(event.target)) {
        const menu = document.getElementById('year-dropdown-menu');
        if (menu && !menu.contains(event.target)) isYearOpen.value = false;
    }
};

onMounted(() => {
    AOS.init({ duration: 800, once: true });
    document.addEventListener('mousedown', handleClickOutside);
});
onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside);
});

// --- FILTER & PAGINATION LOGIC ---
watch([searchQuery, selectedProdi, selectedYear], throttle(([newSearch, newProdi, newYear]) => {
    router.get(route('alumni.index'), { 
        search: newSearch, 
        prodi: newProdi, 
        year: newYear 
    }, { 
        preserveState: true, 
        replace: true,
        onFinish: () => { AOS.refresh(); }
    });
}, 300));

const resetFilters = () => {
    searchQuery.value = '';
    selectedProdi.value = '';
    selectedYear.value = '';
};

// Smart Pagination Setup
const currentPage = computed(() => {
    const activeLink = props.alumnis.links.find(link => link.active);
    return activeLink ? parseInt(activeLink.label) : 1;
});

const totalPages = computed(() => {
    return props.alumnis.links.length > 2 ? props.alumnis.links.length - 2 : 1;
});

const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;

    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    if (current <= 4) return [1, 2, 3, 4, 5, '...', total];
    if (current >= total - 3) return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
    return [1, '...', current - 1, current, current + 1, '...', total];
});

const changePage = (page) => {
    if (typeof page === 'number' && page >= 1 && page <= totalPages.value) {
        router.get(route('alumni.index'), {
            search: searchQuery.value,
            prodi: selectedProdi.value,
            year: selectedYear.value,
            page: page 
        }, {
            preserveState: true,
            replace: true,
            onFinish: () => { 
                AOS.refresh(); 
                window.scrollTo({ top: 400, behavior: 'smooth' }); 
            } 
        });
    }
};
</script>

<template>
    <PublicLayout>
        <Head title="Direktori Alumni - FSTI ITK" />
        
        <Banner
            title="DIREKTORI ALUMNI"
            subtitle="Jejak Kelulusan Fakultas Sains dan Teknologi Informasi"
            background-image="/images/background-banner.png"
        />

        <div class="bg-slate-50 py-16 md:py-24 min-h-screen font-public-sans overflow-x-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-primary-hover rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary-hover/50" data-aos="fade-up">
                    
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-300/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    <div class="absolute top-[20%] left-[40%] w-[30%] h-[50%] bg-blue-200/15 rounded-full blur-[80px] pointer-events-none"></div>

                   <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-bold mb-6 shadow-sm uppercase tracking-wider">
                            <GraduationCap class="w-4 h-4" /> Ikatan Alumni FSTI
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm">Jelajahi Direktori<br/>Alumni Kami</h2>
                        <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90">
                            Temukan data kelulusan, jejak langkah, dan jaringan alumni dari berbagai program studi di FSTI ITK.
                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 hover:scale-105 transition-all duration-500 shadow-2xl">
                        <Users class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-2 md:mx-8 mb-12 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row gap-4" data-aos="fade-down" data-aos-delay="100">
                    
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari berdasarkan nama atau NIM..." 
                            class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 text-slate-800 font-medium hover:bg-white transition-colors"
                            v-model="searchQuery"
                        >
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 md:w-[45%]">
                        <div class="relative w-full sm:w-3/5">
                            <button 
                                ref="prodiBtnRef"
                                @click="toggleDropdown('prodi')"
                                class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
                            >
                                <span class="truncate">{{ selectedProdi || 'Semua Program Studi' }}</span>
                                <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200 shrink-0" :class="{'rotate-180': isProdiOpen}" />
                            </button>
                            <BookOpen class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                        </div>

                        <div class="relative w-full sm:w-2/5">
                            <button 
                                ref="yearBtnRef"
                                @click="toggleDropdown('year')"
                                class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
                            >
                                <span class="truncate">{{ selectedYear || 'Semua Tahun' }}</span>
                                <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200 shrink-0" :class="{'rotate-180': isYearOpen}" />
                            </button>
                            <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                        </div>
                    </div>
                </div>

                <div v-if="searchQuery || selectedProdi || selectedYear" class="mb-8 px-2 md:px-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-in">
                    <h3 class="text-lg font-bold text-slate-700 flex items-center flex-wrap gap-x-1.5">
                        <span class="text-slate-400 font-medium">Menampilkan hasil untuk:</span>
                        <span v-if="searchQuery" class="text-primary">"{{ searchQuery }}"</span>
                        <span v-if="selectedProdi" class="px-2.5 py-1 bg-primary/10 text-primary rounded-lg text-sm">{{ selectedProdi }}</span>
                        <span v-if="selectedYear" class="px-2.5 py-1 bg-[#D9FFFE]/80 text-[#00509D] rounded-lg text-sm">Tahun {{ selectedYear }}</span>
                    </h3>
                    
                    <button @click="resetFilters" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-bold rounded-xl transition-colors shrink-0 shadow-sm flex items-center gap-2">
                        <X class="w-4 h-4" /> Hapus Filter
                    </button>
                </div>

                <div v-if="alumnis.data.length === 0" class="text-center py-20 bg-white rounded-[2rem] border border-dashed border-slate-300 shadow-sm mx-2 md:mx-8" data-aos="fade-up">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                        <Users class="w-10 h-10 text-slate-300" />
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 font-optimus">Data Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Mungkin data alumni yang Anda cari belum terdaftar atau silakan coba kata kunci dan filter yang berbeda.</p>
                    <button @click="resetFilters" class="mt-6 px-8 py-3 bg-blue-50 text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition-all duration-300 shadow-sm">
                        Reset Pencarian
                    </button>
                </div>

                <div v-else class="bg-white rounded-3xl shadow-[0_8px_30px_rgba(0,53,102,0.04)] border border-slate-100 overflow-hidden mx-2 md:mx-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-gradient-to-r from-primary to-primary-hover border-b border-primary/20">
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider w-32">NIM</th>
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider">Nama Lengkap</th>
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider">Program Studi</th>
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider text-center w-32">Tahun Lulus</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="alumni in alumnis.data" :key="alumni.id" class="hover:bg-slate-50/80 transition-colors duration-200 group">
                                    <td class="px-6 py-4 text-slate-600 font-bold text-sm">{{ alumni.nim }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-800 group-hover:text-primary transition-colors">{{ alumni.name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1.5 bg-slate-50 border border-slate-100 text-slate-600 rounded-lg font-semibold group-hover:bg-blue-50 group-hover:text-primary group-hover:border-blue-100 transition-colors">
                                            {{ alumni.study_program }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-14 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-sm group-hover:bg-[#D9FFFE]/80 group-hover:text-[#00509D] transition-colors">
                                            {{ alumni.graduation_year }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-if="totalPages > 1" class="mt-10 mx-2 md:mx-8 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-slate-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-slate-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ alumnis.from }}</span> - <span class="text-primary font-bold">{{ alumnis.to }}</span> dari <span class="text-primary font-bold">{{ alumnis.total }}</span> Data
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button 
                            @click="changePage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                            :class="currentPage === 1 ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'"
                            v-html="'&laquo; Prev'"
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
                            v-html="'Next &raquo;'"
                        ></button>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>

    <Teleport to="body">
        <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isProdiOpen" id="prodi-dropdown-menu" :style="prodiDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden max-h-60 overflow-y-auto">
                <a @click="selectOption('prodi', '')" class="block px-5 py-3 text-sm text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedProdi === ''}">
                    Semua Program Studi
                </a>
                <a v-for="prodi in prodis" :key="prodi" @click="selectOption('prodi', prodi)" class="block px-5 py-3 text-sm text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedProdi === prodi}">
                    {{ prodi }}
                </a>
            </div>
        </transition>
    </Teleport>

    <Teleport to="body">
        <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isYearOpen" id="year-dropdown-menu" :style="yearDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden max-h-60 overflow-y-auto">
                <a @click="selectOption('year', '')" class="block px-5 py-3 text-sm text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedYear === ''}">
                    Semua Tahun
                </a>
                <a v-for="year in years" :key="year" @click="selectOption('year', year)" class="block px-5 py-3 text-sm text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedYear === year}">
                    {{ year }}
                </a>
            </div>
        </transition>
    </Teleport>
</template>