<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { router, Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Search, FileWarning, BookOpen, ChevronDown, LibraryBig, ListFilter, X, FlaskConical } from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { debounce } from 'lodash';

const props = defineProps<{
  penelitians: any;
  stats: { total: number };
  filters: any;
  years: string[];
  prodis: { id: number; name: string }[];
}>();

const bannerImage = '/images/background-banner.png';
const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year || '');
const selectedProdi = ref(props.filters.prodi || '');

watch(search, debounce(() => { applyFilters(); }, 500));
watch([selectedYear, selectedProdi], () => { applyFilters(); });

// --- Teleport Dropdown Logic ---
const isYearOpen = ref(false);
const isProdiOpen = ref(false);

const yearBtnRef = ref<HTMLButtonElement | null>(null);
const prodiBtnRef = ref<HTMLButtonElement | null>(null);

const yearDropdownStyle = ref({});
const prodiDropdownStyle = ref({});

const selectedProdiName = computed(() => {
    if (!selectedProdi.value) return '';
    const p = props.prodis.find((x) => x.id == selectedProdi.value);
    return p ? p.name : '';
});

const toggleDropdown = (type: 'year' | 'prodi') => {
    const refs = { year: yearBtnRef, prodi: prodiBtnRef };
    const isOpenRefs = { year: isYearOpen, prodi: isProdiOpen };
    const styleRefs = { year: yearDropdownStyle, prodi: prodiDropdownStyle };

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

function selectOption(type: 'year' | 'prodi', value: string) {
    if (type === 'year') { selectedYear.value = value; isYearOpen.value = false; }
    else if (type === 'prodi') { selectedProdi.value = value; isProdiOpen.value = false; }
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
    check(prodiBtnRef, 'prodi-dropdown-menu', isProdiOpen);
};

onMounted(() => { AOS.init({ duration: 800, once: true }); document.addEventListener('mousedown', handleClickOutside); });
onUnmounted(() => { document.removeEventListener('mousedown', handleClickOutside); });

const applyFilters = () => {
    router.get(route('penelitian.index'), { search: search.value, year: selectedYear.value, prodi: selectedProdi.value }, { preserveState: true, replace: true });
};

const resetSearch = () => { search.value = ''; };

// --- Smart Pagination Logic ---
const currentPage = computed<number>(() => props.penelitians?.current_page || 1);
const totalPages = computed<number>(() => props.penelitians?.last_page || 1);
const showingFrom = computed<number>(() => props.penelitians?.from || 0);
const showingTo = computed<number>(() => props.penelitians?.to || 0);
const totalPenelitians = computed<number>(() => props.penelitians?.total || 0);

const visiblePages = computed(() => {
    const total = totalPages.value; const current = currentPage.value;
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    if (current <= 4) return [1, 2, 3, 4, 5, '...', total];
    if (current >= total - 3) return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
    return [1, '...', current - 1, current, current + 1, '...', total];
});

const changePage = (page: number | string) => {
    if (typeof page === 'number' && page >= 1 && page <= totalPages.value) {
        router.get(route('penelitian.index'), { search: search.value, year: selectedYear.value, prodi: selectedProdi.value, page: page }, { preserveState: true, replace: true, onFinish: () => { window.scrollTo({ top: 450, behavior: 'smooth' }); } });
    }
};

const prevPage = () => changePage(currentPage.value - 1);
const nextPage = () => changePage(currentPage.value + 1);
</script>

<template>
    <PublicLayout>
        <Head title="Penelitian - FSTI ITK" />
        <Banner title="Direktori Penelitian" subtitle="PANGKALAN DATA INOVASI DOSEN FSTI ITK" :background-image="bannerImage" />

        <div class="bg-white -16 md:py-24 font-public-sans min-h-screen overflow-x-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary to-primary-hover rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary-hover/50">
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-300/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    <div class="absolute top-[20%] left-[40%] w-[30%] h-[50%] bg-blue-200/15 rounded-full blur-[80px] pointer-events-none"></div>

                   <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-bold mb-6 shadow-sm uppercase tracking-wider">
                            <FlaskConical class="w-4 h-4" /> Riset
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm">Direktori Penelitian<br/>Dosen FSTI</h2>
                        <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90">
                            Temukan rekam jejak penelitian dan inovasi dari para dosen di Fakultas Sains dan Teknologi Informasi.
                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 hover:scale-105 transition-all duration-500 shadow-2xl">
                        <BookOpen class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-4 md:mx-8 mb-16 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari judul penelitian atau nama dosen..." 
                            class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 text-slate-800 font-medium hover:bg-white transition-colors"
                            v-model="search"
                        >
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
                        <button v-if="search" @click="resetSearch" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="relative md:w-72">
                        <button 
                            ref="prodiBtnRef"
                            @click="toggleDropdown('prodi')"
                            class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
                        >
                            <span class="truncate">{{ selectedProdiName || 'Semua Program Studi' }}</span>
                            <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200" :class="{'rotate-180': isProdiOpen}" />
                        </button>
                        <LibraryBig class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>

                    <div class="relative md:w-48">
                        <button 
                            ref="yearBtnRef"
                            @click="toggleDropdown('year')"
                            class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
                        >
                            <span class="truncate">{{ selectedYear || 'Semua Tahun' }}</span>
                            <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200" :class="{'rotate-180': isYearOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>

                </div>

                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgba(0,53,102,0.04)] border border-slate-100 overflow-hidden mx-2 md:mx-8 mb-16" data-aos="fade-up">
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
                                <tr v-for="(item, index) in penelitians.data" :key="item.id" class="hover:bg-slate-50/80 transition-colors duration-200 group">
                                    <td class="px-6 py-4 text-center text-slate-600 font-bold text-sm">{{ Number(showingFrom) + Number(index) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800 group-hover:text-primary transition-colors">{{ item.nama_dosen }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 leading-relaxed font-medium">
                                        {{ item.judul }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1.5 bg-slate-50 border border-slate-100 text-slate-600 rounded-lg font-semibold group-hover:bg-blue-50 group-hover:text-primary group-hover:border-blue-100 transition-colors">
                                            {{ item.study_program?.name || 'FSTI' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-14 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-sm group-hover:bg-[#D9FFFE]/80 group-hover:text-[#00509D] transition-colors">
                                            {{ item.tahun }}
                                        </span>
                                    </td>
                                </tr>
                                
                                <tr v-if="penelitians.data.length === 0">
                                    <td colspan="5" class="py-20 text-center bg-white hover:bg-white cursor-default">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-sm">
                                            <FileWarning class="w-8 h-8 text-slate-300" />
                                        </div>
                                        <h3 class="text-xl font-bold text-slate-800 mb-2 font-optimus">Penelitian Tidak Ditemukan</h3>
                                        <p class="text-sm text-slate-500">Silakan sesuaikan kembali kata kunci pencarian atau filter yang Anda gunakan.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-if="totalPages > 1" class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-[0_8px_30px_rgba(47,77,211,0.04)] border border-slate-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-slate-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ showingFrom }}</span> - <span class="text-primary font-bold">{{ showingTo }}</span> dari <span class="text-primary font-bold">{{ totalPenelitians }}</span> Penelitian
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button 
                            @click="prevPage()"
                            :disabled="currentPage === 1"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                            :class="currentPage === 1 ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'"
                            v-html="'&laquo; Previous'"
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
                            @click="nextPage()"
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
            <div v-if="isProdiOpen" id="prodi-dropdown-menu" :style="prodiDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden">
                <a @click="selectOption('prodi', '')" class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': !selectedProdi}">Semua Program Studi</a>
                <a v-for="p in prodis" :key="p.id" @click="selectOption('prodi', String(p.id))" class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedProdi === String(p.id)}">{{ p.name }}</a>
            </div>
        </transition>
    </Teleport>

    <Teleport to="body">
        <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isYearOpen" id="year-dropdown-menu" :style="yearDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden">
                <a @click="selectOption('year', '')" class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': !selectedYear}">Semua Tahun</a>
                <a v-for="y in years" :key="y" @click="selectOption('year', y)" class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedYear === y}">Tahun {{ y }}</a>
            </div>
        </transition>
    </Teleport>
</template>