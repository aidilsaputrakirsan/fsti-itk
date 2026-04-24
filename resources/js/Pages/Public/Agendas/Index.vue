<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, router } from '@inertiajs/vue3';
import { CalendarIcon, MapPinIcon, ClockIcon, Building, Search, ChevronDown, ListFilter, X, CalendarDays, FileX2, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { debounce } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({ 
    groupedAgendas: {
        type: [Object, Array],
        default: () => ({})
    }
});

const search = ref('');
const selectedYear = ref('Semua');

const isFiltering = computed(() => search.value !== '' || selectedYear.value !== 'Semua');

const allYears = computed(() => {
    const years = new Set();
    Object.values(props.groupedAgendas || {}).forEach(monthList => {
        monthList.forEach(a => {
            if(a.start_date) years.add(a.start_date.split('-')[0]); 
        });
    });
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
    Object.entries(props.groupedAgendas || {}).forEach(([monthYear, items]) => {
        items.forEach(item => flat.push({ ...item, monthYear }));
    });
    return flat;
});

const filteredAgendas = computed(() => {
    const query = search.value.toLowerCase();
    return flatAgendas.value.filter(a => {
        const matchTitle = a.title.toLowerCase().includes(query);
        const eventYear = a.start_date ? a.start_date.split('-')[0] : '';
        const matchYear = selectedYear.value === 'Semua' || eventYear === selectedYear.value;
        return matchTitle && matchYear;
    });
});

const itemsPerPage = 6; 
const currentPage = ref(1);

const totalAgendas = computed(() => filteredAgendas.value.length);
const totalPages = computed(() => Math.ceil(totalAgendas.value / itemsPerPage) || 1);
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
        window.scrollTo({ top: 750, behavior: 'smooth' }); 
    }
};

const formatDay = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit' });
const formatMonth = (d) => new Date(d).toLocaleDateString('id-ID', { month: 'short' }).toUpperCase();
const formatDateLengkap = (d) => new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

const currentDate = ref(new Date());
const selectedDateObj = ref(null); 
const isDetailModalOpen = ref(false);

const isPickerOpen = ref(false);
const pickerYear = ref(currentDate.value.getFullYear());

const daysInMonth = (year, month) => new Date(year, month + 1, 0).getDate();
const firstDayOfMonth = (year, month) => new Date(year, month, 1).getDay();

const monthNames = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
];

const activeMonths = computed(() => {
    const months = new Set();
    filteredAgendas.value.forEach(a => {
        if (a.start_date) {
            const startStr = a.start_date.split(' ')[0];
            const endStr = a.end_date ? a.end_date.split(' ')[0] : startStr;
            
            const [sy, sm, sd] = startStr.split('-');
            const start = new Date(parseInt(sy), parseInt(sm) - 1, parseInt(sd));
            
            const [ey, em, ed] = endStr.split('-');
            const end = new Date(parseInt(ey), parseInt(em) - 1, parseInt(ed));
            
            let curr = new Date(start.getFullYear(), start.getMonth(), 1);
            const limit = new Date(end.getFullYear(), end.getMonth(), 1);
            
            while (curr <= limit) {
                months.add(`${curr.getFullYear()}-${curr.getMonth()}`);
                curr.setMonth(curr.getMonth() + 1);
            }
        }
    });
    return Array.from(months).map(str => {
        const [y, m] = str.split('-');
        return { year: parseInt(y), month: parseInt(m), time: parseInt(y) * 12 + parseInt(m) };
    }).sort((a, b) => a.time - b.time);
});

const currentMonthTime = computed(() => currentDate.value.getFullYear() * 12 + currentDate.value.getMonth());

const hasNextMonth = computed(() => activeMonths.value.some(m => m.time > currentMonthTime.value));
const hasPrevMonth = computed(() => activeMonths.value.some(m => m.time < currentMonthTime.value));

watch([search, selectedYear], debounce(() => {
    currentPage.value = 1;
    if (activeMonths.value.length > 0) {
        const firstActive = activeMonths.value[0];
        currentDate.value = new Date(firstActive.year, firstActive.month, 1);
    }
    setTimeout(() => { AOS.refresh(); }, 50);
}, 400));

const calendarDays = computed(() => {
    const year = currentDate.value.getFullYear();
    const month = currentDate.value.getMonth();
    const days = [];
    
    const firstDay = firstDayOfMonth(year, month);
    const prevMonthDays = daysInMonth(year, month - 1);
    
    for (let i = firstDay - 1; i >= 0; i--) {
        days.push({ date: new Date(year, month - 1, prevMonthDays - i), isCurrentMonth: false });
    }
    
    const totalDays = daysInMonth(year, month);
    for (let i = 1; i <= totalDays; i++) {
        days.push({ date: new Date(year, month, i), isCurrentMonth: true });
    }
    
    const remainingCells = 42 - days.length;
    for (let i = 1; i <= remainingCells; i++) {
        days.push({ date: new Date(year, month + 1, i), isCurrentMonth: false });
    }
    
    return days;
});

const changeMonth = (direction) => {
    if (direction === 1) {
        const next = activeMonths.value.find(m => m.time > currentMonthTime.value);
        if (next) currentDate.value = new Date(next.year, next.month, 1);
    } else if (direction === -1) { 
        const prevs = activeMonths.value.filter(m => m.time < currentMonthTime.value);
        if (prevs.length > 0) {
            const prev = prevs[prevs.length - 1]; 
            currentDate.value = new Date(prev.year, prev.month, 1);
        }
    }
};

const goToCurrentOrNearestMonth = () => {
    const today = new Date();
    const todayTime = today.getFullYear() * 12 + today.getMonth();

    if (activeMonths.value.some(m => m.time === todayTime)) {
        currentDate.value = new Date(today.getFullYear(), today.getMonth(), 1);
    } else if (activeMonths.value.length > 0) {
        const future = activeMonths.value.find(m => m.time > todayTime);
        if (future) {
            currentDate.value = new Date(future.year, future.month, 1);
        } else {
            const past = activeMonths.value[activeMonths.value.length - 1];
            currentDate.value = new Date(past.year, past.month, 1);
        }
    } else {
        currentDate.value = new Date(); 
    }
    isPickerOpen.value = false;
};

const togglePicker = () => {
    if (!isPickerOpen.value) pickerYear.value = currentDate.value.getFullYear();
    isPickerOpen.value = !isPickerOpen.value;
};

const selectMonthYear = (monthIndex) => {
    currentDate.value = new Date(pickerYear.value, monthIndex, 1);
    isPickerOpen.value = false;
};

const changePickerYear = (offset) => {
    pickerYear.value += offset;
};

const getEventsForDate = (dateObj) => {
    const current = new Date(dateObj.getFullYear(), dateObj.getMonth(), dateObj.getDate());
    
    return filteredAgendas.value.filter(a => {
        if (!a.start_date) return false;
        
        const startStr = a.start_date.split(' ')[0];
        const endStr = a.end_date ? a.end_date.split(' ')[0] : startStr;
        
        const [sy, sm, sd] = startStr.split('-');
        const start = new Date(parseInt(sy), parseInt(sm) - 1, parseInt(sd));
        start.setHours(0,0,0,0);
        
        const [ey, em, ed] = endStr.split('-');
        const end = new Date(parseInt(ey), parseInt(em) - 1, parseInt(ed));
        end.setHours(0,0,0,0);

        return current >= start && current <= end;
    });
};

const hasEvent = (dateObj) => getEventsForDate(dateObj).length > 0;

const currentSelectedAgendas = computed(() => {
    if (!selectedDateObj.value) return [];
    return getEventsForDate(selectedDateObj.value);
});

const openDetailModal = (dateObj) => {
    selectedDateObj.value = dateObj;
    isDetailModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeDetailModal = () => {
    isDetailModalOpen.value = false;
    setTimeout(() => { selectedDateObj.value = null; }, 300);
    document.body.style.overflow = 'auto';
};

const isToday = (date) => {
    const today = new Date();
    return date.getDate() === today.getDate() && date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear();
};
</script>

<template>
    <PublicLayout>
        <Head title="Agenda Fakultas" />
        <Banner title="AGENDA FAKULTAS" subtitle="Jadwal Resmi, Kegiatan Institusi, dan Akademik FSTI" background-image="/images/background-banner.webp" />

        <div class="relative bg-white py-16 md:py-24 font-public-sans min-h-screen overflow-x-hidden">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
                <div class="absolute top-[-10%] left-[-5%] w-[40rem] h-[40rem] bg-primary/5 rounded-full blur-[100px]"></div>
                <div class="absolute top-[20%] right-[-10%] w-[35rem] h-[35rem] bg-blue-400/5 rounded-full blur-[100px]"></div>
                <CalendarDays class="absolute top-[15%] left-[8%] w-32 h-32 text-primary/10 transform -rotate-12" />
                <ClockIcon class="absolute top-[45%] right-[5%] w-40 h-40 text-blue-500/10 transform rotate-12" />
                <MapPinIcon class="absolute bottom-[10%] left-[15%] w-24 h-24 text-indigo-400/10 transform -rotate-6" />
                <CalendarIcon class="absolute bottom-[25%] right-[20%] w-28 h-28 text-primary/5 transform rotate-6" />
            </div>

            <div class="container relative z-10 mx-auto px-4 md:px-6 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-blue-800 rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-blue-800/50" data-aos="fade-up">
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-300/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    <div class="absolute top-[20%] left-[40%] w-[30%] h-[50%] bg-blue-200/15 rounded-full blur-[80px] pointer-events-none"></div>

                   <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-bold mb-6 shadow-sm uppercase tracking-wider">
                            <CalendarDays class="w-4 h-4" /> Agenda Fakultas
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm"> Agenda FSTI ITK</h2>
                        <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90">
Temukan berbagai jadwal penting kegiatan resmi di lingkungan Fakultas Sains dan Teknologi Informasi ITK                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 hover:scale-105 transition-all duration-500 shadow-2xl">
                        <CalendarDays class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-4 md:mx-8 mb-12 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input type="text" placeholder="Cari nama agenda atau acara..." v-model="search" class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 text-slate-800 font-medium hover:bg-white transition-colors">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
                        <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors"><X class="w-5 h-5" /></button>
                    </div>
                    <div class="relative md:w-80">
                        <button ref="dropdownRef" @click="toggleDropdown" class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors focus:ring-2 focus:ring-primary focus:border-primary">
                            <span class="truncate">{{ selectedYear === 'Semua' ? 'Semua Tahun' : 'Tahun ' + selectedYear }}</span>
                            <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200" :class="{'rotate-180': isOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div v-if="isOpen" id="teleport-agenda" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-slate-100 py-2 font-public-sans overflow-hidden">
                            <a v-for="y in allYears" :key="y" @click="selectYear(y)" class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': selectedYear === y}">
                                {{ y === 'Semua' ? 'Tampilkan Semua Tahun' : 'Tahun ' + y }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

                <div class="relative max-w-4xl mx-auto mb-16" data-aos="zoom-in" data-aos-delay="100">
                    
                    <div v-if="isFiltering" class="mb-6 bg-blue-50/80 border border-blue-100 p-4 rounded-2xl flex items-center justify-between shadow-sm animate-fade-in">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-primary"><Search class="w-5 h-5" /></div>
                            <div>
                                <p class="text-sm text-blue-600 font-bold uppercase tracking-wider mb-0.5">Filter Aktif</p>
                                <p class="text-[15px] font-medium text-slate-700">Kalender dan daftar di bawah hanya menampilkan hasil untuk 
                                    <span v-if="search">"<span class="font-bold text-primary">{{ search }}</span>"</span>
                                    <span v-if="search && selectedYear !== 'Semua'"> di </span>
                                    <span v-if="selectedYear !== 'Semua'">Tahun <span class="font-bold text-primary">{{ selectedYear }}</span></span>.
                                </p>
                            </div>
                        </div>
                        <button @click="search = ''; selectYear('Semua')" class="px-4 py-2 bg-white text-slate-600 hover:text-red-500 font-bold rounded-xl border border-slate-200 transition-colors text-sm shadow-sm hidden sm:block">Reset Pencarian</button>
                    </div>

                    <div class="absolute -top-10 -left-10 w-48 h-48 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-white rounded-[2rem] shadow-xl shadow-blue-900/5 border border-slate-100 overflow-hidden relative z-10 group">
                        
                        <div class="bg-gradient-to-r from-primary to-blue-600 px-8 py-6 md:py-8 flex flex-col sm:flex-row items-center justify-between text-white relative overflow-hidden gap-4">
                            <CalendarDays class="absolute -right-4 -top-8 w-40 h-40 text-white opacity-10 transform rotate-12 transition-transform duration-700 group-hover:rotate-6 pointer-events-none" />
                            
                            <div class="relative z-10 flex items-center gap-4">
                                <div class="w-12 h-12 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/20 flex items-center justify-center">
                                    <CalendarIcon class="w-6 h-6 text-white" />
                                </div>
                                <div class="text-center sm:text-left">
                                    <p class="text-xs font-bold uppercase tracking-widest text-blue-200 mb-0.5">Kalender</p>
                                    
                                    <button @click="togglePicker" class="text-2xl font-black tracking-wider hover:text-blue-100 transition-colors flex items-center gap-2 group/btn select-none">
                                        {{ monthNames[currentDate.getMonth()] }} {{ currentDate.getFullYear() }}
                                        <ChevronDown class="w-5 h-5 transition-transform duration-300" :class="isPickerOpen ? 'rotate-180 text-blue-200' : 'group-hover/btn:translate-y-0.5'" />
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex gap-2 relative z-10 bg-white/10 p-1.5 rounded-full backdrop-blur-sm border border-white/20">
                                <button @click="changeMonth(-1)" :disabled="!hasPrevMonth" class="w-10 h-10 flex items-center justify-center rounded-full transition-all" :class="hasPrevMonth ? 'hover:bg-white text-white hover:text-primary' : 'text-white/30 cursor-not-allowed'"><ChevronLeft class="w-5 h-5"/></button>
                                <button @click="goToCurrentOrNearestMonth" class="px-4 text-sm font-bold hover:bg-white text-white hover:text-primary rounded-full transition-all tracking-wide" :class="activeMonths.length === 0 ? 'opacity-50 cursor-not-allowed hover:bg-transparent hover:text-white' : ''">Bulan Ini</button>
                                <button @click="changeMonth(1)" :disabled="!hasNextMonth" class="w-10 h-10 flex items-center justify-center rounded-full transition-all" :class="hasNextMonth ? 'hover:bg-white text-white hover:text-primary' : 'text-white/30 cursor-not-allowed'"><ChevronRight class="w-5 h-5"/></button>
                            </div>
                        </div>

                        <div class="p-6 md:p-10 relative min-h-[380px]">
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.02]">
                                <CalendarDays class="w-64 h-64 text-primary" />
                            </div>

                            <div v-if="!isPickerOpen" class="animate-fade-in relative z-10">
                                <div class="grid grid-cols-7 mb-4 border-b border-slate-100 pb-4">
                                    <div v-for="day in ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']" :key="day" class="text-center text-xs font-black text-slate-400 uppercase tracking-widest">{{ day }}</div>
                                </div>
                                
                                <div class="grid grid-cols-7 gap-2 md:gap-3">
                                    <div v-for="(item, index) in calendarDays" :key="index" 
                                         class="aspect-square flex flex-col items-center justify-center rounded-[1.5rem] transition-all cursor-pointer relative"
                                         :class="[
                                             item.isCurrentMonth ? 'hover:bg-blue-50/50 hover:text-primary hover:shadow-sm text-slate-700 bg-slate-50/30' : 'text-slate-300 pointer-events-none',
                                             hasEvent(item.date) && item.isCurrentMonth ? 'font-black bg-white border border-slate-100 shadow-[0_2px_12px_rgba(0,0,0,0.04)] ring-1 ring-primary/30 text-primary' : 'font-medium'
                                         ]"
                                         @click="item.isCurrentMonth ? openDetailModal(item.date) : null">
                                        
                                        <span class="text-base md:text-xl z-10" :class="isToday(item.date) && item.isCurrentMonth ? 'bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center shadow-md' : ''">
                                            {{ item.date.getDate() }}
                                        </span>
                                        
                                        <div v-if="item.isCurrentMonth && hasEvent(item.date)" class="absolute bottom-2 md:bottom-3 flex gap-1">
                                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-primary rounded-full animate-pulse shadow-[0_0_5px_rgba(47,77,211,0.5)]"></div>
                                            <div v-if="getEventsForDate(item.date).length > 1" class="w-1.5 h-1.5 md:w-2 md:h-2 bg-blue-300 rounded-full"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="animate-fade-in relative z-10">
                                <div class="flex items-center justify-between mb-8 bg-slate-50 rounded-2xl p-2 border border-slate-100 shadow-inner">
                                    <button @click="changePickerYear(-1)" class="p-3 hover:bg-white rounded-xl shadow-sm border border-transparent hover:border-slate-200 transition-all text-primary"><ChevronLeft class="w-6 h-6"/></button>
                                    <span class="font-black text-2xl text-primary tracking-widest">{{ pickerYear }}</span>
                                    <button @click="changePickerYear(1)" class="p-3 hover:bg-white rounded-xl shadow-sm border border-transparent hover:border-slate-200 transition-all text-primary"><ChevronRight class="w-6 h-6"/></button>
                                </div>
                                <div class="grid grid-cols-3 gap-3 md:gap-4">
                                    <button v-for="(mName, index) in monthNames" :key="index"
                                        @click="selectMonthYear(index)"
                                        class="py-4 text-sm md:text-base font-bold rounded-2xl border transition-all duration-300"
                                        :class="currentDate.getMonth() === index && currentDate.getFullYear() === pickerYear ? 'bg-primary text-white border-primary shadow-lg shadow-blue-900/20 transform scale-105' : 'bg-white text-slate-600 border-slate-100 hover:border-primary/40 hover:text-primary hover:shadow-md hover:-translate-y-1'">
                                        {{ mName.substring(0, 3) }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50/50 border-t border-blue-100/50 p-4 text-center relative z-10">
                            <p class="text-xs text-primary font-bold flex items-center justify-center gap-2 tracking-wider">
                                <span class="w-2 h-2 bg-primary rounded-full animate-pulse shadow-[0_0_8px_rgba(47,77,211,0.6)]"></span> 
                                Klik tanggal manapun pada bulan aktif untuk melihat informasi jadwal.
                            </p>
                        </div>
                    </div>
                </div>

                <div v-if="isFiltering" class="animate-fade-in border-t-2 border-dashed border-slate-200 pt-12 mt-12">
                    <div v-if="filteredAgendas.length === 0" class="bg-white border border-slate-100 rounded-3xl p-16 text-center shadow-sm mx-4 md:mx-8" data-aos="zoom-in">
                        <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4"><FileX2 class="h-10 w-10 text-primary" /></div>
                        <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                        <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Agenda dengan kriteria pencarian tersebut tidak tersedia.</p>
                    </div>

                    <div v-else>
                        <div class="text-center mb-10">
                            <h2 class="text-3xl font-black text-slate-800">Daftar Agenda</h2>
                            <p class="text-slate-500 mt-2">Daftar kegiatan yang cocok dengan pencarian Anda.</p>
                        </div>

                        <div v-for="(list, monthYear) in paginatedGroupedAgendas" :key="monthYear" class="mb-16 last:mb-0" data-aos="fade-up">
                            <div class="flex items-center gap-5 mb-8 mx-4 md:mx-8">
                                <div class="w-12 h-1.5 bg-primary rounded-full shadow-sm"></div>
                                <h2 class="text-3xl font-optimus font-bold text-slate-800 capitalize tracking-wide">{{ monthYear }}</h2>
                                <div class="flex-grow h-px bg-slate-200"></div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mx-4 md:mx-8">
                                <div v-for="agenda in list" :key="agenda.id" class="bg-white rounded-[1.5rem] border border-slate-100 shadow-[0_2px_15px_rgba(0,0,0,0.03)] hover:shadow-[0_12px_30px_rgba(47,77,211,0.08)] hover:border-primary/20 transform hover:-translate-y-1 transition-all duration-300 flex flex-col group relative overflow-hidden">
                                    <div class="h-28 bg-gradient-to-r from-primary to-primary-hover rounded-t-[1.5rem] relative overflow-hidden shrink-0">
                                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                                        <div class="absolute -bottom-px left-6 bg-white z-10 flex flex-col items-center justify-center min-w-[4.5rem] px-3 pt-3 pb-2.5 rounded-t-[1rem] shadow-[0_-2px_10px_rgba(0,0,0,0.04)] border-t border-x border-slate-100">
                                            <span class="text-[10px] font-bold uppercase text-slate-500 leading-none mb-1.5">{{ formatMonth(agenda.start_date) }}</span>
                                            <span class="text-2xl font-black font-optimus text-primary leading-none">{{ formatDay(agenda.start_date) }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-6 pb-6 px-6 flex-grow flex flex-col bg-white rounded-b-[1.5rem] h-full">
                                        <div class="mb-4 mt-1">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 text-primary font-semibold rounded-md text-[11px] uppercase tracking-wider border border-slate-100">
                                                <Building class="w-3.5 h-3.5" /> {{ agenda.organizer || 'FSTI ITK' }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800 mb-3 group-hover:text-primary transition-colors duration-300 leading-snug break-words overflow-hidden">{{ agenda.title }}</h3>
                                        
                                        <div v-if="agenda.description" class="text-sm text-slate-500 mb-6 leading-relaxed whitespace-pre-wrap break-words overflow-hidden" v-html="agenda.description"></div>

                                        <div class="mt-auto space-y-3 pt-5 border-t border-slate-100">
                                            <div v-if="agenda.end_date && agenda.end_date !== agenda.start_date" class="flex items-start gap-3 text-sm text-slate-600">
                                                <div class="mt-0.5 shrink-0"><CalendarDays class="w-4 h-4 text-primary/70" /></div>
                                                <span class="break-words">S.d <span class="font-semibold text-slate-700">{{ formatDateLengkap(agenda.end_date) }}</span></span>
                                            </div>
                                            <div v-if="agenda.location" class="flex items-start gap-3 text-sm text-slate-600">
                                                <div class="mt-0.5 shrink-0"><MapPinIcon class="w-4 h-4 text-primary/70" /></div>
                                                <div class="leading-tight break-words max-w-full overflow-hidden">{{ agenda.location }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="totalPages > 1" class="mt-16 mx-4 md:mx-8 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-slate-100" data-aos="fade-in">
                            <p class="text-sm font-medium text-slate-500 text-center md:text-left">
                                Menampilkan <span class="text-primary font-bold">{{ showingFrom }}</span> - <span class="text-primary font-bold">{{ showingTo }}</span> dari <span class="text-primary font-bold">{{ totalAgendas }}</span> Agenda
                            </p>
                            
                            <div class="flex flex-wrap justify-center items-center gap-2">
                                <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === 1 ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'" v-html="'&laquo; Sebelumnya'"></button>
                                <template v-for="(page, index) in visiblePages" :key="index">
                                    <span v-if="page === '...'" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full text-slate-300 bg-slate-50/50 cursor-not-allowed">...</span>
                                    <button v-else @click="changePage(page)" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'">{{ page }}</button>
                                </template>
                                <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === totalPages ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'" v-html="'Selanjutnya &raquo;'"></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="isDetailModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/70 backdrop-blur-sm p-4 sm:p-6 font-public-sans" @click.self="closeDetailModal">
                
                <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg md:max-w-2xl flex flex-col overflow-hidden transform transition-all border border-white/20">
                    
                    <div class="bg-gradient-to-r from-primary to-blue-600 px-8 py-8 flex items-center justify-between text-white relative overflow-hidden shrink-0">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                        <CalendarDays class="absolute right-16 top-4 w-28 h-28 text-white opacity-5 transform rotate-12 pointer-events-none" />
                        <div class="relative z-10">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-blue-200 mb-1 flex items-center gap-1.5"><CalendarIcon class="w-3.5 h-3.5"/> Jadwal Pada Tanggal</p>
                            <h3 class="text-2xl md:text-3xl font-black tracking-wide">{{ selectedDateObj?.getDate() }} {{ monthNames[selectedDateObj?.getMonth()] }} {{ selectedDateObj?.getFullYear() }}</h3>
                        </div>
                        <button @click="closeDetailModal" class="p-2.5 bg-white/10 hover:bg-white/25 rounded-full transition-all relative z-10 backdrop-blur-sm shadow-sm"><X class="w-6 h-6"/></button>
                    </div>

                    <div class="p-6 md:p-8 bg-slate-50/80 max-h-[60vh] overflow-y-auto custom-scrollbar relative">
                        <div v-if="currentSelectedAgendas.length > 0" class="space-y-6">
                            <div v-for="agenda in currentSelectedAgendas" :key="agenda.id" class="bg-white border border-gray-100 p-6 md:p-8 rounded-[1.5rem] shadow-sm hover:shadow-md hover:border-primary/30 transition-all group relative overflow-hidden">
                                
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-primary to-blue-400 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                
                                <div class="mb-4 flex items-center justify-between">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50/50 text-primary font-bold rounded-lg text-[10px] uppercase border border-blue-100/50 tracking-widest shadow-sm">
                                        <Building class="w-3.5 h-3.5" /> {{ agenda.organizer || 'FSTI ITK' }}
                                    </span>
                                </div>
                                <h4 class="text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-4 group-hover:text-primary transition-colors break-words">{{ agenda.title }}</h4>
                                
                                <div v-if="agenda.description" class="text-[15px] text-gray-600 mb-6 leading-relaxed whitespace-pre-wrap break-words overflow-hidden" v-html="agenda.description"></div>
                                
                                <div class="space-y-4 pt-5 border-t border-gray-50">
                                    <div v-if="agenda.end_date && agenda.end_date !== agenda.start_date" class="flex items-start gap-3 text-sm text-gray-600 font-medium">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100/50"><CalendarDays class="w-4 h-4 text-primary" /></div>
                                        <div class="mt-1.5 break-words">
                                            <span>S.d <span class="font-bold text-gray-800">{{ formatDateLengkap(agenda.end_date) }}</span></span>
                                        </div>
                                    </div>
                                    <div v-if="agenda.location" class="flex items-start gap-3 text-sm text-gray-600 font-medium">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100/50"><MapPinIcon class="w-4 h-4 text-primary" /></div>
                                        <div class="mt-1.5 leading-snug break-words max-w-full overflow-hidden">{{ agenda.location }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div v-else class="text-center py-16 border-2 border-dashed border-slate-200 rounded-[1.5rem] bg-white">
                            <div class="w-24 h-24 bg-slate-50 shadow-sm border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-5"><CalendarIcon class="w-12 h-12 text-slate-300"/></div>
                            <h4 class="text-xl font-bold text-slate-800 mb-1.5">Tidak Ada Jadwal</h4>
                            <p class="text-sm text-slate-500 font-medium">Tidak ada kegiatan yang dijadwalkan pada tanggal yang Anda pilih.</p>
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-100 bg-white shrink-0">
                        <button @click="closeDetailModal" class="w-full py-3.5 bg-gray-50 border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-100 hover:text-primary transition-colors">
                            Tutup Detail
                        </button>
                    </div>

                </div>
            </div>
        </transition>

    </PublicLayout>
</template>

<style scoped>
.aspect-square { aspect-ratio: 1 / 1; }
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

.animate-fade-in {
    animation: fadeIn 0.4s ease-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>