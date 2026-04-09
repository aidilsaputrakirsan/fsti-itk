<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { CalendarIcon, MapPinIcon, ClockIcon, Building, Search, ChevronDown, ListFilter, X, CalendarDays } from 'lucide-vue-next';

const props = defineProps({ groupedAgendas: Object });
const searchQuery = ref('');
const selectedYear = ref('Semua');

const allYears = computed(() => {
    const years = new Set();
    Object.values(props.groupedAgendas).forEach(monthList => monthList.forEach(a => years.add(new Date(a.start_date).getFullYear().toString())));
    return ['Semua', ...Array.from(years).sort((a, b) => b - a)];
});

const isOpen = ref(false);
const dropdownRef = ref(null);
const dropdownStyle = ref({});
const selectYear = (y) => { selectedYear.value = y; isOpen.value = false; };
const toggleDropdown = () => {
    if (isOpen.value) { isOpen.value = false; } else {
        const btn = dropdownRef.value;
        if (btn) dropdownStyle.value = { position: 'absolute', top: `${btn.getBoundingClientRect().bottom + window.scrollY + 8}px`, left: `${btn.getBoundingClientRect().left}px`, width: `${btn.getBoundingClientRect().width}px` };
        isOpen.value = true;
    }
};
const handleClickOutside = (e) => { if (dropdownRef.value && !dropdownRef.value.contains(e.target)) { const menu = document.getElementById('teleport-agenda'); if (menu && !menu.contains(e.target)) isOpen.value = false; } };
onMounted(() => document.addEventListener('mousedown', handleClickOutside));
onUnmounted(() => document.removeEventListener('mousedown', handleClickOutside));


const flatAgendas = computed(() => {
    const flat = [];
    Object.entries(props.groupedAgendas).forEach(([monthYear, items]) => {
        items.forEach(item => flat.push({ ...item, monthYear }));
    });
    return flat;
});

const filteredAgendas = computed(() => {
    const query = searchQuery.value.toLowerCase();
    return flatAgendas.value.filter(a =>
        a.title.toLowerCase().includes(query) &&
        (selectedYear.value === 'Semua' || new Date(a.start_date).getFullYear().toString() === selectedYear.value)
    );
});

const itemsPerPage = 6; 
const currentPage = ref(1);

watch([searchQuery, selectedYear], () => {
    currentPage.value = 1;
});

const totalAgendas = computed(() => filteredAgendas.value.length);
const totalPages = computed(() => Math.ceil(totalAgendas.value / itemsPerPage));
const showingFrom = computed(() => totalAgendas.value === 0 ? 0 : (currentPage.value - 1) * itemsPerPage + 1);
const showingTo = computed(() => Math.min(currentPage.value * itemsPerPage, totalAgendas.value));

const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;

    if (total <= 7) {
        return Array.from({ length: total }, (_, i) => i + 1);
    }

    if (current <= 4) {
        return [1, 2, 3, 4, 5, '...', total];
    }

    if (current >= total - 3) {
        return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
    }

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

        <div class="bg-white py-16 md:py-24 min-h-screen font-public-sans">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-primary-hover rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary-hover/50">
                    
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-300/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    <div class="absolute top-[20%] left-[40%] w-[30%] h-[50%] bg-blue-200/15 rounded-full blur-[80px] pointer-events-none"></div>

                    <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-medium mb-6 shadow-sm uppercase tracking-wider">
                            <CalendarDays class="w-4 h-4" /> Agenda Fakultas
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-md">Lihat Agenda<br/>Fakultas Kami</h2>
                        <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90">
                            Temukan berbagai jadwal penting kegiatan resmi di lingkungan Fakultas Sains dan Teknologi Informasi.
                        </p>
                    </div>

                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform rotate-2 hover:-rotate-2 hover:scale-105 transition-all duration-500 shadow-2xl">
                        <CalendarIcon class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-4 md:mx-8 mb-16 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-blue-50 flex flex-col md:flex-row gap-4">
                    <div class="relative flex-grow">
                        <input v-model="searchQuery" type="text" placeholder="Cari nama agenda atau acara..." class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:border-primary focus:ring-primary focus:ring-2 bg-slate-50 hover:bg-white transition-colors text-slate-800 font-medium">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary"><X class="w-5 h-5" /></button>
                    </div>
                    <div class="relative md:w-80">
                        <button ref="dropdownRef" @click="toggleDropdown" class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between transition-colors focus:border-primary focus:ring-primary focus:ring-2">
                            <span class="truncate">{{ selectedYear === 'Semua' ? 'Semua Tahun' : 'Tahun ' + selectedYear }}</span>
                            <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200" :class="{'rotate-180': isOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <div v-if="isOpen" id="teleport-agenda" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 overflow-hidden">
                            <a v-for="y in allYears" :key="y" @click="selectYear(y)" class="block px-5 py-3 font-medium hover:bg-blue-50 hover:text-primary transition-colors cursor-pointer" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedYear === y}">
                                {{ y === 'Semua' ? 'Tampilkan Semua Tahun' : 'Tahun ' + y }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

                <div v-if="filteredAgendas.length === 0" class="text-center py-20 bg-slate-50/50 rounded-[2rem] border border-dashed border-blue-200 shadow-sm" data-aos="fade-up">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-blue-50">
                        <CalendarIcon class="w-10 h-10 text-primary/40" />
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Agenda Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Mungkin agenda yang Anda cari belum dijadwalkan pada tahun tersebut.</p>
                    <button @click="searchQuery = ''; selectedYear = 'Semua'" class="mt-6 px-8 py-3 bg-blue-50 text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition-all duration-300 shadow-sm">
                        Reset Pencarian
                    </button>
                </div>

                <div v-for="(list, monthYear) in paginatedGroupedAgendas" :key="monthYear" class="mb-16">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-12 h-1.5 bg-primary rounded-full"></div>
                        <h2 class="text-3xl font-optimus font-bold text-slate-800 tracking-wide">{{ monthYear }}</h2>
                        <div class="flex-grow h-px bg-blue-100"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="agenda in list" :key="agenda.id" class="flex flex-col bg-white rounded-[1.5rem] border border-blue-50 shadow-[0_4px_20px_rgba(47,77,211,0.04)] hover:shadow-[0_12px_30px_rgba(47,77,211,0.12)] hover:border-primary/30 transform hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                            
                            <div class="bg-blue-50/50 px-6 py-4 flex items-center justify-between border-b border-blue-100">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                        <CalendarIcon class="w-4 h-4 text-primary" />
                                    </div>
                                    <span class="text-xs font-bold text-primary tracking-widest">{{ formatMonth(agenda.start_date) }}</span>
                                </div>
                                <div class="bg-white text-primary px-3 py-1.5 rounded-lg font-black text-xl shadow-sm border border-blue-100 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                                    {{ formatDay(agenda.start_date) }}
                                </div>
                            </div>

                            <div class="p-6 flex-grow flex flex-col bg-white">
                                <div class="mb-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 text-primary font-semibold rounded-md text-[11px] uppercase border border-slate-100 tracking-wider">
                                        <Building class="w-3.5 h-3.5" /> {{ agenda.organizer || 'FSTI ITK' }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-3 group-hover:text-primary transition-colors leading-snug">{{ agenda.title }}</h3>
                                
                                <p v-if="agenda.description" class="text-sm text-slate-500 mb-6 leading-relaxed">{{ agenda.description }}</p>

                                <div class="mt-auto space-y-3 pt-5 border-t border-slate-100">
                                    <div v-if="agenda.end_date" class="flex items-start gap-3 text-sm text-slate-600">
                                        <div class="mt-0.5"><ClockIcon class="w-4 h-4 text-primary/70" /></div>
                                        <span>S.d <span class="font-semibold text-slate-700">{{ formatDateLengkap(agenda.end_date) }}</span></span>
                                    </div>
                                    <div v-if="agenda.location" class="flex items-start gap-3 text-sm text-slate-600">
                                        <div class="mt-0.5"><MapPinIcon class="w-4 h-4 text-primary/70" /></div>
                                        <span>{{ agenda.location }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="totalPages > 1" class="mt-16 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-gray-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-gray-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ showingFrom }}</span> - <span class="text-primary font-bold">{{ showingTo }}</span> dari <span class="text-primary font-bold">{{ totalAgendas }}</span> Agenda
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button 
                            @click="changePage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                            :class="currentPage === 1 ? 'text-gray-300 bg-gray-50/50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                            v-html="'&laquo; Sebelumnya'"
                        ></button>

                        <template v-for="(page, index) in visiblePages" :key="index">
                            <span 
                                v-if="page === '...'"
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full text-gray-300 bg-gray-50/50 cursor-not-allowed"
                            >
                                ...
                            </span>
                            <button 
                                v-else
                                @click="changePage(page)"
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                                :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                            >
                                {{ page }}
                            </button>
                        </template>

                        <button 
                            @click="changePage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                            :class="currentPage === totalPages ? 'text-gray-300 bg-gray-50/50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                            v-html="'Selanjutnya &raquo;'"
                        ></button>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>