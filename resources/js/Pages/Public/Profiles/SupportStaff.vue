<script setup lang="ts">
import { ref, watch, onMounted, computed } from 'vue';
import { router, Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { debounce } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { 
    Briefcase, Award, BookOpen, UserCircle, X, 
    GraduationCap, Link as LinkIcon, Search, BookMarked, Linkedin, FileX2, Users, User,
    CheckCircle2
} from 'lucide-vue-next';

const props = defineProps<{
    staff?: any; 
    filters?: { search?: string };
}>();

const search = ref(props.filters?.search || '');
const isFiltering = computed(() => search.value !== '');

const activeTab = ref('akademik');

onMounted(() => { 
    AOS.init({ duration: 800, once: true }); 
});

watch(search, debounce(() => {
    router.get(route(route().current() as string), { search: search.value }, { preserveState: true, replace: true, onFinish: () => AOS.refresh() });
}, 400));

const isModalOpen = ref(false);
const selectedPerson = ref<any>(null);

const openModal = (person: any) => {
    selectedPerson.value = person;
    activeTab.value = 'akademik'; 
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => { selectedPerson.value = null; }, 300);
    document.body.style.overflow = 'auto';
};

const sortByYearDesc = (arr: string[]) => {
    if (!arr || !Array.isArray(arr)) return [];
    return [...arr].sort((a, b) => {
        const matchA = a.match(/\b(19|20)\d{2}\b/);
        const matchB = b.match(/\b(19|20)\d{2}\b/);
        const yearA = matchA ? parseInt(matchA[0]) : 0;
        const yearB = matchB ? parseInt(matchB[0]) : 0;
        return yearB - yearA;
    });
};

const hasDetailedInfo = computed(() => {
    if (!selectedPerson.value) return false;
    const p = selectedPerson.value;
    return (p.expertise?.length > 0) || 
           (p.education_history?.length > 0) || 
           (p.work_experience?.length > 0) || 
           (p.research_history?.length > 0) || 
           (p.awards?.length > 0) ||
           (p.competency_certification?.length > 0) ||
           (p.community_service_history?.length > 0);
});

const maskNip = (nip: string | null) => {
    if (!nip) return '-';
    if (nip.length <= 4) return nip + '***';
    return nip.substring(0, 4) + '***';
};
</script>

<template>
    <PublicLayout>
        <Head title="Daftar Tenaga Kependidikan" />
        <Banner title="TENAGA KEPENDIDIKAN" subtitle="Fakultas Sains dan Teknologi Informasi" background-image="/images/background-banner.webp" />

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
                                <Users class="w-8 h-8 md:w-9 md:h-9 text-primary" />
                            </div>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4 leading-tight">Tenaga <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Kependidikan</span></h2>
                        <p class="text-gray-600 font-medium text-[15px] md:text-[16px] max-w-xl mx-auto leading-relaxed">Kenali staf dan tenaga kependidikan yang berdedikasi dalam mendukung seluruh layanan akademik dan operasional di FSTI ITK.</p>
                    </div>
                </div>

                <div class="mb-12 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 relative z-20 max-w-3xl mx-auto" data-aos="fade-down">
                    <div class="relative">
<input type="text" placeholder="Cari nama staf, jabatan, atau NIP..." v-model="search" class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium text-xs sm:text-sm md:text-base text-ellipsis transition-all" />                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600"><X class="w-5 h-5" /></button>
                    </div>
                </div>

                <div v-if="isFiltering" class="mb-8 max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span>Hasil pencarian untuk <span class="text-primary">"{{ search }}"</span></span>
                    </h3>
                    <button @click="search = ''" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">Reset Pencarian</button>
                </div>

                <div v-if="staff?.data && staff.data.length > 0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 xl:gap-8" data-aos="fade-up" data-aos-delay="100">
                        <div v-for="person in staff.data" :key="person.id" class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-1.5 transition-all duration-500 flex flex-col group relative">
                            <div class="h-64 w-full bg-gray-100 relative overflow-hidden">
                                <img v-if="person.display_image" :src="person.display_image" :alt="person.name" loading="lazy" decoding="async" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 mix-blend-multiply">
                                <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 group-hover:scale-105 transition-transform duration-700">
                                    <User class="w-24 h-24 opacity-60 text-gray-400" />
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-[2px]">
                                    <button @click="openModal(person)" class="bg-white/95 text-primary text-sm font-bold px-6 py-2.5 rounded-xl shadow-lg hover:bg-primary hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 flex items-center gap-2"><UserCircle class="w-4 h-4" /> Lihat Profil</button>
                                </div>
                            </div>
                            
                            <div class="p-6 flex flex-col flex-grow text-center relative bg-white z-10 border-t border-gray-100">
                                <h3 class="font-bold text-[17px] text-gray-900 mb-1.5 leading-snug line-clamp-2 group-hover:text-primary transition-colors">{{ person.name }}</h3>
                                <p class="text-sm font-semibold text-primary/80 mb-4 line-clamp-2">{{ person.structural_position || person.functional_position || 'Tenaga Kependidikan ITK' }}</p>
                                <p class="text-xs text-gray-400 font-medium mt-auto">NIP. {{ maskNip(person.nip) }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="staff.links && staff.links.length > 3" class="mt-16 flex flex-wrap justify-center gap-2" data-aos="fade-up">
                        <template v-for="(link, p) in staff.links" :key="p">
                            <div v-if="link.url === null" class="px-4 py-2.5 text-sm font-semibold text-gray-400 bg-gray-50 border border-gray-200 rounded-xl cursor-not-allowed" v-html="link.label.replace('Previous', 'Sebelumnya').replace('Next', 'Selanjutnya')" />
                            <Link v-else :href="link.url" class="px-4 py-2.5 text-sm font-bold border rounded-xl transition-all shadow-sm" :class="link.active ? 'bg-primary text-white border-primary shadow-md' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:text-primary hover:border-primary/30'" v-html="link.label.replace('Previous', 'Sebelumnya').replace('Next', 'Selanjutnya')" />
                        </template>
                    </div>
                </div>

                <div v-else class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4"><FileX2 class="h-10 w-10 text-primary" /></div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">Data tenaga kependidikan tidak ditemukan atau keyword pencarian tidak cocok.</p>
                </div>
            </div>
        </div>

        <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 sm:p-6 lg:p-10 font-public-sans" @click.self="closeModal">
                
                <div class="bg-white rounded-[2rem] shadow-2xl w-full flex flex-col transform transition-all border border-white/20 overflow-hidden" 
                     :class="hasDetailedInfo ? 'max-w-6xl h-[95vh] md:h-[85vh]' : 'max-w-[420px] h-auto max-h-[90vh]'" 
                     v-if="selectedPerson">
                    
                    <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-6 bg-primary rounded-full"></div>
                            <h3 class="text-lg font-bold text-gray-800">Profil Tenaga Kependidikan</h3>
                        </div>
                        <button @click="closeModal" class="p-2 bg-white border border-gray-200 text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-full transition-all shadow-sm"><X class="w-5 h-5" /></button>
                    </div>

                    <div class="flex flex-col h-full overflow-hidden" :class="hasDetailedInfo ? 'lg:flex-row' : ''">
                        
                        <div class="bg-white flex flex-col overflow-y-auto custom-scrollbar z-10 w-full" 
                             :class="hasDetailedInfo ? 'lg:w-[35%] border-r border-gray-100 shadow-[4px_0_24px_rgba(0,0,0,0.02)] h-full' : 'h-auto pb-6'">
                            
                            <div class="p-8 text-center border-gray-50 bg-gradient-to-b from-gray-50/50 to-white" 
                                 :class="(hasDetailedInfo || (selectedPerson.structural_position && selectedPerson.functional_position) || selectedPerson.expertise?.length > 0) ? 'border-b' : ''">
                                
                                <div class="w-40 h-40 mx-auto rounded-full border-[6px] border-white shadow-lg p-1 bg-white mb-6 relative">
                                    <img v-if="selectedPerson.display_image" :src="selectedPerson.display_image" :alt="selectedPerson.name" class="w-full h-full object-cover object-center rounded-full">
                                    <div v-else class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400 rounded-full">
                                        <User class="w-16 h-16 opacity-60 text-gray-400" />
                                    </div>
                                    <div class="absolute bottom-2 right-2 bg-emerald-500 w-6 h-6 border-[3px] border-white rounded-full"></div>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-snug mb-2">{{ selectedPerson.name }}</h2>
                                <p class="text-[15px] font-bold text-primary mb-1">{{ selectedPerson.structural_position || selectedPerson.functional_position }}</p>
                                <p class="text-sm text-gray-500 font-medium">NIP. {{ maskNip(selectedPerson.nip) }}</p>

                                <div v-if="selectedPerson.academic_profiles?.length > 0" class="mt-6 flex flex-wrap justify-center gap-3">
                                    <a v-for="(link, i) in selectedPerson.academic_profiles" :key="i" :href="link" target="_blank" class="w-10 h-10 flex items-center justify-center bg-gray-50 border border-gray-200 text-gray-600 rounded-full hover:bg-primary hover:text-white hover:border-primary hover:-translate-y-1 transition-all duration-300 shadow-sm">
                                        <Linkedin v-if="link.toLowerCase().includes('linkedin.com')" class="w-4 h-4" />
                                        <BookMarked v-else-if="link.toLowerCase().includes('scopus.com')" class="w-4 h-4" />
                                        <LinkIcon v-else class="w-4 h-4" />
                                    </a>
                                </div>
                            </div>

                            <div v-if="(selectedPerson.structural_position && selectedPerson.functional_position) || selectedPerson.expertise?.length > 0" class="px-8 pb-8 pt-4 flex-grow">
                                <div v-if="selectedPerson.structural_position && selectedPerson.functional_position" class="mb-8">
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Tugas / Jabatan Lainnya</h4>
                                    <div class="flex items-start gap-3 bg-blue-50/50 p-4 rounded-xl border border-blue-100/50">
                                        <Briefcase class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" />
                                        <span class="text-sm font-bold text-gray-800 leading-snug">{{ selectedPerson.functional_position }}</span>
                                    </div>
                                </div>

                                <div v-if="selectedPerson.expertise?.length > 0">
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Bidang Keahlian Utama</h4>
                                    <div class="flex flex-wrap gap-2">
                                        <span v-for="(expert, i) in selectedPerson.expertise" :key="i" class="px-3.5 py-1.5 bg-gray-50 text-gray-700 text-[13px] font-bold rounded-lg border border-gray-200">{{ expert }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="hasDetailedInfo" class="w-full lg:w-[65%] bg-slate-50/30 flex flex-col overflow-hidden relative">
                            
                            <div class="flex overflow-x-auto custom-scrollbar border-b border-gray-200 bg-white sticky top-0 z-20 px-6 sm:px-10 pt-6 gap-2">
                                <button @click="activeTab = 'akademik'" class="pb-4 px-3 text-[15px] font-bold whitespace-nowrap transition-colors border-b-2" :class="activeTab === 'akademik' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700'">
                                    Pendidikan & Karir
                                </button>
                                <button v-if="selectedPerson.research_history?.length || selectedPerson.community_service_history?.length" @click="activeTab = 'riset'" class="pb-4 px-3 text-[15px] font-bold whitespace-nowrap transition-colors border-b-2" :class="activeTab === 'riset' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700'">
                                    Riset & Pengabdian
                                </button>
                                <button v-if="selectedPerson.competency_certification?.length" @click="activeTab = 'sertifikasi'" class="pb-4 px-3 text-[15px] font-bold whitespace-nowrap transition-colors border-b-2" :class="activeTab === 'sertifikasi' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700'">
                                    Sertifikasi
                                </button>
                                <button v-if="selectedPerson.awards?.length" @click="activeTab = 'penghargaan'" class="pb-4 px-3 text-[15px] font-bold whitespace-nowrap transition-colors border-b-2" :class="activeTab === 'penghargaan' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700'">
                                    Penghargaan
                                </button>
                            </div>

                            <div class="p-6 sm:p-10 overflow-y-auto custom-scrollbar h-full">
                                
                                <div v-if="activeTab === 'akademik'" class="space-y-12 animate-fade-in">
                                    <div v-if="selectedPerson.education_history?.length > 0">
                                        <div class="flex items-center gap-3 mb-8">
                                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center"><GraduationCap class="w-5 h-5 text-primary"/></div>
                                            <h3 class="text-xl font-bold text-gray-900">Riwayat Pendidikan</h3>
                                        </div>
                                        <div class="relative border-l-[3px] border-gray-200 ml-5 space-y-8 pb-4">
                                            <div v-for="(edu, i) in sortByYearDesc(selectedPerson.education_history)" :key="i" class="relative pl-8 group">
                                                <div class="absolute -left-[11px] top-1 w-5 h-5 bg-white border-[4px] border-primary rounded-full group-hover:scale-125 transition-transform duration-300 shadow-sm"></div>
                                                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                                    <p class="text-[15px] font-medium text-gray-700 leading-relaxed">{{ edu }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="selectedPerson.work_experience?.length > 0">
                                        <div class="flex items-center gap-3 mb-8">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center"><Briefcase class="w-5 h-5 text-blue-600"/></div>
                                            <h3 class="text-xl font-bold text-gray-900">Pengalaman Kerja</h3>
                                        </div>
                                        <div class="relative border-l-[3px] border-gray-200 ml-5 space-y-8 pb-4">
                                            <div v-for="(work, i) in sortByYearDesc(selectedPerson.work_experience)" :key="i" class="relative pl-8 group">
                                                <div class="absolute -left-[11px] top-1 w-5 h-5 bg-white border-[4px] border-blue-500 rounded-full group-hover:scale-125 transition-transform duration-300 shadow-sm"></div>
                                                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                                    <p class="text-[15px] font-medium text-gray-700 leading-relaxed">{{ work }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="activeTab === 'riset'" class="space-y-12 animate-fade-in">
                                    <div v-if="selectedPerson.research_history?.length > 0">
                                        <div class="flex items-center gap-3 mb-8">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center"><BookOpen class="w-5 h-5 text-indigo-600"/></div>
                                            <h3 class="text-xl font-bold text-gray-900">Riwayat Riset / Penelitian</h3>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div v-for="(research, i) in sortByYearDesc(selectedPerson.research_history)" :key="i" class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-start gap-4 hover:border-indigo-300 transition-colors">
                                                <CheckCircle2 class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5" />
                                                <span class="text-[15px] font-medium text-gray-700 leading-relaxed">{{ research }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="selectedPerson.community_service_history?.length > 0">
                                        <div class="flex items-center gap-3 mb-8">
                                            <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center"><Users class="w-5 h-5 text-teal-600"/></div>
                                            <h3 class="text-xl font-bold text-gray-900">Pengabdian Kepada Masyarakat</h3>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div v-for="(pkm, i) in sortByYearDesc(selectedPerson.community_service_history)" :key="i" class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-start gap-4 hover:border-teal-300 transition-colors">
                                                <CheckCircle2 class="w-5 h-5 text-teal-500 flex-shrink-0 mt-0.5" />
                                                <span class="text-[15px] font-medium text-gray-700 leading-relaxed">{{ pkm }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="activeTab === 'sertifikasi'" class="animate-fade-in">
                                    <div class="flex items-center gap-3 mb-8">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center"><Award class="w-5 h-5 text-emerald-600"/></div>
                                        <h3 class="text-xl font-bold text-gray-900">Sertifikasi Kompetensi</h3>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div v-for="(cert, i) in sortByYearDesc(selectedPerson.competency_certification)" :key="i" class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-start gap-4">
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full mt-2 flex-shrink-0"></div>
                                            <span class="text-[15px] font-medium text-gray-700 leading-relaxed">{{ cert }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="activeTab === 'penghargaan'" class="animate-fade-in">
                                    <div class="flex items-center gap-3 mb-8">
                                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center"><Award class="w-5 h-5 text-amber-600"/></div>
                                        <h3 class="text-xl font-bold text-gray-900">Penghargaan / Prestasi</h3>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div v-for="(award, i) in sortByYearDesc(selectedPerson.awards)" :key="i" class="bg-gradient-to-br from-amber-50 to-white p-6 rounded-2xl border border-amber-200/60 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
                                            <Award class="w-6 h-6 text-amber-500 flex-shrink-0 mt-0.5" />
                                            <span class="text-[14px] font-bold text-gray-800 leading-relaxed">{{ award }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </PublicLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
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