<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
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
    X 
} from 'lucide-vue-next';

const props = defineProps({
    groupedKegiatan: Object
});

// State untuk Pencarian dan Filter Tahun
const searchQuery = ref('');
const selectedYear = ref('Semua');

// Ekstrak daftar Tahun secara dinamis dari database untuk Dropdown
const allYears = computed(() => {
    const years = new Set();
    Object.values(props.groupedKegiatan).forEach(monthList => {
        monthList.forEach(keg => {
            const year = new Date(keg.start_date).getFullYear().toString();
            years.add(year);
        });
    });
    // Urutkan tahun menurun (2026, 2025, 2024...)
    const sortedYears = Array.from(years).sort((a, b) => b - a);
    return ['Semua', ...sortedYears];
});

// --- LOGIKA DROPDOWN KUSTOM (Persis Menu Berita) ---
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
    document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside);
});
// ----------------------------------------------------------------------

// Logika Filter Real-Time
const filteredGroupedKegiatan = computed(() => {
    const filtered = {};
    const query = searchQuery.value.toLowerCase();
    const yearFilter = selectedYear.value;

    Object.keys(props.groupedKegiatan).forEach(month => {
        const matchedEvents = props.groupedKegiatan[month].filter(keg => {
            const matchTitle = keg.title.toLowerCase().includes(query);
            const eventYear = new Date(keg.start_date).getFullYear().toString();
            const matchYear = yearFilter === 'Semua' || eventYear === yearFilter;
            
            return matchTitle && matchYear;
        });

        if (matchedEvents.length > 0) {
            filtered[month] = matchedEvents;
        }
    });

    return filtered;
});

// Format Tanggal
const formatDay = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('id-ID', { day: '2-digit' });
};

const formatMonth = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('id-ID', { month: 'short' }).toUpperCase();
};

const formatDateLengkap = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
};
</script>

<template>
    <PublicLayout>
        <Head title="Kegiatan Mahasiswa" />
        
        <Banner
            title="KEGIATAN MAHASISWA"
            subtitle="Agenda, Event, dan Aktivitas Organisasi Kemahasiswaan FSTI"
            background-image="/images/background-banner.png"
        />

        <div class="bg-slate-50 py-16 md:py-24 min-h-screen font-public-sans overflow-x-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="mb-14 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari nama kegiatan atau event..." 
                            class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium transition-all"
                            v-model="searchQuery"
                        >
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="relative md:w-80">
                        <button 
                            ref="dropdownRef"
                            @click="toggleDropdown"
                            class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all"
                        >
                            <span class="truncate">{{ selectedYear === 'Semua' ? 'Semua Tahun' : 'Tahun ' + selectedYear }}</span>
                            <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div v-if="isOpen" id="teleported-dropdown-kegiatan" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-gray-100 py-2 font-public-sans">
                            <a 
                                v-for="year in allYears" 
                                :key="year" 
                                @click="selectYear(year)" 
                                class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" 
                                :class="{'bg-primary/5 text-primary': selectedYear === year}"
                            >
                                {{ year === 'Semua' ? 'Semua Tahun' : 'Tahun ' + year }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

                <div v-if="Object.keys(filteredGroupedKegiatan).length === 0" class="text-center py-24 bg-white rounded-[2rem] border border-gray-100 shadow-sm" data-aos="fade-up">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <CalendarIcon class="w-12 h-12 text-gray-300" />
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Kegiatan Tidak Ditemukan</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Mungkin kegiatan yang Anda cari belum dijadwalkan pada tahun tersebut, atau coba kata kunci lain.</p>
                    <button @click="searchQuery = ''; selectedYear = 'Semua'" class="mt-6 px-6 py-2.5 bg-blue-50 text-primary font-bold rounded-xl hover:bg-blue-100 transition-colors">
                        Reset Pencarian
                    </button>
                </div>

                <div v-for="(kegiatanList, monthYear) in filteredGroupedKegiatan" :key="monthYear" class="mb-16 last:mb-0">
                    
                    <div class="flex items-center gap-5 mb-8" data-aos="fade-right">
                        <div class="w-10 h-1.5 bg-primary rounded-full shadow-sm"></div>
                        <h2 class="text-3xl font-optimus font-bold text-gray-900 capitalize tracking-wide">{{ monthYear }}</h2>
                        <div class="flex-grow h-px bg-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div 
                            v-for="(keg, index) in kegiatanList" :key="keg.id"
                            class="bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:border-primary/30 transform hover:-translate-y-2 transition-all duration-300 flex flex-col group relative"
                            data-aos="fade-up" :data-aos-delay="(index % 3) * 50"
                        >
                            <div class="h-28 bg-gradient-to-r from-primary to-primary-hover rounded-t-[2rem] relative overflow-hidden">
                                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>

                                <div class="absolute -bottom-6 left-6 bg-white rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-gray-200 z-10 group-hover:scale-105 group-hover:border-primary/40 transition-all duration-300 flex flex-col items-center justify-center w-[76px] h-[76px] pb-3.5">
                                    <span class="text-[10px] font-bold uppercase text-gray-500 leading-none mb-1 mt-1">{{ formatMonth(keg.start_date) }}</span>
                                    <span class="text-3xl font-black font-optimus text-primary leading-none">{{ formatDay(keg.start_date) }}</span>
                                </div>
                            </div>

                            <div class="pt-10 pb-6 px-6 flex-grow flex flex-col bg-slate-50/50 rounded-b-[2rem]">
                                <div class="mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-primary font-bold rounded-lg text-[10px] uppercase tracking-wider border border-blue-100">
                                        <UsersIcon class="w-3 h-3" /> {{ keg.organizer || 'Kemahasiswaan' }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-3 leading-snug">
                                    {{ keg.title }}
                                </h3>
                                
                                <p v-if="keg.description" class="text-sm text-gray-500 line-clamp-2 mb-6 leading-relaxed">
                                    {{ keg.description }}
                                </p>

                                <div class="mt-auto space-y-2.5 pt-4 border-t border-gray-200/60">
                                    <div v-if="keg.end_date" class="flex items-start gap-2.5 text-sm font-medium text-gray-500">
                                        <ClockIcon class="w-4 h-4 shrink-0 mt-0.5 text-gray-400" />
                                        <span>s.d {{ formatDateLengkap(keg.end_date) }}</span>
                                    </div>
                                    <div v-if="keg.location" class="flex items-start gap-2.5 text-sm font-medium text-gray-500">
                                        <MapPinIcon class="w-4 h-4 shrink-0 mt-0.5 text-gray-400" />
                                        <span class="line-clamp-2 leading-tight">{{ keg.location }}</span>
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