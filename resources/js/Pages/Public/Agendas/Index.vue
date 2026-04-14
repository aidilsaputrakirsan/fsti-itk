<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, router } from '@inertiajs/vue3';
import { CalendarIcon, MapPinIcon, ClockIcon, Building, Search, ChevronDown, ListFilter, X, CalendarDays, FileX2 } from 'lucide-vue-next';
import { debounce } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({ groupedAgendas: Object });

const search = ref('');
const selectedYear = ref('Semua');

const isFiltering = computed(() => search.value !== '' || selectedYear.value !== 'Semua');

const allYears = computed(() => {
    const years = new Set();
    Object.values(props.groupedAgendas).forEach(monthList => monthList.forEach(a => years.add(new Date(a.start_date).getFullYear().toString())));
    return ['Semua', ...Array.from(years).sort((a, b) => b - a)];
});

const isOpen = ref(false);
const dropdownRef = ref(null);
const dropdownStyle = ref({});

function selectYear(y) { 
    selectedYear.value = y; 
    isOpen.value = false; 
}

function toggleDropdown() {
    if (isOpen.value) { 
        isOpen.value = false; 
    } else {
        const btn = dropdownRef.value;
        if (btn) {
            dropdownStyle.value = { 
                position: 'absolute', 
                top: `${btn.getBoundingClientRect().bottom + window.scrollY + 8}px`, 
                left: `${btn.getBoundingClientRect().left}px`, 
                width: `${btn.getBoundingClientRect().width}px` 
            };
        }
        isOpen.value = true;
    }
};

const handleClickOutside = (e) => { 
    if (dropdownRef.value && !dropdownRef.value.contains(e.target)) { 
        const menu = document.getElementById('teleport-agenda'); 
        if (menu && !menu.contains(e.target)) isOpen.value = false; 
    } 
};

onMounted(() => { 
    AOS.init({ duration: 800, once: true }); 
    document.addEventListener('mousedown', handleClickOutside); 
});

onUnmounted(() => { 
    document.removeEventListener('mousedown', handleClickOutside); 
});

const flatAgendas = computed(() => {
    const flat = [];
    Object.entries(props.groupedAgendas).forEach(([monthYear, items]) => {
        items.forEach(item => flat.push({ ...item, monthYear }));
    });
    return flat;
});

const filteredAgendas = computed(() => {
    const query = search.value.toLowerCase();
    return flatAgendas.value.filter(a =>
        a.title.toLowerCase().includes(query) &&
        (selectedYear.value === 'Semua' || new Date(a.start_date).getFullYear().toString() === selectedYear.value)
    );
});

const itemsPerPage = 6; 
const currentPage = ref(1);

watch([search, selectedYear], debounce(() => {
    currentPage.value = 1;
    setTimeout(() => { AOS.refresh(); }, 50);
}, 400));

const totalAgendas = computed(() => filteredAgendas.value.length);
const totalPages = computed(() => Math.ceil(totalAgendas.value / itemsPerPage));
const showingFrom = computed(() => totalAgendas.value === 0 ? 0 : (currentPage.value - 1) * itemsPerPage + 1);
const showingTo = computed(() => Math.min(currentPage.value * itemsPerPage, totalAgendas.value));

const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;

    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    if (current <= 4) return [1, 2, 3, 4, 5, '...', total];
    if (current >= total - 3) return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
    return [1, '...', current - 1, current, current + 1, '...', total];
});

const paginatedAgendas = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredAgendas.value.slice(start, end);
});

const paginatedGroupedAgendas = computed(() => {
    const grouped = {};
    paginatedAgendas.value.forEach(a => {
        if (!grouped[a.monthYear]) {
            grouped[a.monthYear] = [];
        }
        grouped[a.monthYear].push(a);
    });
    return grouped;
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        window.scrollTo({ top: 450, behavior: 'smooth' }); 
    }
};

const formatDay = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit' });
const formatMonth = (d) => new Date(d).toLocaleDateString('id-ID', { month: 'long' }).toUpperCase();
const formatDateLengkap = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
</script>

<template>
    <PublicLayout>
        <Head title="Agenda Fakultas" />
        <Banner title="AGENDA FAKULTAS" subtitle="Jadwal Resmi, Kegiatan Institusi, dan Akademik FSTI" background-image="/images/background-banner.png" />

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
                                <CalendarDays class="w-8 h-8 md:w-9 md:h-9 text-primary" />
                            </div>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4 leading-tight">Jadwal <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Kegiatan</span></h2>
                        <p class="text-gray-600 font-medium text-[15px] md:text-[16px] max-w-xl mx-auto leading-relaxed">Temukan berbagai jadwal penting kegiatan resmi di lingkungan Fakultas Sains dan Teknologi Informasi ITK.</p>
                    </div>
                </div>

                <div class="mb-12 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 relative z-20" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input type="text" placeholder="Cari nama agenda atau acara..." v-model="search" class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium transition-all">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600"><X class="w-5 h-5" /></button>
                    </div>
                    <div class="relative md:w-80">
                        <button ref="dropdownRef" @click="toggleDropdown" class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all">
                            <span class="truncate">{{ selectedYear === 'Semua' ? 'Semua Tahun' : 'Tahun ' + selectedYear }}</span>
                            <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div v-if="isOpen" id="teleport-agenda" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-gray-100 py-2 font-public-sans">
                            <a v-for="y in allYears" :key="y" @click="selectYear(y)" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': selectedYear === y}">
                                {{ y === 'Semua' ? 'Tampilkan Semua Tahun' : 'Tahun ' + y }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

                <div v-if="isFiltering" class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span v-if="search && selectedYear !== 'Semua'">Pencarian <span class="text-primary">"{{ search }}"</span> pada Tahun <span class="text-primary">"{{ selectedYear }}"</span></span>
                        <span v-else-if="search">Hasil pencarian untuk <span class="text-primary">"{{ search }}"</span></span>
                        <span v-else-if="selectedYear !== 'Semua'">Semua agenda Tahun <span class="text-primary">{{ selectedYear }}</span></span>
                    </h3>
                    <button @click="search = ''; selectYear('Semua')" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto">Reset Filter</button>
                </div>

                <div v-if="filteredAgendas.length > 0" class="space-y-16">
                    <div v-for="(list, monthYear) in paginatedGroupedAgendas" :key="monthYear" data-aos="fade-up">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-3 h-10 bg-primary rounded-full"></div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ monthYear }}</h3>
                            <div class="h-px bg-gray-300 flex-grow ml-4"></div>
                            <span class="text-sm font-bold text-gray-500 bg-gray-100 px-4 py-1.5 rounded-full">{{ list.length }} Agenda</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8">
                            <div v-for="agenda in list" :key="agenda.id" class="flex flex-col bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-1.5 transition-all duration-500 overflow-hidden group">
                                
                                <div class="bg-primary/5 px-6 py-4 flex items-center justify-between border-b border-gray-100">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm">
                                            <CalendarIcon class="w-4 h-4 text-primary" />
                                        </div>
                                        <span class="text-xs font-bold text-primary tracking-widest">{{ formatMonth(agenda.start_date) }}</span>
                                    </div>
                                    <div class="bg-white text-primary px-3 py-1.5 rounded-lg font-black text-xl shadow-sm border border-gray-100 group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-colors duration-300">
                                        {{ formatDay(agenda.start_date) }}
                                    </div>
                                </div>

                                <div class="p-6 flex-grow flex flex-col bg-white">
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-primary font-semibold rounded-md text-[11px] uppercase border border-gray-100 tracking-wider">
                                            <Building class="w-3.5 h-3.5" /> {{ agenda.organizer || 'FSTI ITK' }}
                                        </span>
                                    </div>
                                    <h3 class="text-[17px] font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors leading-snug">{{ agenda.title }}</h3>
                                    
                                    <p v-if="agenda.description" class="text-sm text-gray-500 mb-6 leading-relaxed line-clamp-3">{{ agenda.description }}</p>

                                    <div class="mt-auto space-y-3 pt-5 border-t border-gray-100">
                                        <div v-if="agenda.end_date" class="flex items-start gap-3 text-sm text-gray-600">
                                            <div class="mt-0.5"><ClockIcon class="w-4 h-4 text-gray-400" /></div>
                                            <span>S.d <span class="font-semibold text-gray-700">{{ formatDateLengkap(agenda.end_date) }}</span></span>
                                        </div>
                                        <div v-if="agenda.location" class="flex items-start gap-3 text-sm text-gray-600">
                                            <div class="mt-0.5"><MapPinIcon class="w-4 h-4 text-gray-400" /></div>
                                            <span>{{ agenda.location }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="totalPages > 1" class="mt-16 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-[2rem] shadow-sm border border-gray-100" data-aos="fade-in">
                        <p class="text-sm font-medium text-gray-500 text-center md:text-left">
                            Menampilkan <span class="text-primary font-bold">{{ showingFrom }}</span> - <span class="text-primary font-bold">{{ showingTo }}</span> dari <span class="text-primary font-bold">{{ totalAgendas }}</span> Agenda
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

                <div v-else class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4"><FileX2 class="h-10 w-10 text-primary" /></div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Agenda dengan kriteria pencarian atau tahun tersebut tidak tersedia.</p>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>