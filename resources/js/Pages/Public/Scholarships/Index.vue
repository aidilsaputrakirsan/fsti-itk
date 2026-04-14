<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { 
    GraduationCap, 
    Landmark, 
    Banknote, 
    BookOpen, 
    Award, 
    Search, 
    X, 
    ExternalLink,
    FileX2
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
    beasiswas: {
        type: Array,
        default: () => []
    }
});

const searchQuery = ref('');

const isFiltering = computed(() => searchQuery.value !== '');

const filteredBeasiswas = computed(() => {
    if (!searchQuery.value) return props.beasiswas;
    const query = searchQuery.value.toLowerCase();
    return props.beasiswas.filter(b => 
        b.title.toLowerCase().includes(query) || 
        b.description.toLowerCase().includes(query) ||
        (b.provider && b.provider.toLowerCase().includes(query))
    );
});

const itemsPerPage = 6; 
const currentPage = ref(1);

watch(searchQuery, () => {
    currentPage.value = 1;
});

const totalBeasiswas = computed(() => filteredBeasiswas.value.length);
const totalPages = computed(() => Math.ceil(totalBeasiswas.value / itemsPerPage));
const showingFrom = computed(() => totalBeasiswas.value === 0 ? 0 : (currentPage.value - 1) * itemsPerPage + 1);
const showingTo = computed(() => Math.min(currentPage.value * itemsPerPage, totalBeasiswas.value));

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

const paginatedBeasiswas = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredBeasiswas.value.slice(start, end);
});

const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        window.scrollTo({ top: 400, behavior: 'smooth' }); 
    }
};

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});

const getIcon = (index) => {
    const icons = [GraduationCap, Banknote, Landmark, BookOpen, Award];
    return icons[index % icons.length];
};

const getIconColorClasses = (index) => {
    const colors = [
        'bg-blue-50 text-primary',
        'bg-indigo-50 text-indigo-500',
        'bg-sky-50 text-sky-500',
        'bg-cyan-50 text-cyan-500',
        'bg-slate-100 text-slate-600'
    ];
    return colors[index % colors.length];
};
</script>

<template>
    <PublicLayout>
        <Head title="Informasi Beasiswa" />
        
        <Banner
            title="INFORMASI BEASISWA"
            subtitle="DAFTAR PROGRAM BEASISWA DAN BANTUAN PENDIDIKAN UNTUK MAHASISWA FSTI"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white py-12 md:py-24 font-public-sans min-h-[70vh]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-primary-hover rounded-[2rem] p-6 sm:p-8 md:p-14 mb-8 md:mb-10 overflow-hidden shadow-xl shadow-primary/20 flex flex-col md:flex-row items-center justify-between border border-white/10" data-aos="fade-down">
                    
                    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                    <div class="absolute -top-[30%] -right-[10%] w-[60%] h-[150%] bg-white/10 rounded-[100%] blur-[80px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[20%] left-[10%] w-[40%] h-[80%] bg-blue-300/20 rounded-[100%] blur-[60px] pointer-events-none"></div>

                    <div class="relative z-10 text-white w-full max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-[10px] md:text-[11px] font-bold mb-4 md:mb-5 shadow-sm uppercase tracking-[0.15em] text-blue-50">
                            <GraduationCap class="w-3 h-3 md:w-3.5 md:h-3.5" /> Daftar Beasiswa
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-5xl font-optimus font-bold mb-3 md:mb-4 leading-tight drop-shadow-sm">
                            Lihat Peluang<br/>Beasiswa FSTI
                        </h2>
                        <p class="text-blue-100 text-sm sm:text-base md:text-lg leading-relaxed font-light opacity-90 pb-2 md:pb-0">
                         Lihat berbagai pilihan beasiswa dan temukan yang sesuai untukmu.
                        </p>
                    </div>

                    <div class="hidden md:flex shrink-0 p-6 bg-white/10 backdrop-blur-md rounded-[2rem] border border-white/20 items-center justify-center transform rotate-6 hover:rotate-0 hover:scale-105 transition-all duration-500 shadow-2xl relative z-10">
                        <GraduationCap class="w-24 h-24 text-white" stroke-width="1.2" />
                    </div>
                </div>

                <div class="relative z-20 -mt-12 md:-mt-16 mx-auto max-w-3xl mb-8 bg-white p-3 md:p-4 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari nama beasiswa..." 
                            class="w-full pl-10 md:pl-12 pr-10 py-3 md:py-4 border-none focus:ring-0 bg-transparent text-slate-800 font-medium text-sm md:text-lg placeholder-slate-400"
                            v-model="searchQuery"
                        >
                        <Search class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 w-5 h-5 md:w-6 md:h-6 text-slate-300" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-2 md:right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-300 hover:text-primary transition-colors bg-slate-50 hover:bg-blue-50 rounded-full">
                            <X class="w-4 h-4 md:w-5 md:h-5" />
                        </button>
                    </div>
                </div>

                <div v-if="isFiltering" class="mb-10 mx-auto max-w-3xl bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span>Hasil pencarian untuk <span class="text-primary">"{{ searchQuery }}"</span></span>
                    </h3>
                    <button @click="searchQuery = ''" class="px-5 py-2 bg-gray-50 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl border border-gray-200 transition-colors self-start sm:self-auto">Reset Filter</button>
                </div>

                <div v-if="filteredBeasiswas.length === 0" class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm mx-auto max-w-3xl" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4">
                        <FileX2 class="h-10 w-10 text-primary" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Beasiswa dengan kriteria pencarian tersebut tidak tersedia.</p>
                </div>

                <div v-else>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 lg:gap-8">
                        <div 
                            v-for="(beasiswa, index) in paginatedBeasiswas" 
                            :key="beasiswa.id"
                            class="group bg-white rounded-2xl sm:rounded-[2rem] border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_15px_40px_rgba(47,77,211,0.08)] hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 flex flex-col overflow-hidden relative"
                            data-aos="fade-up"
                            :data-aos-delay="(index % 3) * 50"
                        >
                            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary to-primary-hover opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <div class="p-4 sm:p-6 md:p-8 flex-grow flex flex-col">
                                
                                <div class="mb-4 sm:mb-6">
                                    <div :class="[getIconColorClasses(index), 'w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-xl sm:rounded-2xl flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3 shadow-sm']">
                                        <component :is="getIcon(index)" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7" />
                                    </div>
                                </div>

                                <h3 class="text-sm sm:text-lg md:text-xl font-bold text-slate-800 mb-1.5 sm:mb-2 group-hover:text-primary transition-colors leading-snug line-clamp-3">
                                    {{ beasiswa.title }}
                                </h3>
                                
                                <p class="text-[10px] sm:text-xs font-semibold tracking-wider text-slate-400 uppercase mb-3 sm:mb-4 flex items-center gap-1 sm:gap-1.5">
                                    <Landmark class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0" /> 
                                    <span class="truncate">{{ beasiswa.provider || 'Mitra FSTI ITK' }}</span>
                                </p>

                                <p class="text-slate-500 text-[11px] sm:text-sm leading-relaxed flex-grow mb-4 sm:mb-6 whitespace-pre-line text-justify line-clamp-4 md:line-clamp-none">
                                    {{ beasiswa.description }}
                                </p>

                                <a 
                                    v-if="beasiswa.link_url" 
                                    :href="beasiswa.link_url" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="mt-auto flex items-center justify-center sm:justify-between w-full py-2.5 px-3 sm:py-3.5 sm:px-5 bg-slate-50 hover:bg-primary group-hover:bg-primary rounded-xl text-slate-600 hover:text-white group-hover:text-white text-[10px] sm:text-sm font-bold transition-all duration-300 gap-1.5"
                                >
                                    <span class="truncate">Lihat Selengkapnya</span>
                                    <ExternalLink class="w-3 h-3 sm:w-4 sm:h-4 transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-transform shrink-0" />
                                </a>
                                
                                <button 
                                    v-else 
                                    disabled 
                                    class="mt-auto flex items-center justify-center sm:justify-between w-full py-2.5 px-3 sm:py-3.5 sm:px-5 bg-slate-50 rounded-xl text-slate-400 text-[10px] sm:text-sm font-bold cursor-not-allowed border border-slate-100"
                                >
                                    <span class="truncate">Belum Tersedia</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-if="totalPages > 1" class="mt-12 md:mt-16 flex flex-col md:flex-row items-center justify-between gap-4 md:gap-6 bg-white py-4 px-4 md:px-10 rounded-3xl md:rounded-full shadow-sm border border-slate-100" data-aos="fade-in">
                        <p class="text-xs md:text-sm font-medium text-gray-500 text-center md:text-left">
                            Menampilkan <span class="text-primary font-bold">{{ showingFrom }}</span> - <span class="text-primary font-bold">{{ showingTo }}</span> dari <span class="text-primary font-bold">{{ totalBeasiswas }}</span> Beasiswa
                        </p>
                        
                        <div class="flex flex-wrap justify-center items-center gap-1.5 md:gap-2">
                            <button 
                                @click="changePage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full transition-all duration-300"
                                :class="currentPage === 1 ? 'text-gray-300 bg-gray-50/50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                                v-html="'&laquo; Sebelumnya'"
                            ></button>

                            <template v-for="(page, index) in visiblePages" :key="index">
                                <span 
                                    v-if="page === '...'"
                                    class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full text-gray-300 bg-gray-50/50 cursor-not-allowed"
                                >
                                    ...
                                </span>
                                <button 
                                    v-else
                                    @click="changePage(page)"
                                    class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full transition-all duration-300"
                                    :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                                >
                                    {{ page }}
                                </button>
                            </template>

                            <button 
                                @click="changePage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full transition-all duration-300"
                                :class="currentPage === totalPages ? 'text-gray-300 bg-gray-50/50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'"
                                v-html="'Selanjutnya &raquo;'"
                            ></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>