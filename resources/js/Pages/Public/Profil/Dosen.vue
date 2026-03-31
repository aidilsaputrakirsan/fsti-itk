<script setup lang="ts">
import { ref, watch, onMounted, onUnmounted, computed } from 'vue';
import { router, Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { debounce } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { 
    Briefcase, Award, BookOpen, UserCircle, X, ChevronDown, 
    GraduationCap, Link as LinkIcon, Search, ListFilter, BookMarked, Linkedin, FileX2, Users
} from 'lucide-vue-next';

interface PaginatedStaff {
    data: any[];
    links: any[];
}

const props = defineProps<{
    dosen: PaginatedStaff;
    filters: { search?: string; prodi?: string };
    prodiList: string[];
}>();

const search = ref(props.filters.search || '');
const prodi = ref(props.filters.prodi || '');

const isFiltering = computed(() => search.value !== '' || prodi.value !== '');

// --- LOGIKA DROPDOWN FILTER PRODI ---
const isOpen = ref(false);
const dropdownRef = ref<HTMLButtonElement | null>(null);
const dropdownStyle = ref({});

function selectProdi(selected: string) {
    prodi.value = selected;
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

const handleClickOutside = (event: MouseEvent) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target as Node)) {
        const dropdownMenu = document.getElementById('teleported-dropdown');
        if (dropdownMenu && !dropdownMenu.contains(event.target as Node)) {
            isOpen.value = false;
        }
    }
};

onMounted(() => { 
    AOS.init({ duration: 800, once: true }); 
    document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside);
});

watch([search, prodi], debounce(() => {
    router.get(route('profil.dosen'), { search: search.value, prodi: prodi.value }, {
        preserveState: true, replace: true, onFinish: () => AOS.refresh()
    });
}, 400));

// --- LOGIKA MODAL ---
const isModalOpen = ref(false);
const selectedPerson = ref<any>(null);

const openModal = (person: any) => {
    selectedPerson.value = person;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => { selectedPerson.value = null; }, 300);
    document.body.style.overflow = 'auto';
};

const hasDetailedInfo = computed(() => {
    if (!selectedPerson.value) return false;
    const p = selectedPerson.value;
    return (p.expertise?.length > 0) || (p.education_history?.length > 0) || (p.work_experience?.length > 0) || (p.research_history?.length > 0) || (p.awards?.length > 0);
});
</script>

<template>
    <PublicLayout>
        <Head title="Daftar Dosen" />
        <Banner title="DOSEN" subtitle="Fakultas Sains dan Teknologi Informasi" background-image="/images/background-banner.png" />

        <div class="relative bg-slate-50 py-16 md:py-24 font-public-sans min-h-screen overflow-hidden">
            
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

                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4 leading-tight">
                            Profil <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600">Dosen</span>
                        </h2>
                        <p class="text-gray-600 font-medium text-[15px] md:text-[16px] max-w-xl mx-auto leading-relaxed">
                            Kenali lebih dekat daftar dosen Fakultas Sains dan Teknologi Informasi ITK beserta latar belakang pendidikan dan bidang keahliannya.
                        </p>
                    </div>
                </div>

                <div class="mb-12 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
                    <div class="relative flex-grow">
                        <input type="text" placeholder="Cari nama dosen, NIP..." v-model="search"
                            class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium transition-all" />
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="relative md:w-80">
                        <button ref="dropdownRef" @click="toggleDropdown"
                            class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all">
                            <span class="truncate">{{ prodi || 'Semua Program Studi' }}</span>
                            <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isOpen}" />
                        </button>
                        <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
                    </div>
                </div>

                <Teleport to="body">
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <div v-if="isOpen" id="teleported-dropdown" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-gray-100 py-2 font-public-sans">
                            <a @click="selectProdi('')" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': prodi === ''}">Semua Program Studi</a>
                            <a v-for="p in prodiList" :key="p" @click="selectProdi(p)" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': prodi === p}">
                                {{ p }}
                            </a>
                        </div>
                    </transition>
                </Teleport>

                <div v-if="isFiltering" class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                        <span v-if="search && prodi">Pencarian <span class="text-primary">"{{ search }}"</span> di Program Studi <span class="text-primary">"{{ prodi }}"</span></span>
                        <span v-else-if="search">Hasil pencarian untuk <span class="text-primary">"{{ search }}"</span></span>
                        <span v-else-if="prodi">Semua dosen Program Studi <span class="text-primary">{{ prodi }}</span></span>
                    </h3>
                    
                    <button @click="search = ''; selectProdi('')" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto">
                        Reset Filter
                    </button>
                </div>

                <div v-if="dosen.data.length > 0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 xl:gap-8">
                        <div v-for="(person, index) in dosen.data" :key="person.id" 
                             class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-1.5 transition-all duration-500 flex flex-col group relative"
                             data-aos="fade-up" :data-aos-delay="(index % 4) * 50">
                            
                            <div class="h-64 w-full bg-gray-100 relative overflow-hidden">
                                <img :src="person.display_image" :alt="person.name" 
                                     class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 mix-blend-multiply">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                                
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-[2px]">
                                    <button @click="openModal(person)" class="bg-white/95 text-primary text-sm font-bold px-6 py-2.5 rounded-xl shadow-lg hover:bg-primary hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 flex items-center gap-2">
                                        <UserCircle class="w-4 h-4" /> Lihat Profil
                                    </button>
                                </div>
                            </div>

                            <div class="p-6 flex flex-col flex-grow text-center relative bg-white z-10 border-t border-gray-100">
                                <h3 class="font-bold text-[17px] text-gray-900 mb-1.5 leading-snug line-clamp-2 group-hover:text-primary transition-colors">{{ person.name }}</h3>
                                <p class="text-sm font-semibold text-primary/80 mb-4 line-clamp-1">{{ person.functional_position || 'Dosen ITK' }}</p>
                                <p class="text-xs text-gray-400 font-medium mt-auto">{{ person.nip ? 'NIP. ' + person.nip : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="dosen.links && dosen.links.length > 3" class="mt-16 flex justify-center items-center flex-wrap gap-2 pb-8" data-aos="fade-up">
                        <template v-for="(link, index) in dosen.links" :key="index">
                            <Link v-if="link.url" :href="link.url" v-html="link.label" 
                                class="px-4 py-2 text-sm font-bold rounded-lg border transition-colors" 
                                :class="{'bg-primary text-white border-primary shadow-sm': link.active, 'text-gray-600 border-gray-200 bg-white hover:bg-gray-50 hover:text-primary': !link.active}" />
                            <span v-else v-html="link.label" class="px-4 py-2 text-sm font-bold rounded-lg text-gray-400 border border-gray-100 bg-gray-50" />
                        </template>
                    </div>
                </div>

                <div v-else class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4">
                        <FileX2 class="h-10 w-10 text-primary" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">
                        Dosen dengan kriteria pencarian atau program studi tersebut tidak tersedia. Silakan coba kata kunci lain.
                    </p>
                </div>

            </div>
        </div>

        <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 sm:p-6 font-public-sans" @click.self="closeModal">
                
                <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-h-[90vh] overflow-hidden flex flex-col transform transition-all border border-white/20" 
                     :class="hasDetailedInfo ? 'max-w-5xl' : 'max-w-[450px]'" v-if="selectedPerson">
                    
                    <div class="bg-gradient-to-r from-primary to-blue-600 p-6 flex items-center justify-between text-white flex-shrink-0 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/10 rounded-full blur-xl translate-y-1/2 -translate-x-1/2"></div>
                        <h3 class="text-xl font-bold tracking-wide relative z-10 flex items-center gap-2">
                            <Users class="w-5 h-5" /> Profil {{ hasDetailedInfo ? 'Lengkap' : 'Singkat' }}
                        </h3>
                        <button @click="closeModal" class="p-2.5 bg-white/10 hover:bg-white/25 rounded-full transition-colors relative z-10 backdrop-blur-md"><X class="w-5 h-5" /></button>
                    </div>

                    <div class="p-8 md:p-10 overflow-y-auto custom-scrollbar bg-slate-50/30">
                        <div class="flex flex-col gap-10" :class="hasDetailedInfo ? 'lg:flex-row' : 'items-center text-center'">
                            
                            <div class="flex-shrink-0" :class="hasDetailedInfo ? 'lg:w-[32%] text-center' : 'w-full'">
                                <div class="w-48 h-48 mx-auto rounded-full border-[8px] border-white shadow-xl p-1 mb-6 bg-gradient-to-b from-gray-100 to-gray-200 relative">
                                    <img :src="selectedPerson.display_image" :alt="selectedPerson.name" class="w-full h-full object-cover object-center rounded-full mix-blend-multiply">
                                    <div class="absolute bottom-2 right-2 bg-green-500 w-6 h-6 border-4 border-white rounded-full" title="Aktif"></div>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-snug mb-2">{{ selectedPerson.name }}</h2>
                                <p v-if="selectedPerson.nip" class="text-sm text-gray-500 font-semibold mb-6">NIP. {{ selectedPerson.nip }}</p>
                                
                                <div class="space-y-4 p-6 rounded-3xl bg-white border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]" :class="hasDetailedInfo ? 'text-left' : 'inline-block text-left w-full'">
                                    <div v-if="selectedPerson.structural_position" class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0"><Briefcase class="w-5 h-5 text-blue-600" /></div>
                                        <div>
                                            <p class="text-xs text-gray-400 font-semibold uppercase mb-0.5">Struktural</p>
                                            <span class="text-sm font-bold text-gray-800 leading-tight">{{ selectedPerson.structural_position }}</span>
                                        </div>
                                    </div>
                                    <div v-if="selectedPerson.functional_position" class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0"><UserCircle class="w-5 h-5 text-primary" /></div>
                                        <div>
                                            <p class="text-xs text-gray-400 font-semibold uppercase mb-0.5">Fungsional</p>
                                            <span class="text-sm font-bold text-gray-800 leading-tight">{{ selectedPerson.functional_position }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="selectedPerson.academic_profiles?.length > 0" class="mt-8 flex flex-wrap justify-center gap-3">
                                    <a v-for="(link, i) in selectedPerson.academic_profiles" :key="i" :href="link" target="_blank" rel="noopener noreferrer" 
                                       class="w-12 h-12 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-full hover:bg-primary hover:text-white hover:border-primary hover:shadow-lg hover:-translate-y-1 transition-all">
                                        <Linkedin v-if="link.toLowerCase().includes('linkedin.com')" class="w-5 h-5" />
                                        <GraduationCap v-else-if="link.toLowerCase().includes('scholar.google')" class="w-5 h-5" />
                                        <BookMarked v-else-if="link.toLowerCase().includes('scopus.com')" class="w-5 h-5" />
                                        <LinkIcon v-else class="w-5 h-5" />
                                    </a>
                                </div>
                            </div>

                            <div v-if="hasDetailedInfo" class="lg:w-[68%] flex flex-col gap-10 lg:pl-10">
                                
                                <div v-if="selectedPerson.expertise?.length > 0" class="bg-white p-6 md:p-8 rounded-[2rem] border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-5"><BookOpen class="w-6 h-6 text-primary" /> Bidang Keahlian</h4>
                                    <div class="flex flex-wrap gap-2.5">
                                        <span v-for="(expert, i) in selectedPerson.expertise" :key="i" class="px-5 py-2.5 bg-slate-50 text-slate-700 text-sm font-bold rounded-xl border border-slate-200 hover:border-primary hover:text-primary transition-colors cursor-default">
                                            {{ expert }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div v-if="selectedPerson.education_history?.length > 0">
                                        <h4 class="flex items-center gap-2.5 text-lg font-bold text-gray-900 mb-5"><GraduationCap class="w-5 h-5 text-primary" /> Pendidikan</h4>
                                        <ul class="space-y-4">
                                            <li v-for="(edu, i) in selectedPerson.education_history" :key="i" class="relative pl-6 before:absolute before:left-0 before:top-2 before:w-2 before:h-2 before:bg-primary before:rounded-full text-gray-700 font-medium">
                                                {{ edu }}
                                            </li>
                                        </ul>
                                    </div>

                                    <div v-if="selectedPerson.work_experience?.length > 0">
                                        <h4 class="flex items-center gap-2.5 text-lg font-bold text-gray-900 mb-5"><Briefcase class="w-5 h-5 text-primary" /> Pengalaman</h4>
                                        <ul class="space-y-4">
                                            <li v-for="(work, i) in selectedPerson.work_experience" :key="i" class="relative pl-6 before:absolute before:left-0 before:top-2 before:w-2 before:h-2 before:bg-primary before:rounded-full text-gray-700 font-medium">
                                                {{ work }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div v-if="selectedPerson.research_history?.length > 0" class="bg-white p-6 md:p-8 rounded-[2rem] border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-5"><BookOpen class="w-6 h-6 text-primary" /> Riwayat Riset</h4>
                                    <ul class="space-y-4">
                                        <li v-for="(research, i) in selectedPerson.research_history" :key="i" class="flex items-start gap-4 text-gray-700 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            <div class="mt-1 w-2.5 h-2.5 rounded-full bg-primary/50 ring-4 ring-primary/10 flex-shrink-0"></div>
                                            <span class="text-[15px] font-medium leading-relaxed">{{ research }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div v-if="selectedPerson.awards?.length > 0" class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 md:p-8 rounded-[2rem] border border-amber-100/50 shadow-sm">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-gray-900 mb-5"><Award class="w-6 h-6 text-amber-500" /> Penghargaan</h4>
                                    <ul class="space-y-4">
                                        <li v-for="(award, i) in selectedPerson.awards" :key="i" class="flex items-start gap-4 text-gray-800 bg-white/60 backdrop-blur-sm p-4 rounded-2xl border border-white">
                                            <Award class="w-5 h-5 text-amber-500 flex-shrink-0" /> 
                                            <span class="text-[15px] font-bold leading-relaxed">{{ award }}</span>
                                        </li>
                                    </ul>
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
.custom-scrollbar::-webkit-scrollbar { width: 8px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; border: 2px solid #f8fafc; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>