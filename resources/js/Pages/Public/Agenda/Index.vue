<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
// PERBAIKAN: Mengganti BuildingOfficeIcon menjadi Building
import { CalendarIcon, MapPinIcon, ClockIcon, Building, Search, ChevronDown, ListFilter, X } from 'lucide-vue-next';

const props = defineProps({ groupedAgendas: Object });
const searchQuery = ref('');
const selectedYear = ref('Semua');

const allYears = computed(() => {
    const years = new Set();
    Object.values(props.groupedAgendas).forEach(monthList => monthList.forEach(a => years.add(new Date(a.start_date).getFullYear().toString())));
    return ['Semua', ...Array.from(years).sort((a, b) => b - a)];
});

// --- Teleport Dropdown Logic ---
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

const filteredGroupedAgendas = computed(() => {
    const filtered = {};
    const query = searchQuery.value.toLowerCase();
    Object.keys(props.groupedAgendas).forEach(month => {
        const matched = props.groupedAgendas[month].filter(a => a.title.toLowerCase().includes(query) && (selectedYear.value === 'Semua' || new Date(a.start_date).getFullYear().toString() === selectedYear.value));
        if (matched.length > 0) filtered[month] = matched;
    });
    return filtered;
});

const formatDay = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit' });
const formatMonth = (d) => new Date(d).toLocaleDateString('id-ID', { month: 'short' }).toUpperCase();
const formatDateLengkap = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
</script>

<template>
    <PublicLayout>
        <Head title="Agenda Fakultas" />
        <Banner title="AGENDA FAKULTAS" subtitle="Jadwal Resmi, Kegiatan Institusi, dan Akademik FSTI" background-image="/images/background-banner.png" />

        <div class="bg-slate-50 py-16 md:py-24 min-h-screen font-public-sans">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="mb-14 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4">
                    <div class="relative flex-grow">
                        <input v-model="searchQuery" type="text" placeholder="Cari agenda fakultas..." class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:border-primary focus:ring-primary bg-gray-50 text-gray-800 font-medium">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"><X class="w-5 h-5" /></button>
                    </div>
                    <div class="relative md:w-80">
                        <button ref="dropdownRef" @click="toggleDropdown" class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between">
                            <span class="truncate">{{ selectedYear === 'Semua' ? 'Semua Tahun' : 'Tahun ' + selectedYear }}</span>
                            <ChevronDown class="w-5 h-5 text-gray-400" :class="{'rotate-180': isOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="ease-out duration-100" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-75" leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <div v-if="isOpen" id="teleport-agenda" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-gray-100 py-2">
                            <a v-for="y in allYears" :key="y" @click="selectYear(y)" class="block px-5 py-3 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer" :class="{'bg-primary/5 text-primary': selectedYear === y}">{{ y === 'Semua' ? 'Semua Tahun' : 'Tahun ' + y }}</a>
                        </div>
                    </transition>
                </Teleport>

                <div v-if="Object.keys(filteredGroupedAgendas).length === 0" class="text-center py-24 bg-white rounded-[2rem] border border-gray-100 shadow-sm" data-aos="fade-up">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <CalendarIcon class="w-12 h-12 text-gray-300" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Agenda Tidak Ditemukan</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Mungkin agenda yang Anda cari belum dijadwalkan pada tahun tersebut.</p>
                    <button @click="searchQuery = ''; selectedYear = 'Semua'" class="mt-6 px-6 py-2.5 bg-blue-50 text-primary font-bold rounded-xl hover:bg-blue-100 transition-colors">
                        Reset Pencarian
                    </button>
                </div>

                <div v-for="(list, monthYear) in filteredGroupedAgendas" :key="monthYear" class="mb-16">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-10 h-1.5 bg-primary rounded-full"></div>
                        <h2 class="text-3xl font-optimus font-bold text-gray-900">{{ monthYear }}</h2>
                        <div class="flex-grow h-px bg-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="agenda in list" :key="agenda.id" class="bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:border-primary/30 transform hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                            
                            <div class="h-28 bg-gradient-to-r from-primary to-primary-hover rounded-t-[2rem] relative overflow-hidden">
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                                <div class="absolute -bottom-6 left-6 bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 z-10 flex flex-col items-center justify-center w-[76px] h-[76px] pb-3.5 group-hover:scale-105 transition-all">
                                    <span class="text-[10px] font-bold uppercase text-gray-500 mb-1 mt-1">{{ formatMonth(agenda.start_date) }}</span>
                                    <span class="text-3xl font-black font-optimus text-primary">{{ formatDay(agenda.start_date) }}</span>
                                </div>
                            </div>

                            <div class="pt-10 pb-6 px-6 flex-grow flex flex-col bg-slate-50/50 rounded-b-[2rem]">
                                <div class="mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-primary font-bold rounded-lg text-[10px] uppercase border border-blue-100">
                                        <Building class="w-3 h-3" /> {{ agenda.organizer || 'FSTI ITK' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors line-clamp-3">{{ agenda.title }}</h3>
                                <p v-if="agenda.description" class="text-sm text-gray-500 line-clamp-2 mb-6">{{ agenda.description }}</p>

                                <div class="mt-auto space-y-2.5 pt-4 border-t border-gray-200/60">
                                    <div v-if="agenda.end_date" class="flex items-start gap-2.5 text-sm font-medium text-gray-500">
                                        <ClockIcon class="w-4 h-4 text-gray-400" /> <span>s.d {{ formatDateLengkap(agenda.end_date) }}</span>
                                    </div>
                                    <div v-if="agenda.location" class="flex items-start gap-2.5 text-sm font-medium text-gray-500">
                                        <MapPinIcon class="w-4 h-4 text-gray-400" /> <span class="line-clamp-2">{{ agenda.location }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>