<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { router, Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Search, BookOpen, ChevronDown, LibraryBig, ListFilter, X, FlaskConical, FileX2 } from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { debounce } from 'lodash';

const props = defineProps<{
    researchList: any;
    stats: { total: number };
    filters: any;
    years: string[];
    studyPrograms: { id: number; name: string }[];
}>();

const bannerImage = '/images/background-banner.webp';
const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year || '');
const selectedProgram = ref(props.filters.program || '');

const isFiltering = computed(() => search.value !== '' || selectedYear.value !== '' || selectedProgram.value !== '');

watch(search, debounce(() => { applyFilters(); }, 500));
watch([selectedYear, selectedProgram], () => { applyFilters(); });

const isYearOpen = ref(false);
const isProgramOpen = ref(false);

const yearBtnRef = ref<HTMLButtonElement | null>(null);
const programBtnRef = ref<HTMLButtonElement | null>(null);

const yearDropdownStyle = ref({});
const programDropdownStyle = ref({});

const selectedProgramName = computed(() => {
    if (!selectedProgram.value) return '';
    const p = props.studyPrograms.find((x) => x.id == selectedProgram.value);
    return p ? p.name : '';
});

const toggleDropdown = (type: 'year' | 'program') => {
    const refs = { year: yearBtnRef, program: programBtnRef };
    const isOpenRefs = { year: isYearOpen, program: isProgramOpen };
    const styleRefs = { year: yearDropdownStyle, program: programDropdownStyle };

    Object.keys(isOpenRefs).forEach((key) => {
        if (key !== type) isOpenRefs[key as keyof typeof isOpenRefs].value = false;
    });

    const isOpen = isOpenRefs[type];
    if (isOpen.value) {
        isOpen.value = false;
    } else {
        const button = refs[type].value;
        if (button) {
            const rect = button.getBoundingClientRect();
            styleRefs[type].value = {
                position: 'absolute',
                top: `${rect.bottom + window.scrollY + 8}px`,
                left: `${rect.left}px`,
                width: `${rect.width}px`,
            };
        }
        isOpen.value = true;
    }
};

function selectOption(type: 'year' | 'program', value: string) {
    if (type === 'year') { selectedYear.value = value; isYearOpen.value = false; }
    else if (type === 'program') { selectedProgram.value = value; isProgramOpen.value = false; }
}

const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as Node;
    const check = (btnRef: any, menuId: string, isOpenRef: any) => {
        const menu = document.getElementById(menuId);
        if (btnRef.value && !btnRef.value.contains(target) && menu && !menu.contains(target)) {
            isOpenRef.value = false;
        }
    };
    check(yearBtnRef, 'year-dropdown-menu', isYearOpen);
    check(programBtnRef, 'program-dropdown-menu', isProgramOpen);
};

onMounted(() => { AOS.init({ duration: 800, once: true }); document.addEventListener('mousedown', handleClickOutside); });
onUnmounted(() => { document.removeEventListener('mousedown', handleClickOutside); });

const applyFilters = () => {
    router.get(route('research.index'), { search: search.value, year: selectedYear.value, program: selectedProgram.value }, { preserveState: true, preserveScroll: true, replace: true });
};

const resetSearch = () => { search.value = ''; selectedYear.value = ''; selectedProgram.value = ''; };

const currentPage = computed<number>(() => props.researchList?.current_page || 1);
const totalPages = computed<number>(() => props.researchList?.last_page || 1);
const showingFrom = computed<number>(() => props.researchList?.from || 0);
const showingTo = computed<number>(() => props.researchList?.to || 0);
const totalResearch = computed<number>(() => props.researchList?.total || 0);

const visiblePages = computed(() => {
    const total = totalPages.value; 
    const current = currentPage.value;
    
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    
    if (current <= 4) return [1, 2, 3, 4, 5, '...', total];
    
    if (current >= total - 3) return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
    
    return [1, '...', current - 1, current, current + 1, '...', total];
});

const changePage = (page: number | string) => {
    if (typeof page === 'number' && page >= 1 && page <= totalPages.value) {
        router.get(route('research.index'), { search: search.value, year: selectedYear.value, program: selectedProgram.value, page: page }, { 
            preserveState: true, 
            preserveScroll: true, 
            replace: true, 
            onFinish: () => { 
                AOS.refresh();
                window.scrollTo({ top: 450, behavior: 'smooth' }); 
            } 
        });
    }
};
</script>

<template>
    <PublicLayout>
        <Head title="Penelitian - FSTI ITK" />
        <Banner title="Daftar Penelitian" subtitle="PANGKALAN DATA INOVASI DOSEN FSTI ITK" :background-image="bannerImage" />

        <div class="bg-white py-12 md:py-24 font-public-sans min-h-screen overflow-x-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary to-primary-hover rounded-[1.5rem] md:rounded-[2rem] p-6 sm:p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary-hover/50">
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-300/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    <div class="absolute top-[20%] left-[40%] w-[30%] h-[50%] bg-blue-200/15 rounded-full blur-[80px] pointer-events-none"></div>

                   <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-xs md:text-sm font-bold mb-4 md:mb-6 shadow-sm uppercase tracking-wider">
                            <FlaskConical class="w-3.5 h-3.5 md:w-4 md:h-4" /> Riset
                        </div>
                        
                        <h2 class="text-2xl sm:text-3xl md:text-5xl font-optimus font-bold mb-3 md:mb-4 leading-tight drop-shadow-sm">Direktori Penelitian<br/>Dosen FSTI</h2>
                        
                        <p class="text-blue-50 text-sm sm:text-base md:text-lg font-light leading-relaxed max-w-xl opacity-90">
                            Temukan rekam jejak penelitian dan inovasi dari para dosen di Fakultas Sains dan Teknologi Informasi.
                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 hover:scale-105 transition-all duration-500 shadow-2xl">
                        <BookOpen class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-10 md:-mt-16 mx-2 sm:mx-4 md:mx-8 mb-12 bg-white p-3 md:p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row gap-3 md:gap-4" data-aos="fade-down">
                    
                    <div class="relative flex-grow">
                        <input 
                            type="text" placeholder="Cari judul penelitian atau nama dosen..." title="Cari judul penelitian atau nama dosen..."
                            class="w-full pl-9 lg:pl-11 pr-8 lg:pr-10 py-3 md:py-3.5 text-[11px] sm:text-sm lg:text-base text-ellipsis border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 text-slate-800 font-medium hover:bg-white transition-colors"
                            v-model="search"
                        >
                        <Search class="absolute left-3.5 lg:left-4 top-1/2 -translate-y-1/2 w-4 h-4 lg:w-5 lg:h-5 text-primary/60" />
                        <button v-if="search" @click="search = ''" class="absolute right-2.5 lg:right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors"><X class="w-4 h-4 lg:w-5 lg:h-5" /></button>
                    </div>

                    <div class="relative w-full md:w-[35%] lg:w-72">
                        <button ref="programBtnRef" @click="toggleDropdown('program')" class="w-full pl-9 lg:pl-10 pr-7 lg:pr-8 py-3 md:py-3.5 text-[11px] sm:text-xs lg:text-sm xl:text-base border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors">
                            <span class="truncate">{{ selectedProgramName || 'Semua Program Studi' }}</span>
                            <ChevronDown class="w-4 h-4 lg:w-5 lg:h-5 text-primary/60 transition-transform duration-200 shrink-0" :class="{'rotate-180': isProgramOpen}" />
                        </button>
                        <LibraryBig class="absolute left-3.5 lg:left-4 top-1/2 -translate-y-1/2 w-4 h-4 lg:w-5 lg:h-5 text-primary pointer-events-none" />
                    </div>

                    <div class="relative w-full md:w-[25%] lg:w-56">
                        <button ref="yearBtnRef" @click="toggleDropdown('year')" class="w-full pl-9 lg:pl-10 pr-7 lg:pr-8 py-3 md:py-3.5 text-[11px] sm:text-xs lg:text-sm xl:text-base border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors">
                            <span class="truncate">{{ selectedYear || 'Semua Tahun' }}</span>
                            <ChevronDown class="w-4 h-4 lg:w-5 lg:h-5 text-primary/60 transition-transform duration-200 shrink-0" :class="{'rotate-180': isYearOpen}" />
                        </button>
                        <ListFilter class="absolute left-3.5 lg:left-4 top-1/2 -translate-y-1/2 w-4 h-4 lg:w-5 lg:h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <div v-if="isFiltering" class="mb-8 mx-2 sm:mx-4 md:mx-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span v-if="search && selectedProgram && selectedYear">Pencarian <span class="text-primary">"{{ search }}"</span> di Prodi <span class="text-primary">{{ selectedProgramName }}</span> Tahun <span class="text-primary">{{ selectedYear }}</span></span>
                        <span v-else-if="search && selectedProgram">Pencarian <span class="text-primary">"{{ search }}"</span> di Program Studi <span class="text-primary">{{ selectedProgramName }}</span></span>
                        <span v-else-if="search && selectedYear">Pencarian <span class="text-primary">"{{ search }}"</span> pada Tahun <span class="text-primary">{{ selectedYear }}</span></span>
                        <span v-else-if="search">Hasil pencarian untuk <span class="text-primary">"{{ search }}"</span></span>
                        <span v-else-if="selectedProgram && selectedYear">Semua penelitian Prodi <span class="text-primary">{{ selectedProgramName }}</span> Tahun <span class="text-primary">{{ selectedYear }}</span></span>
                        <span v-else-if="selectedProgram">Semua penelitian Program Studi <span class="text-primary">{{ selectedProgramName }}</span></span>
                        <span v-else-if="selectedYear">Semua penelitian Tahun <span class="text-primary">{{ selectedYear }}</span></span>
                    </h3>
                    <button @click="resetSearch" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto">Reset Filter</button>
                </div>

                <div v-if="researchList.data.length > 0">
                    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgba(0,53,102,0.04)] border border-slate-100 overflow-hidden mx-2 sm:mx-4 md:mx-8 mb-16" data-aos="fade-up">
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[900px] text-left border-collapse">
                                <thead>
                                    <tr class="bg-gradient-to-r from-primary to-primary-hover border-b border-primary/20">
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider text-center w-16">No</th>
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider w-[20%]">Nama Peneliti</th>
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider w-[45%]">Judul Penelitian</th>
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider w-[20%]">Program Studi</th>
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider text-center w-24">Tahun</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <tr v-for="(item, index) in researchList.data" :key="item.id" class="hover:bg-slate-50/80 transition-colors duration-200 group">
                                        <td class="px-6 py-4 text-center text-slate-600 font-bold text-sm">{{ Number(showingFrom) + Number(index) }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800 group-hover:text-primary transition-colors">{{ item.nama_dosen }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600 leading-relaxed font-medium">
                                            {{ item.judul }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1.5 bg-slate-50 border border-slate-100 text-slate-600 rounded-lg font-semibold group-hover:bg-blue-50 group-hover:text-primary group-hover:border-blue-100 transition-colors">
                                                {{ item.study_program?.name || '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center justify-center w-14 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-sm group-hover:bg-[#D9FFFE]/80 group-hover:text-[#00509D] transition-colors">
                                                {{ item.tahun }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-if="totalPages > 1" class="mt-12 flex flex-col items-center justify-center gap-4 w-full relative z-20 mx-2 sm:mx-4 md:mx-8" data-aos="fade-in">
                        <div class="flex flex-wrap justify-center items-center gap-2">
                            <button 
                                @click="changePage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-colors whitespace-nowrap border"
                                :class="currentPage === 1 ? 'text-gray-300 bg-gray-50 border-gray-100 cursor-not-allowed' : 'text-gray-600 bg-white border-gray-200 hover:border-primary hover:text-primary shadow-sm'"
                            >Sebelumnya</button>

                            <template v-for="(page, index) in visiblePages" :key="index">
                                <span 
                                    v-if="page === '...'"
                                    class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl text-gray-300 bg-white border border-gray-100 cursor-not-allowed whitespace-nowrap"
                                >...</span>
                                <button 
                                    v-else
                                    @click="changePage(page)"
                                    class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-colors whitespace-nowrap border"
                                    :class="currentPage === page ? 'bg-primary text-white border-primary shadow-md shadow-primary/20' : 'text-gray-600 bg-white border-gray-200 hover:border-primary hover:text-primary hover:bg-slate-50 shadow-sm'"
                                >{{ page }}</button>
                            </template>

                            <button 
                                @click="changePage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-colors whitespace-nowrap border"
                                :class="currentPage === totalPages ? 'text-gray-300 bg-gray-50 border-gray-100 cursor-not-allowed' : 'text-gray-600 bg-white border-gray-200 hover:border-primary hover:text-primary shadow-sm'"
                            >Selanjutnya</button>
                        </div>

                        <p class="text-sm font-medium text-gray-400 mt-2 text-center">
                            Menampilkan <span class="text-slate-700 font-bold">{{ showingFrom }}</span> - <span class="text-slate-700 font-bold">{{ showingTo }}</span> dari <span class="text-slate-700 font-bold">{{ totalResearch }}</span> data
                        </p>
                    </div>
                </div>

                <div v-else class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm mx-2 sm:mx-4 md:mx-8 mb-16" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4"><FileX2 class="h-10 w-10 text-primary" /></div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Data penelitian dengan kriteria pencarian atau filter tersebut tidak tersedia.</p>
                </div>

            </div>
        </div>

        <Teleport to="body">
            <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="isProgramOpen" id="program-dropdown-menu" :style="programDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden">
                    <a @click="selectOption('program', '')" class="block px-5 py-3 text-sm md:text-base text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': !selectedProgram}">Semua Program Studi</a>
                    <a v-for="p in studyPrograms" :key="p.id" @click="selectOption('program', String(p.id))" class="block px-5 py-3 text-sm md:text-base text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedProgram === String(p.id)}">{{ p.name }}</a>
                </div>
            </transition>
        </Teleport>

        <Teleport to="body">
            <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="isYearOpen" id="year-dropdown-menu" :style="yearDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden">
                    <a @click="selectOption('year', '')" class="block px-5 py-3 text-sm md:text-base text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': !selectedYear}">Semua Tahun</a>
                    <a v-for="y in years" :key="y" @click="selectOption('year', y)" class="block px-5 py-3 text-sm md:text-base text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedYear === y}">Tahun {{ y }}</a>
                </div>
            </transition>
        </Teleport>
    </PublicLayout>
</template>