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
    BookOpen,
    FileX2
} from 'lucide-vue-next';
import { debounce } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
    alumni: Object,
    filters: Object,
    studyPrograms: Array,
    years: Array
});

const search = ref(props.filters.search || '');
const program = ref(props.filters.program || '');
const selectedYear = ref(props.filters.year || '');

const isFiltering = computed(() => search.value !== '' || program.value !== '' || selectedYear.value !== '');

const isProgramOpen = ref(false);
const isYearOpen = ref(false);

const programBtnRef = ref(null);
const yearBtnRef = ref(null);

const programDropdownStyle = ref({});
const yearDropdownStyle = ref({});

const toggleDropdown = (type) => {
    if (type === 'program') {
        isYearOpen.value = false;
        if (isProgramOpen.value) {
            isProgramOpen.value = false;
        } else {
            const button = programBtnRef.value;
            if (button) {
                const rect = button.getBoundingClientRect();
                programDropdownStyle.value = {
                    position: 'absolute',
                    top: `${rect.bottom + window.scrollY + 8}px`,
                    left: `${rect.left}px`,
                    width: `${rect.width}px`,
                };
            }
            isProgramOpen.value = true;
        }
    } else if (type === 'year') {
        isProgramOpen.value = false;
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
    if (type === 'program') {
        program.value = value;
        isProgramOpen.value = false;
    } else if (type === 'year') {
        selectedYear.value = value;
        isYearOpen.value = false;
    }
}

const handleClickOutside = (event) => {
    if (programBtnRef.value && !programBtnRef.value.contains(event.target)) {
        const menu = document.getElementById('program-dropdown-menu');
        if (menu && !menu.contains(event.target)) isProgramOpen.value = false;
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

watch([search, program, selectedYear], debounce(() => {
    router.get(route('alumni.index'), { 
        search: search.value, 
        program: program.value, 
        year: selectedYear.value 
    }, { 
        preserveState: true, 
        replace: true,
        onFinish: () => { AOS.refresh(); }
    });
}, 400));

const resetFilters = () => {
    search.value = '';
    program.value = '';
    selectedYear.value = '';
};

const currentPage = computed(() => {
    const activeLink = props.alumni.links.find(link => link.active);
    return activeLink ? parseInt(activeLink.label) : 1;
});

const totalPages = computed(() => {
    return props.alumni.links.length > 2 ? props.alumni.links.length - 2 : 1;
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
            search: search.value,
            program: program.value,
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
        <Head title="Direktori Alumni" />
        
        <Banner
            title="DIREKTORI ALUMNI"
            subtitle="Jejak Kelulusan Fakultas Sains dan Teknologi Informasi"
            background-image="/images/background-banner.webp"
        />

        <div class="relative bg-white py-16 md:py-24 font-public-sans min-h-screen overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
                <div class="absolute top-[-10%] left-[-5%] w-[40rem] h-[40rem] bg-primary/5 rounded-full blur-[100px]"></div>
                <div class="absolute top-[20%] right-[-10%] w-[35rem] h-[35rem] bg-blue-400/5 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-[-10%] left-[20%] w-[30rem] h-[30rem] bg-indigo-300/10 rounded-full blur-[120px]"></div>
            </div>

            <div class="container relative z-10 mx-auto px-4 md:px-6 max-w-7xl">

                <div class="relative max-w-3xl mx-auto mb-14 rounded-[2rem] bg-white p-8 md:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 overflow-hidden text-center" data-aos="fade-up">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary/20 to-blue-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-blue-300/20 to-primary/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3 pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="relative w-16 h-16 md:w-20 md:h-20 mb-5">
                            <div class="absolute inset-0 bg-primary/20 rounded-full animate-ping opacity-60"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-white to-blue-50 rounded-full flex items-center justify-center shadow-md border-4 border-white">
                                <GraduationCap class="w-8 h-8 md:w-9 md:h-9 text-primary" />
                            </div>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4 leading-tight">Direktori <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Alumni</span></h2>
                        <p class="text-gray-600 font-medium text-[15px] md:text-[16px] max-w-xl mx-auto leading-relaxed">Temukan data kelulusan, jejak langkah, dan jaringan alumni dari berbagai program studi di Fakultas Sains dan Teknologi Informasi ITK.</p>
                    </div>
                </div>

                <div class="mb-12 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 relative z-20" data-aos="fade-down">
                    
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari berdasarkan nama atau NIM..." 
                            class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium transition-all"
                            v-model="search"
                        >
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600"><X class="w-5 h-5" /></button>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 md:w-[45%]">
                        <div class="relative w-full sm:w-3/5">
                            <button 
                                ref="programBtnRef"
                                @click="toggleDropdown('program')"
                                class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all"
                            >
                                <span class="truncate">{{ program || 'Semua Program Studi' }}</span>
                                <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isProgramOpen}" />
                            </button>
                            <BookOpen class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                        </div>

                        <div class="relative w-full sm:w-2/5">
                            <button 
                                ref="yearBtnRef"
                                @click="toggleDropdown('year')"
                                class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all"
                            >
                                <span class="truncate">{{ selectedYear || 'Semua Tahun' }}</span>
                                <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isYearOpen}" />
                            </button>
                            <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                        </div>
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div v-if="isProgramOpen" id="program-dropdown-menu" :style="programDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-gray-100 py-2 font-public-sans overflow-hidden max-h-60 overflow-y-auto">
                            <a @click="selectOption('program', '')" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': program === ''}">
                                Semua Program Studi
                            </a>
                            <a v-for="p in studyPrograms" :key="p" @click="selectOption('program', p)" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': program === p}">
                                {{ p }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

                <Teleport to="body">
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div v-if="isYearOpen" id="year-dropdown-menu" :style="yearDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-gray-100 py-2 font-public-sans overflow-hidden max-h-60 overflow-y-auto">
                            <a @click="selectOption('year', '')" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': selectedYear === ''}">
                                Semua Tahun
                            </a>
                            <a v-for="year in years" :key="year" @click="selectOption('year', year)" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': selectedYear === year}">
                                {{ year }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

                <div v-if="isFiltering" class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center flex-wrap gap-x-1.5">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span class="text-gray-500 font-medium">Hasil pencarian untuk:</span>
                        <span v-if="search" class="text-primary">"{{ search }}"</span>
                        <span v-if="program" class="px-2.5 py-1 bg-primary/10 text-primary rounded-lg text-sm">{{ program }}</span>
                        <span v-if="selectedYear" class="px-2.5 py-1 bg-[#D9FFFE]/80 text-[#00509D] rounded-lg text-sm">Tahun {{ selectedYear }}</span>
                    </h3>
                    <button @click="resetFilters" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto">Reset Filter</button>
                </div>

                <div v-if="alumni.data.length > 0" class="bg-white rounded-3xl shadow-[0_8px_30px_rgba(0,53,102,0.04)] border border-gray-100 overflow-hidden" data-aos="fade-up">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-gradient-to-r from-primary to-blue-600 border-b border-primary/20">
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider w-32">NIM</th>
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider">Nama Lengkap</th>
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider">Program Studi</th>
                                    <th class="px-6 py-5 font-bold text-sm text-white tracking-wider text-center w-32">Tahun Lulus</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr v-for="item in alumni.data" :key="item.id" class="hover:bg-gray-50/80 transition-colors duration-200 group">
                                    <td class="px-6 py-4 text-gray-600 font-bold text-sm">{{ item.nim }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800 group-hover:text-primary transition-colors">{{ item.name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 rounded-lg font-semibold group-hover:bg-blue-50 group-hover:text-primary group-hover:border-blue-100 transition-colors">
                                            {{ item.study_program }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-14 h-8 rounded-lg bg-gray-100 text-gray-600 font-bold text-sm group-hover:bg-[#D9FFFE]/80 group-hover:text-[#00509D] transition-colors">
                                            {{ item.graduation_year }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-else class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4"><FileX2 class="h-10 w-10 text-primary" /></div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Data alumni dengan kriteria pencarian, program studi, atau tahun lulus tersebut tidak tersedia.</p>
                </div>

                <div v-if="totalPages > 1 && alumni.data.length > 0" class="mt-10 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-gray-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-gray-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ alumni.from }}</span> - <span class="text-primary font-bold">{{ alumni.to }}</span> dari <span class="text-primary font-bold">{{ alumni.total }}</span> Data
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button 
                            @click="changePage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-all duration-300"
                            :class="currentPage === 1 ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                            v-html="'&laquo; Sebelumnya'"
                        ></button>

                        <template v-for="(page, index) in visiblePages" :key="index">
                            <span 
                                v-if="page === '...'"
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-xl text-gray-300 bg-gray-50 cursor-not-allowed"
                            >
                                ...
                            </span>
                            <button 
                                v-else
                                @click="changePage(page)"
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-all duration-300"
                                :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                            >
                                {{ page }}
                            </button>
                        </template>

                        <button 
                            @click="changePage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-all duration-300"
                            :class="currentPage === totalPages ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                            v-html="'Selanjutnya &raquo;'"
                        ></button>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>