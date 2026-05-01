<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, router } from '@inertiajs/vue3';
import { 
    Search, GraduationCap, ChevronDown, ListFilter, X, BookOpen, FileX2, Quote, 
    Briefcase, Monitor, Calculator, Cpu, Database, Network, Activity, UserCircle2, 
    ChevronLeft, ChevronRight, Award, Sparkles
} from 'lucide-vue-next';
import { debounce } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
    alumni: Object,
    filters: Object,
    studyPrograms: Array,
    years: Array,
    distribution: Array,
    testimonials: { 
        type: Array,
        default: () => []
    }
});

const search = ref(props.filters.search || '');
const program = ref(props.filters.program || '');
const selectedYear = ref(props.filters.year || '');

const isFiltering = computed(() => search.value !== '' || program.value !== '' || selectedYear.value !== '');

const isProgramOpen = ref(false);
const isYearOpen = ref(false);
const programRef = ref(null);
const yearRef = ref(null);

const handleClickOutside = (event) => {
    if (programRef.value && !programRef.value.contains(event.target)) isProgramOpen.value = false;
    if (yearRef.value && !yearRef.value.contains(event.target)) isYearOpen.value = false;
};

function selectOption(type, value) {
    if (type === 'program') { program.value = value; isProgramOpen.value = false; } 
    else if (type === 'year') { selectedYear.value = value; isYearOpen.value = false; }
}

const testimonialsData = computed(() => props.testimonials);

const activeTestimonialIdx = ref(0); 
const prevIndex = computed(() => {
    if (testimonialsData.value.length === 0) return 0;
    return (activeTestimonialIdx.value - 1 + testimonialsData.value.length) % testimonialsData.value.length;
});
const nextIndex = computed(() => {
    if (testimonialsData.value.length === 0) return 0;
    return (activeTestimonialIdx.value + 1) % testimonialsData.value.length;
});

let autoplayInterval = null;

const startAutoplay = () => {
    if (testimonialsData.value.length > 1) {
    autoplayInterval = setInterval(() => { nextTestimonial(); }, 1500); 
    }
};
const stopAutoplay = () => { if (autoplayInterval) clearInterval(autoplayInterval); };

const nextTestimonial = () => { activeTestimonialIdx.value = nextIndex.value; };
const prevTestimonial = () => { activeTestimonialIdx.value = prevIndex.value; };

const getSlideClass = (index) => {
    if (index === activeTestimonialIdx.value) return 'translate-x-0 scale-100 opacity-100 z-20 pointer-events-auto';
    if (index === prevIndex.value) return '-translate-x-[85%] md:-translate-x-[65%] scale-[0.85] opacity-40 z-10 pointer-events-none cursor-pointer';
    if (index === nextIndex.value) return 'translate-x-[85%] md:translate-x-[65%] scale-[0.85] opacity-40 z-10 pointer-events-none cursor-pointer';
    return 'hidden opacity-0';
};

const activeSegment = ref(null);
const totalAlumniCount = computed(() => {
    if (!props.distribution) return 0;
    return props.distribution.reduce((acc, curr) => acc + curr.total, 0);
});

const chartData = computed(() => {
    if (!props.distribution) return [];
    let cumulativePercent = 0;
    const colors = ['#2F4DD3', '#00509D', '#4F6EF7', '#8095FF', '#1E3A8A', '#A3B3FF'];
    
    return props.distribution.map((item, index) => {
        const percent = (item.total / totalAlumniCount.value) * 100;
        const startPercent = cumulativePercent;
        cumulativePercent += percent;
        return { ...item, percent, startPercent, color: colors[index % colors.length] };
    });
});

const getCoordinatesForPercent = (percent) => {
    const x = Math.cos(2 * Math.PI * percent);
    const y = Math.sin(2 * Math.PI * percent);
    return [x, y];
};

const createPath = (startPercent, endPercent) => {
    if (endPercent - startPercent === 100) return `M 1 0 A 1 1 0 1 1 1 -0.001`; 
    const [startX, startY] = getCoordinatesForPercent(startPercent / 100);
    const [endX, endY] = getCoordinatesForPercent(endPercent / 100);
    const largeArcFlag = endPercent - startPercent > 50 ? 1 : 0;
    return `M ${startX} ${startY} A 1 1 0 ${largeArcFlag} 1 ${endX} ${endY}`;
};

const getProgramIcon = (programName) => {
    const p = programName.toLowerCase();
    if (p.includes('sistem informasi')) return Database;
    if (p.includes('informatika')) return Monitor;
    if (p.includes('matematika')) return Calculator;
    if (p.includes('fisika')) return Activity;
    if (p.includes('elektro')) return Cpu;
    if (p.includes('statistika')) return Network;
    if (p.includes('bisnis') || p.includes('aktuaria')) return Briefcase;
    return BookOpen;
};

onMounted(() => {
    AOS.init({ duration: 800, once: true });
    document.addEventListener('mousedown', handleClickOutside);
    startAutoplay();
});

onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside);
    stopAutoplay();
});

watch([search, program, selectedYear], debounce(() => {
    router.get(route('alumni.index'), { search: search.value, program: program.value, year: selectedYear.value }, { 
        preserveState: true, preserveScroll: true, replace: true, onFinish: () => { AOS.refresh(); }
    });
}, 400));

const resetFilters = () => { search.value = ''; program.value = ''; selectedYear.value = ''; };

const currentPage = computed(() => props.alumni.current_page || 1);
const totalPages = computed(() => props.alumni.last_page || 1);
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
            search: search.value, program: program.value, year: selectedYear.value, page: page 
        }, {
            preserveState: true, preserveScroll: true, replace: true,
            onFinish: () => { 
                AOS.refresh();
                const el = document.getElementById('directory-section');
                if (el) window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 80, behavior: 'smooth' });
            } 
        });
    }
};
</script>

<template>
    <PublicLayout>
        <Head title="Direktori Alumni" />
        
        <Banner title="ALUMNI" subtitle="Jejak Kelulusan Fakultas Sains dan Teknologi Informasi" background-image="/images/background-banner.webp" />

        <div class="relative bg-white pt-16 pb-24 md:pt-24 md:pb-32 font-public-sans overflow-hidden" data-aos="fade-up">
            <GraduationCap class="absolute -top-10 -left-16 md:-left-10 w-[24rem] h-[24rem] md:w-[32rem] md:h-[32rem] text-primary/[0.03] -rotate-12 pointer-events-none" />
            <Award class="absolute -bottom-10 -right-16 md:-right-10 w-[24rem] h-[24rem] md:w-[32rem] md:h-[32rem] text-primary/[0.03] rotate-12 pointer-events-none" />
            <Sparkles class="absolute top-1/4 right-1/4 w-32 h-32 text-yellow-500/[0.04] pointer-events-none" />

            <div class="container relative z-10 mx-auto px-4 md:px-8 max-w-7xl">
                
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4">Pengalaman Alumni</h2>
                    <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
                    <p class="text-gray-500 mt-3 font-medium text-sm md:text-base">Pengalaman dan kesan alumni setelah menyelesaikan studi di FSTI ITK</p>
                </div>
                
                <div v-if="testimonialsData.length > 0" class="relative w-full h-[650px] md:h-[450px] flex items-center justify-center overflow-visible" 
                     @mouseenter="stopAutoplay" @mouseleave="startAutoplay">
                    
                    <div v-for="(alumni, index) in testimonialsData" :key="index"
                         class="absolute top-4 w-full md:w-[75%] h-[90%] transition-all duration-500 ease-in-out flex flex-col md:flex-row items-center bg-gradient-to-br from-[#003566] via-[#00509D] to-[#2F4DD3] rounded-3xl shadow-[0_20px_50px_rgba(47,77,211,0.2)] border border-white/10 px-6 py-8 md:p-10"
                         :class="getSlideClass(index)">
                        
                        <div class="w-full md:w-5/12 flex justify-center relative shrink-0 z-10 h-64 md:h-full px-2 md:px-6">
                            <div class="absolute top-4 -left-2 md:-left-4 w-full h-full border-2 border-blue-400/40 rounded-2xl z-0 rounded-bl-[3rem]"></div>
                            <div class="relative z-10 w-full h-full rounded-2xl overflow-hidden shadow-xl border-4 border-white/20 bg-gradient-to-b from-blue-900 to-slate-800">
                                <img v-if="alumni.photo" :src="alumni.photo" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-700" />
                                <div v-else class="w-full h-full flex items-center justify-center bg-blue-900/40 text-white/30"><UserCircle2 class="w-24 h-24 opacity-50" /></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent pointer-events-none"></div>
                                <div class="absolute bottom-0 left-0 p-4 md:p-6 w-full z-10">
                                    <h3 class="text-white font-bold text-lg md:text-xl drop-shadow-md leading-tight mb-1">{{ alumni.name }}</h3>
                                    <p class="text-yellow-400 font-bold text-xs md:text-sm drop-shadow uppercase tracking-wide whitespace-pre-line text-left">
                                        {{ alumni.job ? alumni.job : 'Alumni' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="w-full md:w-7/12 flex flex-col text-center md:text-left z-10 pt-6 md:pt-0 md:pl-8">
                            <Quote class="w-10 h-10 md:w-12 md:h-12 text-white/20 mb-4 mx-auto md:mx-0 fill-current rotate-180" />
                            <p class="text-white/90 text-[14px] md:text-[15px] leading-relaxed mb-6 whitespace-pre-line font-medium text-justify">
                                "{{ alumni.message }}"
                            </p>
                            <div class="w-10 h-1 bg-yellow-400 mb-4 mx-auto md:mx-0 rounded-full"></div>
                            <p class="text-cyan-300 font-bold text-sm md:text-[15px] tracking-wide">
                                {{ alumni.program }} <span class="font-normal text-cyan-100/70">({{ alumni.year }})</span>
                            </p>
                        </div>
                    </div>

                    <button v-if="testimonialsData.length > 1" @click="prevTestimonial" class="absolute left-0 md:left-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-white/10 text-white backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/20 hover:scale-110 shadow-lg transition-all border border-white/20">
                        <ChevronLeft class="w-6 h-6" />
                    </button>
                    <button v-if="testimonialsData.length > 1" @click="nextTestimonial" class="absolute right-0 md:right-4 top-1/2 -translate-y-1/2 z-30 w-12 h-12 bg-white/10 text-white backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/20 hover:scale-110 shadow-lg transition-all border border-white/20">
                        <ChevronRight class="w-6 h-6" />
                    </button>
                </div>

                <div v-else class="text-center py-10">
                    <p class="text-gray-500 italic">Belum ada data pengalaman alumni yang ditambahkan.</p>
                </div>
                
                <div v-if="testimonialsData.length > 1" class="flex justify-center gap-2 mt-4 relative z-30">
                    <button v-for="(t, i) in testimonialsData" :key="i" @click="activeTestimonialIdx = i" 
                            class="w-2.5 h-2.5 rounded-full transition-all duration-300 shadow-sm"
                            :class="activeTestimonialIdx === i ? 'bg-primary w-8' : 'bg-gray-300 hover:bg-gray-400'"></button>
                </div>
            </div>
        </div>

        <div class="relative bg-[#F4F7FF] py-12 md:py-16 font-public-sans overflow-hidden border-y border-blue-100/50">
            <div class="container relative z-10 mx-auto px-4 md:px-6 max-w-7xl">
                <div v-if="distribution && distribution.length > 0" data-aos="fade-up">
                    <div class="text-center mb-10">
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4">Sebaran Alumni</h2>
                        <div class="w-20 h-1.5 bg-primary mx-auto rounded-full"></div>
                        <p class="text-gray-500 mt-3 font-medium text-sm md:text-base">Distribusi alumni FSTI ITK berdasarkan program studi</p>
                    </div>
                    
                    <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-12 bg-white p-6 md:p-10 rounded-[2rem] shadow-[0_20px_50px_rgba(47,77,211,0.06)] border border-white">
                        
                        <div class="relative w-56 h-56 md:w-64 md:h-64 shrink-0 group">
                            <div class="absolute inset-0 rounded-full blur-3xl opacity-20 transition-colors duration-500"
                                 :style="{ backgroundColor: activeSegment ? activeSegment.color : '#2F4DD3' }"></div>
                                 
                            <svg viewBox="-1.2 -1.2 2.4 2.4" class="w-full h-full -rotate-90 drop-shadow-lg relative z-10">
                                <path v-for="seg in chartData" :key="seg.study_program"
                                      @click="activeSegment = (activeSegment === seg ? null : seg)"
                                      @mouseenter="activeSegment = seg"
                                      @mouseleave="activeSegment = null"
                                      :d="createPath(seg.startPercent, seg.startPercent + seg.percent) + ' L 0 0 Z'"
                                      :fill="seg.color" 
                                      class="transition-all duration-300 cursor-pointer origin-center"
                                      :class="{'opacity-100 scale-105': activeSegment === seg, 'opacity-40': activeSegment && activeSegment !== seg, 'hover:opacity-90': !activeSegment}"
                                      style="transform-box: fill-box;" />
                                <circle cx="0" cy="0" r="0.65" fill="white" class="drop-shadow-sm" />
                            </svg>
                            
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 pointer-events-none z-20">
                                <transition name="fade" mode="out-in">
                                    <div v-if="activeSegment" :key="activeSegment.study_program" class="flex flex-col items-center">
                                        <span class="text-3xl md:text-4xl font-bold transition-colors" :style="{ color: activeSegment.color }">{{ activeSegment.total }}</span>
                                        <span class="text-[10px] md:text-[11px] font-bold text-gray-500 mt-1 uppercase tracking-widest leading-tight">{{ activeSegment.study_program }}</span>
                                        <span class="text-[10px] text-gray-500 font-bold mt-1 bg-gray-50 px-2.5 py-1 rounded-md border border-gray-100">{{ activeSegment.percent.toFixed(1) }}%</span>
                                    </div>
                                    <div v-else key="total" class="flex flex-col items-center">
                                        <span class="text-3xl md:text-4xl font-bold text-gray-900">{{ totalAlumniCount }}</span>
                                        <span class="text-[10px] md:text-[11px] font-bold text-gray-500 mt-1 uppercase tracking-widest">Total Alumni</span>
                                    </div>
                                </transition>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full lg:w-auto">
                            <div v-for="item in chartData" :key="item.study_program" 
                                 @click="activeSegment = (activeSegment === item ? null : item)"
                                 @mouseenter="activeSegment = item"
                                 @mouseleave="activeSegment = null"
                                 class="flex items-center gap-4 bg-white px-5 py-3 rounded-xl border-2 transition-all cursor-pointer shadow-sm hover:shadow-md"
                                 :style="{ borderColor: activeSegment === item ? item.color : '#f3f4f6', transform: activeSegment === item ? 'translateY(-2px)' : 'none' }">
                                 
                                <div class="w-10 h-10 rounded-xl shadow-inner shrink-0 flex items-center justify-center transition-transform" 
                                     :class="{'scale-110': activeSegment === item}"
                                     :style="{ backgroundColor: item.color + '15', color: item.color }">
                                     <component :is="getProgramIcon(item.study_program)" class="w-5 h-5" stroke-width="2" />
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold transition-colors" :class="activeSegment === item ? 'text-gray-900' : 'text-primary'">{{ item.study_program }}</span>
                                    <span class="text-[11px] font-semibold text-gray-500">{{ item.total }} Lulusan ({{ item.percent.toFixed(1) }}%)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative bg-white py-16 md:py-24 font-public-sans min-h-screen overflow-hidden">
            <div class="container relative z-10 mx-auto px-4 md:px-6 max-w-7xl">
                <div id="directory-section" class="scroll-mt-32">
                    
                    <div class="relative max-w-3xl mx-auto mb-12 rounded-[2rem] bg-white p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 overflow-hidden text-center" data-aos="fade-up">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary/20 to-blue-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-blue-300/20 to-primary/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3 pointer-events-none"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="relative w-16 h-16 mb-4">
                                <div class="absolute inset-0 bg-primary/20 rounded-full animate-ping opacity-60"></div>
                                <div class="relative w-full h-full bg-gradient-to-br from-white to-blue-50 rounded-full flex items-center justify-center shadow-md border-4 border-white">
                                    <GraduationCap class="w-8 h-8 text-primary" />
                                </div>
                            </div>
                            <h2 class="text-2xl md:text-3xl font-optimus font-bold text-gray-900 mb-3 leading-tight">Data <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Alumni</span></h2>
                            <p class="text-gray-600 font-medium text-sm md:text-[15px] max-w-xl mx-auto leading-relaxed">Temukan data kelulusan, jejak langkah, dan jaringan alumni dari berbagai program studi di Fakultas Sains dan Teknologi Informasi ITK.</p>
                        </div>
                    </div>

                    <div class="mb-12 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 relative z-30" data-aos="fade-down">
                        <div class="relative flex-grow">
                            <input 
                                type="text" placeholder="Cari berdasarkan nama atau NIM..." v-model="search"
                                class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium transition-all"
                            >
                            <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                            <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600"><X class="w-5 h-5" /></button>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 md:w-[45%]">
                            <div class="relative w-full sm:w-3/5" ref="programRef">
                                <button type="button" @click="isProgramOpen = !isProgramOpen; isYearOpen = false" class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all">
                                    <span class="truncate">{{ program || 'Semua Program Studi' }}</span>
                                    <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isProgramOpen}" />
                                </button>
                                <BookOpen class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                                
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <div v-show="isProgramOpen" class="absolute top-full left-0 mt-2 w-full z-[100] bg-white rounded-xl shadow-xl border border-gray-100 py-2 font-public-sans overflow-hidden max-h-60 overflow-y-auto">
                                        <button type="button" @click="selectOption('program', '')" class="w-full text-left px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary transition-colors" :class="{'bg-primary/5 text-primary': program === ''}">Semua Program Studi</button>
                                        <button type="button" v-for="p in studyPrograms" :key="p" @click="selectOption('program', p)" class="w-full text-left px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary transition-colors" :class="{'bg-primary/5 text-primary': program === p}">{{ p }}</button>
                                    </div>
                                </transition>
                            </div>

                            <div class="relative w-full sm:w-2/5" ref="yearRef">
                                <button type="button" @click="isYearOpen = !isYearOpen; isProgramOpen = false" class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all">
                                    <span class="truncate">{{ selectedYear || 'Semua Tahun' }}</span>
                                    <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isYearOpen}" />
                                </button>
                                <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                                
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <div v-show="isYearOpen" class="absolute top-full left-0 mt-2 w-full z-[100] bg-white rounded-xl shadow-xl border border-gray-100 py-2 font-public-sans overflow-hidden max-h-60 overflow-y-auto">
                                        <button type="button" @click="selectOption('year', '')" class="w-full text-left px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary transition-colors" :class="{'bg-primary/5 text-primary': selectedYear === ''}">Semua Tahun</button>
                                        <button type="button" v-for="year in years" :key="year" @click="selectOption('year', year)" class="w-full text-left px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary transition-colors" :class="{'bg-primary/5 text-primary': selectedYear === year}">{{ year }}</button>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>

                    <div v-if="isFiltering" class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-20" data-aos="fade-up">
                        <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center flex-wrap gap-x-1.5">
                            <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                            <span class="text-gray-500 font-medium">Hasil pencarian untuk:</span>
                            <span v-if="search" class="text-primary">"{{ search }}"</span>
                            <span v-if="program" class="px-2.5 py-1 bg-primary/10 text-primary rounded-lg text-sm">{{ program }}</span>
                            <span v-if="selectedYear" class="px-2.5 py-1 bg-[#D9FFFE]/80 text-[#00509D] rounded-lg text-sm">Tahun {{ selectedYear }}</span>
                        </h3>
                        <button @click="resetFilters" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto">Reset Filter</button>
                    </div>

                    <div v-if="alumni.data.length > 0" class="bg-white rounded-3xl shadow-[0_8px_30px_rgba(0,53,102,0.04)] border border-gray-100 overflow-hidden relative z-20" data-aos="fade-up">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr class="bg-gradient-to-r from-primary to-blue-600 border-b border-primary/20">
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider w-32">NIM</th>
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider">Nama Lengkap</th>
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider">Program Studi</th>
                                        <th class="px-6 py-5 font-bold text-sm text-white tracking-wider text-center w-32">Tahun Masuk</th>
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
                                            <span class="inline-flex items-center justify-center w-14 h-8 rounded-lg bg-gray-100 text-gray-600 font-bold text-sm group-hover:bg-blue-50 group-hover:text-blue-700 transition-colors">
                                                {{ item.entry_year }}
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

                    <div v-else class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm relative z-20" data-aos="zoom-in">
                        <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4"><FileX2 class="h-10 w-10 text-primary" /></div>
                        <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                        <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Data alumni dengan kriteria pencarian, program studi, atau tahun lulus tersebut tidak tersedia.</p>
                    </div>

                    <div v-if="totalPages > 1 && alumni.data.length > 0" class="mt-12 flex flex-col items-center justify-center gap-4 w-full relative z-20" data-aos="fade-in">
                        <div class="flex flex-wrap justify-center items-center gap-2">
                            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-colors whitespace-nowrap border" :class="currentPage === 1 ? 'text-gray-300 bg-gray-50 border-gray-100 cursor-not-allowed' : 'text-gray-600 bg-white border-gray-200 hover:border-primary hover:text-primary shadow-sm'">Sebelumnya</button>
                            <template v-for="(page, index) in visiblePages" :key="index">
                                <span v-if="page === '...'" class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl text-gray-300 bg-white border border-gray-100 cursor-not-allowed whitespace-nowrap">...</span>
                                <button v-else @click="changePage(page)" class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-colors whitespace-nowrap border" :class="currentPage === page ? 'bg-primary text-white border-primary shadow-md shadow-primary/20' : 'text-gray-600 bg-white border-gray-200 hover:border-primary hover:text-primary hover:bg-slate-50 shadow-sm'">{{ page }}</button>
                            </template>
                            <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-colors whitespace-nowrap border" :class="currentPage === totalPages ? 'text-gray-300 bg-gray-50 border-gray-100 cursor-not-allowed' : 'text-gray-600 bg-white border-gray-200 hover:border-primary hover:text-primary shadow-sm'">Selanjutnya</button>
                        </div>
                        <p class="text-sm font-medium text-gray-400 mt-2 text-center">Menampilkan <span class="text-slate-700 font-bold">{{ alumni.from }}</span> - <span class="text-slate-700 font-bold">{{ alumni.to }}</span> dari <span class="text-slate-700 font-bold">{{ alumni.total }}</span> data</p>
                    </div>

                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.scroll-mt-32 { scroll-margin-top: 8rem; }
</style>