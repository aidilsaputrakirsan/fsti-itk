<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, router } from '@inertiajs/vue3';
import { Search, Handshake, CheckCircle, X, FileX2 } from 'lucide-vue-next';
import { throttle } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({ partners: Object, filters: Object });
const searchQuery = ref(props.filters.search || '');
const isFiltering = computed(() => searchQuery.value !== '');

watch(searchQuery, throttle((newSearch) => {
    router.get(route('partners.index'), { search: newSearch }, { preserveState: true, replace: true, onFinish: () => AOS.refresh() });
}, 300));

onMounted(() => { AOS.init({ duration: 800, once: true }); });

const currentPage = computed(() => props.partners.links.find(l => l.active) ? parseInt(props.partners.links.find(l => l.active).label) : 1);
const totalPages = computed(() => props.partners.links.length > 2 ? props.partners.links.length - 2 : 1);
const visiblePages = computed(() => {
    if (totalPages.value <= 5) return Array.from({ length: totalPages.value }, (_, i) => i + 1);
    if (currentPage.value <= 3) return [1, 2, 3, 4, '...', totalPages.value];
    if (currentPage.value >= totalPages.value - 2) return [1, '...', totalPages.value - 3, totalPages.value - 2, totalPages.value - 1, totalPages.value];
    return [1, '...', currentPage.value - 1, currentPage.value, currentPage.value + 1, '...', totalPages.value];
});
const changePage = (p) => {
    if (typeof p === 'number' && p >= 1 && p <= totalPages.value) {
        router.get(route('partners.index'), { search: searchQuery.value, page: p }, { preserveState: true, replace: true, onFinish: () => { window.scrollTo({ top: 350, behavior: 'smooth' }); AOS.refresh(); } });
    }
};
</script>

<template>
    <PublicLayout>
        <Head title="Mitra Kerjasama - FSTI ITK" />
        <Banner title="MITRA KERJASAMA" subtitle="Jejak Kolaborasi Industri dan Instansi FSTI ITK" background-image="/images/background-banner.png" />

        <div class="bg-white py-12 md:py-24 min-h-screen font-public-sans overflow-x-hidden relative">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
                <div class="absolute top-[-10%] left-[-5%] w-[40rem] h-[40rem] bg-primary/5 rounded-full blur-[100px]"></div>
                <div class="absolute top-[20%] right-[-10%] w-[35rem] h-[35rem] bg-blue-400/5 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-[-10%] left-[20%] w-[30rem] h-[30rem] bg-indigo-300/10 rounded-full blur-[120px]"></div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

                <div class="relative w-full bg-gradient-to-br from-primary to-primary-hover rounded-[2rem] p-6 sm:p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary/50" data-aos="fade-up">
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-400/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    
                    <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-xs md:text-sm font-bold mb-4 md:mb-6 shadow-sm uppercase tracking-wider">
                            <Handshake class="w-4 h-4" /> Kerjasama Fakultas
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-5xl font-optimus font-bold mb-3 md:mb-4 leading-tight drop-shadow-sm">Jaringan Mitra<br/>Strategis FSTI</h2>
                        <p class="text-blue-50 text-sm sm:text-base md:text-lg font-light leading-relaxed max-w-xl opacity-90 pb-2 md:pb-4">
                            Temukan berbagai daftar kerjasama dan kolaborasi yang diselenggarakan oleh FSTI dengan instansi dan industri.
                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 transition-all duration-500 shadow-2xl">
                        <Handshake class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-12 md:-mt-16 mx-2 sm:mx-4 md:mx-8 mb-12 bg-white p-3 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-gray-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari nama institusi atau mitra..." 
                            class="w-full pl-10 md:pl-12 pr-10 py-3 md:py-3.5 text-sm md:text-base border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium hover:bg-white transition-colors"
                            v-model="searchQuery"
                        >
                        <Search class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 w-4 md:w-5 h-4 md:h-5 text-gray-400" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-2 md:right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 transition-colors">
                            <X class="w-4 md:w-5 h-4 md:h-5" />
                        </button>
                    </div>
                </div>

                <div v-if="isFiltering" class="mb-8 mx-2 sm:mx-4 md:mx-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span>Hasil pencarian untuk <span class="text-primary">"{{ searchQuery }}"</span></span>
                    </h3>
                    <button @click="searchQuery = ''" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto">Reset Pencarian</button>
                </div>

                <div v-if="partners.data.length === 0" class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm mx-2 sm:mx-4 md:mx-8" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4">
                        <FileX2 class="h-10 w-10 text-primary" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Mitra kerjasama dengan nama tersebut tidak ditemukan.</p>
                </div>

                <div v-else class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 lg:gap-8 mx-2 sm:mx-4 md:mx-8">
                    <div v-for="(partner, index) in partners.data" :key="partner.id" class="bg-white rounded-[1rem] md:rounded-[1.5rem] border border-gray-200 shadow-sm hover:shadow-xl hover:border-primary/30 transform hover:-translate-y-1 transition-all duration-300 flex flex-col h-[300px] sm:h-[380px] md:h-[460px] group overflow-hidden" data-aos="fade-up" :data-aos-delay="(index % 10) * 50">
                        
                        <div class="h-28 sm:h-36 md:h-52 w-full bg-white border-b border-gray-100 p-3 sm:p-4 md:p-6 flex items-center justify-center shrink-0">
                            <img v-if="partner.logo_url" :src="partner.logo_url" :alt="partner.name" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-300 group-hover:scale-105" />
                            <div v-else class="text-gray-300 flex flex-col items-center">
                                <Handshake class="w-6 h-6 md:w-10 md:h-10 mb-1 md:mb-2 opacity-50" />
                                <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-center">No Logo</span>
                            </div>
                        </div>

                        <div class="p-3 sm:p-4 md:p-6 flex flex-col flex-grow bg-gray-50/50 min-h-0">
                            <div v-if="partner.activities && partner.activities.length > 0" class="mb-2 md:mb-3 shrink-0">
                                <span class="inline-flex items-center px-2 py-0.5 md:px-3 md:py-1 bg-blue-100 text-primary rounded-md text-[10px] sm:text-xs font-bold">
                                    {{ partner.activities.length }} Kegiatan
                                </span>
                            </div>

                            <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-800 group-hover:text-primary transition-colors leading-snug mb-2 md:mb-4 line-clamp-2 shrink-0">{{ partner.name }}</h3>
                            
                            <div v-if="partner.activities && partner.activities.length > 0" class="flex-grow overflow-y-auto min-h-0 pr-1 md:pr-2 space-y-2 md:space-y-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
                                <ul class="space-y-1.5 md:space-y-3">
                                    <li v-for="(act, idx) in partner.activities" :key="idx" class="flex items-start gap-1.5 md:gap-2.5 text-[11px] sm:text-xs md:text-sm text-gray-600 font-medium">
                                        <CheckCircle class="w-3 h-3 md:w-4 md:h-4 text-primary shrink-0 mt-0.5 md:mt-0.5" />
                                        <span class="leading-relaxed line-clamp-2 md:line-clamp-none">{{ act }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="totalPages > 1 && partners.data.length > 0" class="mt-12 md:mt-16 mx-2 sm:mx-4 md:mx-8 flex flex-col md:flex-row items-center justify-between gap-4 md:gap-6 bg-white py-4 px-4 md:px-10 rounded-3xl md:rounded-full shadow-sm border border-gray-100" data-aos="fade-in">
                    <p class="text-xs md:text-sm font-medium text-gray-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ partners.from }}</span> - <span class="text-primary font-bold">{{ partners.to }}</span> dari <span class="text-primary font-bold">{{ partners.total }}</span> Mitra
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-1.5 md:gap-2">
                        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === 1 ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'">&laquo; Sebelumnya</button>

                        <template v-for="page in visiblePages" :key="page">
                            <span v-if="page === '...'" class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full text-gray-300 bg-gray-50 cursor-not-allowed">...</span>
                            <button v-else @click="changePage(page)" class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'">{{ page }}</button>
                        </template>

                        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="min-w-[2rem] md:min-w-[2.5rem] h-8 md:h-10 px-2 md:px-4 flex items-center justify-center text-xs md:text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === totalPages ? 'text-gray-300 bg-gray-50 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 hover:text-primary'">Selanjutnya &raquo;</button>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>