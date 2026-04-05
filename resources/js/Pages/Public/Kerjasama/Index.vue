<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, router } from '@inertiajs/vue3';
import { Search, Handshake, CheckCircle, X } from 'lucide-vue-next';
import { throttle } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({ partners: Object, filters: Object });
const searchQuery = ref(props.filters.search || '');

watch(searchQuery, throttle((newSearch) => {
    router.get(route('kerjasama.index'), { search: newSearch }, { preserveState: true, replace: true, onFinish: () => AOS.refresh() });
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
        router.get(route('kerjasama.index'), { search: searchQuery.value, page: p }, { preserveState: true, replace: true, onFinish: () => { window.scrollTo({ top: 350, behavior: 'smooth' }); AOS.refresh(); } });
    }
};
</script>

<template>
    <PublicLayout>
        <Head title="Mitra Kerjasama - FSTI ITK" />
        <Banner title="MITRA KERJASAMA" subtitle="Jejak Kolaborasi Industri dan Instansi FSTI ITK" background-image="/images/background-banner.png" />

        <div class="bg-slate-50 py-16 md:py-24 min-h-screen font-public-sans overflow-x-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary to-primary-hover rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary/50" data-aos="fade-up">
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-400/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    
                    <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-bold mb-6 shadow-sm uppercase tracking-wider">
                            <Handshake class="w-4 h-4" /> Kerjasama Fakultas
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm">Jaringan Mitra<br/>Strategis FSTI</h2>
                        <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90 pb-4">
                            Temukan berbagai daftar kerjasama dan kolaborasi yang diselenggarakan oleh FSTI dengan instansi dan industri.
                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 transition-all duration-500 shadow-2xl">
                        <Handshake class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-4 md:mx-8 mb-16 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari nama institusi atau mitra kerjasama..." 
                            class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 text-slate-800 font-medium hover:bg-white transition-colors"
                            v-model="searchQuery"
                        >
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                <div v-if="partners.data.length === 0" class="text-center py-20 bg-slate-50/50 rounded-[2rem] border border-dashed border-slate-200 shadow-sm" data-aos="fade-up">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                        <Handshake class="w-10 h-10 text-primary/40" />
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 font-optimus">Mitra Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Mungkin mitra kerjasama yang Anda cari belum terdaftar di direktori kami.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="(partner, index) in partners.data" :key="partner.id" class="bg-white rounded-[1.5rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-primary/30 transform hover:-translate-y-1 transition-all duration-300 flex flex-col h-[460px] group" data-aos="fade-up" :data-aos-delay="index * 50">
                        
                        <div class="h-52 w-full bg-white border-b border-slate-100 p-6 flex items-center justify-center rounded-t-[1.5rem] shrink-0">
                            <img v-if="partner.logo" :src="`/images/mitra/${partner.logo}`" :alt="partner.name" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-300 group-hover:scale-105" />
                            <div v-else class="text-slate-300 flex flex-col items-center">
                                <Handshake class="w-10 h-10 mb-2 opacity-50" />
                                <span class="text-xs font-bold uppercase tracking-widest">No Logo</span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow bg-slate-50/50 rounded-b-[1.5rem]">
                            
                            <div v-if="partner.activities && partner.activities.length > 0" class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-primary rounded-md text-xs font-bold">
                                    {{ partner.activities.length }} Kegiatan
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-primary transition-colors leading-snug mb-4 line-clamp-2">{{ partner.name }}</h3>
                            
                            <div v-if="partner.activities && partner.activities.length > 0" class="flex-grow overflow-y-auto pr-2 space-y-3 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                                <ul class="space-y-3">
                                    <li v-for="(act, idx) in partner.activities" :key="idx" class="flex items-start gap-2.5 text-sm text-slate-600 font-medium">
                                        <CheckCircle class="w-4 h-4 text-primary shrink-0 mt-0.5" />
                                        <span class="leading-relaxed">{{ act }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="totalPages > 1" class="mt-16 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-slate-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-slate-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ partners.from }}</span> - <span class="text-primary font-bold">{{ partners.to }}</span> dari <span class="text-primary font-bold">{{ partners.total }}</span> Daftar Kerjasama
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === 1 ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'">&laquo; Prev</button>

                        <template v-for="page in visiblePages" :key="page">
                            <span v-if="page === '...'" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full text-slate-300 bg-slate-50/50 cursor-not-allowed">...</span>
                            <button v-else @click="changePage(page)" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'">{{ page }}</button>
                        </template>

                        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === totalPages ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'">Next &raquo;</button>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>