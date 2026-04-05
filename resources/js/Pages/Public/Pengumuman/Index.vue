<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, router } from '@inertiajs/vue3';
import { Search, Megaphone, X, FileDown, CalendarDays, Eye } from 'lucide-vue-next';
import { throttle } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({ announcements: Object, filters: Object });
const searchQuery = ref(props.filters.search || '');

watch(searchQuery, throttle((newSearch) => {
    router.get(route('pengumuman.index'), { search: newSearch }, { preserveState: true, replace: true, onFinish: () => AOS.refresh() });
}, 300));

onMounted(() => { AOS.init({ duration: 800, once: true }); });

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// --- LOGIKA PAGINATION ---
const currentPage = computed(() => props.announcements.links.find(l => l.active) ? parseInt(props.announcements.links.find(l => l.active).label) : 1);
const totalPages = computed(() => props.announcements.links.length > 2 ? props.announcements.links.length - 2 : 1);
const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;
    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
    if (current <= 4) return [1, 2, 3, 4, 5, '...', total];
    if (current >= total - 3) return [1, '...', total - 4, total - 3, total - 2, total - 1, total];
    return [1, '...', current - 1, current, current + 1, '...', total];
});

const changePage = (p) => {
    if (typeof p === 'number' && p >= 1 && p <= totalPages.value) {
        router.get(route('pengumuman.index'), { search: searchQuery.value, page: p }, { preserveState: true, replace: true, onFinish: () => { window.scrollTo({ top: 350, behavior: 'smooth' }); AOS.refresh(); } });
    }
};

// --- LOGIKA MODAL PREVIEW ---
const isModalOpen = ref(false);
const selectedItem = ref(null);

const openModal = (item) => {
    selectedItem.value = item;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => { selectedItem.value = null; }, 300);
    document.body.style.overflow = 'auto'; // Buka kunci scroll
};

onUnmounted(() => {
    document.body.style.overflow = 'auto';
});
</script>

<template>
    <PublicLayout>
        <Head title="Pusat Pengumuman - FSTI ITK" />
        <Banner title="PENGUMUMAN" subtitle="Informasi Terbaru dan Edaran Resmi FSTI ITK" background-image="/images/background-banner.png" />

        <div class="bg-white py-16 md:py-24 min-h-screen font-public-sans overflow-x-hidden relative">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary to-primary-hover rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary/50" data-aos="fade-up">
                    <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-400/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
                    
                    <div class="relative z-10 text-white w-full max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-bold mb-6 shadow-sm uppercase tracking-wider">
                            <Megaphone class="w-4 h-4" /> Pengumuman 
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm">Lihat Pengumuman<br/> Resmi FSTI </h2>
                        <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90 pb-4">
Lihat dan unduh berbagai pengumuman terbaru dalam satu halaman.                        </p>
                    </div>
                    <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform -rotate-3 hover:rotate-3 transition-all duration-500 shadow-2xl">
                        <Megaphone class="w-32 h-32 text-white/90" stroke-width="1.5" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-4 md:mx-8 mb-16 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input type="text" placeholder="Cari judul pengumuman atau surat edaran..." class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 text-slate-800 font-medium hover:bg-white transition-colors" v-model="searchQuery">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                <div v-if="announcements.data.length === 0" class="text-center py-20 bg-slate-50/50 rounded-[2rem] border border-dashed border-slate-200 shadow-sm" data-aos="fade-up">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100">
                        <Megaphone class="w-10 h-10 text-primary/40" />
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 font-optimus">Pengumuman Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Mungkin pengumuman yang Anda cari belum diterbitkan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="(item, index) in announcements.data" :key="item.id" class="bg-white rounded-[1.5rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-primary/30 transform hover:-translate-y-1 transition-all duration-300 flex flex-col h-[500px] group overflow-hidden" data-aos="fade-up" :data-aos-delay="index * 50">
                        
                        <div @click="openModal(item)" class="h-60 w-full relative shrink-0 overflow-hidden bg-slate-100 border-b border-slate-100 cursor-pointer">
                            
                            <div v-if="item.poster_path" class="w-full h-full relative">
                                <img :src="`/storage/${item.poster_path}`" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                <div v-if="item.document_path" class="absolute top-3 right-3 bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-md border border-white/50 flex items-center gap-1.5 z-20">
                                    <FileDown class="w-4 h-4 text-primary" />
                                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest">PDF Terlampir</span>
                                </div>
                            </div>
                            
                            <div v-else-if="item.document_path" class="w-full h-full relative group-hover:scale-105 transition-transform duration-500 bg-white">
                                <iframe :src="`/storage/${item.document_path}#view=FitH&toolbar=0&navpanes=0&scrollbar=0`" class="absolute inset-0 w-full h-[140%] -top-[20%] pointer-events-none opacity-95" frameborder="0" scrolling="no" loading="lazy"></iframe>
                                <div class="absolute inset-0 z-10 bg-transparent"></div>
                                <div class="absolute top-3 right-3 bg-blue-50/95 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-md border border-blue-100 flex items-center gap-1.5 z-20">
                                    <Megaphone class="w-4 h-4 text-primary" />
                                    <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Dokumen Resmi</span>
                                </div>
                            </div>

                            <div v-else class="w-full h-full bg-gradient-to-br from-[#003566] to-primary flex flex-col items-center justify-center relative group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-[url('/images/pattern-berita.png')] opacity-20 mix-blend-overlay"></div>
                                <Megaphone class="w-16 h-16 text-white/50 mb-3" />
                                <span class="text-white/80 font-bold uppercase tracking-widest text-xs border border-white/30 px-3 py-1 rounded-full backdrop-blur-sm">Informasi Teks</span>
                            </div>

                            <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-300 pointer-events-none z-20"></div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow bg-white relative">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-3">
                                <CalendarDays class="w-4 h-4 text-primary" />
                                {{ formatDate(item.created_at) }}
                            </div>

                            <h3 @click="openModal(item)" class="text-lg font-bold text-slate-800 group-hover:text-primary transition-colors leading-snug mb-3 line-clamp-3 cursor-pointer" :title="item.title">{{ item.title }}</h3>
                            <p v-if="item.description" class="text-sm text-slate-600 line-clamp-2 mb-4">{{ item.description }}</p>

                            <div class="mt-auto pt-4 border-t border-slate-100 flex items-center gap-3">
                                <template v-if="item.document_path">
                                    <a :href="`/storage/${item.document_path}`" target="_blank" rel="noopener noreferrer" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-3 bg-white border border-slate-200 text-slate-600 hover:border-primary hover:text-primary rounded-xl font-bold text-sm transition-all duration-300 group/btn1">
                                        <Eye class="w-4 h-4 group-hover/btn1:scale-110 transition-transform" />
                                        Lihat PDF
                                    </a>
                                    <a :href="`/storage/${item.document_path}`" :download="`${item.title}.pdf`" class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-3 bg-blue-50 text-primary hover:bg-primary hover:text-white rounded-xl font-bold text-sm transition-colors duration-300 group/btn2">
                                        <FileDown class="w-4 h-4 group-hover/btn2:animate-bounce" />
                                        Unduh
                                    </a>
                                </template>
                                <template v-else>
                                    <button @click="openModal(item)" class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-3 bg-blue-50 text-primary hover:bg-primary hover:text-white rounded-xl font-bold text-sm transition-colors duration-300 group/btn3">
                                        <Eye class="w-4 h-4 group-hover/btn3:scale-110 transition-transform" />
                                        Lihat Detail Lengkap
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="totalPages > 1" class="mt-16 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-slate-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-slate-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ announcements.from }}</span> - <span class="text-primary font-bold">{{ announcements.to }}</span> dari <span class="text-primary font-bold">{{ announcements.total }}</span> Pengumuman
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === 1 ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'" v-html="'&laquo; Previous'"></button>
                        <template v-for="(page, index) in visiblePages" :key="index">
                            <span v-if="page === '...'" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full text-slate-300 bg-slate-50/50 cursor-not-allowed">...</span>
                            <button v-else @click="changePage(page)" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === page ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'">{{ page }}</button>
                        </template>
                        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" :class="currentPage === totalPages ? 'text-slate-300 bg-slate-50/50 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 hover:text-primary'" v-html="'Next &raquo;'"></button>
                    </div>
                </div>

            </div>
        </div>

        <Teleport to="body">
            <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-black/60 backdrop-blur-sm" @click.self="closeModal">
                    <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 translate-y-0 sm:scale-100" leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        
                        <div v-if="isModalOpen" class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl relative">
                            <button @click="closeModal" class="absolute top-4 right-4 p-2 bg-slate-100 hover:bg-red-100 rounded-full text-slate-600 hover:text-red-500 z-10 transition-colors shadow-sm">
                                <X class="w-5 h-5" />
                            </button>

                            <div class="overflow-y-auto p-6 md:p-8 scrollbar-thin scrollbar-thumb-slate-300">
                                
                                <div v-if="selectedItem?.poster_path" class="mb-8 rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex justify-center">
                                    <img :src="`/storage/${selectedItem.poster_path}`" class="max-w-full h-auto object-contain max-h-[70vh] shadow-sm" />
                                </div>
                                
                                <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-4 leading-snug">{{ selectedItem?.title }}</h2>
                                
                                <div class="flex items-center gap-2 text-sm font-bold text-slate-500 mb-6 pb-4 border-b border-slate-100">
                                    <CalendarDays class="w-4 h-4 text-primary" />
                                    {{ selectedItem ? formatDate(selectedItem.created_at) : '' }}
                                </div>
                                
                                <div class="prose max-w-none text-slate-600 whitespace-pre-wrap leading-relaxed text-base">
                                    {{ selectedItem?.description || 'Tidak ada keterangan tambahan.' }}
                                </div>

                                <div v-if="selectedItem?.document_path" class="mt-8 pt-6 border-t border-slate-100">
                                    <a :href="`/storage/${selectedItem.document_path}`" :download="`${selectedItem.title}.pdf`" class="inline-flex items-center justify-center gap-2 py-3 px-6 bg-primary text-white hover:bg-primary-hover rounded-xl font-bold text-sm transition-colors duration-300 shadow-md">
                                        <FileDown class="w-5 h-5" />
                                        Unduh Dokumen PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                    </transition>
                </div>
            </transition>
        </Teleport>

    </PublicLayout>
</template>