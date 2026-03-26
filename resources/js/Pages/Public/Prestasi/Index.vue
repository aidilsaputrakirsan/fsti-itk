<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { router, Link, Head } from '@inertiajs/vue3';

// Layouts & Components
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import AchievementCard from '@/Components/AchievementCard.vue';
// Icons
import { Trophy, Award, Search, FileWarning, Medal, Star, Send, ChevronDown } from 'lucide-vue-next';
import { RefreshCw } from 'lucide-vue-next'; 

// Import AOS untuk animasi
import AOS from 'aos';
import 'aos/dist/aos.css';

// Types
import type { PaginatedAchievements, Filters } from '@/types';

const props = defineProps<{
  achievements: PaginatedAchievements;
  stats: {
    total_all_time: number;
    international: number;
    national: number;
    academic: number;
    non_academic: number;
  };
  filters: Filters;
  years: string[];
  levels: string[];
  categories: string[];
}>();

const bannerImage = '/images/background-banner.png';
const googleFormUrl = 'https://docs.google.com/forms/d/e/1FAIpQLSfaToVEnR6vnZSTggEbH_IfAVbOpuPf1aCirsNTRb3m8aFL-Q/viewform?pli=1';

const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year || '');
const selectedLevel = ref(props.filters.level || '');
const selectedCategory = ref(props.filters.category || '');

// --- LOGIKA BARU UNTUK 3 CUSTOM DROPDOWN ---
const isCategoryOpen = ref(false);
const isLevelOpen = ref(false);
const isYearOpen = ref(false);

const categoryBtnRef = ref<HTMLButtonElement | null>(null);
const levelBtnRef = ref<HTMLButtonElement | null>(null);
const yearBtnRef = ref<HTMLButtonElement | null>(null);

const categoryDropdownStyle = ref({});
const levelDropdownStyle = ref({});
const yearDropdownStyle = ref({});

const toggleDropdown = (type: 'category' | 'level' | 'year') => {
    const refs = { category: categoryBtnRef, level: levelBtnRef, year: yearBtnRef };
    const isOpenRefs = { category: isCategoryOpen, level: isLevelOpen, year: isYearOpen };
    const styleRefs = { category: categoryDropdownStyle, level: levelDropdownStyle, year: yearDropdownStyle };

    Object.keys(isOpenRefs).forEach(key => {
        if (key !== type) isOpenRefs[key as keyof typeof isOpenRefs].value = false;
    });

    const isOpen = isOpenRefs[type];
    if (isOpen.value) {
        isOpen.value = false;
    } else {
        const button = refs[type].value;
        if (button) {
            const rect = button.getBoundingClientRect();
            styleRefs[type].value = {
                position: 'absolute',
                top: `${rect.bottom + window.scrollY + 8}px`,
                left: `${rect.left}px`,
                width: `${rect.width}px`,
            };
        }
        isOpen.value = true;
    }
};

function selectOption(type: 'category' | 'level' | 'year', value: string) {
    if (type === 'category') {
        selectedCategory.value = value;
        isCategoryOpen.value = false;
    } else if (type === 'level') {
        selectedLevel.value = value;
        isLevelOpen.value = false;
    } else if (type === 'year') {
        selectedYear.value = value;
        isYearOpen.value = false;
    }
}

const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as Node;
    const check = (btnRef: typeof categoryBtnRef, menuId: string, isOpenRef: typeof isCategoryOpen) => {
        const menu = document.getElementById(menuId);
        if (btnRef.value && !btnRef.value.contains(target) && menu && !menu.contains(target)) {
            isOpenRef.value = false;
        }
    };
    check(categoryBtnRef, 'category-dropdown-menu', isCategoryOpen);
    check(levelBtnRef, 'level-dropdown-menu', isLevelOpen);
    check(yearBtnRef, 'year-dropdown-menu', isYearOpen);
};

onMounted(() => {
  AOS.init({ duration: 800, once: true });
  document.addEventListener('mousedown', handleClickOutside);
});
onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
});

const applyFilters = () => {
    router.get(route('prestasi.index'), {
        search: search.value,
        year: selectedYear.value,
        level: selectedLevel.value,
        category: selectedCategory.value,
    }, {
        preserveState: true,
        replace: true,
        onFinish: () => { AOS.refresh(); } 
    });
    };

    const resetFilters = () => {
    search.value = '';
    selectedYear.value = '';
    selectedLevel.value = '';
    selectedCategory.value = '';
    applyFilters();

};
</script>

<template>
    <PublicLayout>
        <Head title="Prestasi Mahasiswa - FSTI ITK" />

        <Banner
            title="Prestasi Mahasiswa"
            subtitle="GALERI PENCAPAIAN DAN KARYA INSPIRATIF FSTI ITK"
            :background-image="bannerImage"
        />

        <div class="bg-gray-50 font-public-sans pb-24">
            
            <section class="relative z-20 -mt-10 md:-mt-16 px-4 md:px-8 max-w-[95%] xl:max-w-[85rem] mx-auto" data-aos="fade-up">
                <div class="bg-white/95 backdrop-blur-xl rounded-[2rem] shadow-xl border border-gray-100 p-6 md:p-8 flex flex-col md:flex-row justify-between items-center gap-6 md:gap-0 md:divide-x-2 divide-gray-100">
                    
                    <div class="w-full md:w-1/5 flex flex-col items-center group cursor-default">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <Trophy class="w-6 h-6 text-primary"/>
                        </div>
                        <p class="text-3xl md:text-4xl font-black text-gray-800">{{ stats.total_all_time }}</p>
                        <p class="font-bold mt-1 text-xs text-gray-500 uppercase tracking-widest">Total Prestasi</p>
                    </div>

                    <div class="w-full md:w-1/5 flex flex-col items-center group cursor-default">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <Medal class="w-6 h-6 text-primary"/>
                        </div>
                        <p class="text-3xl md:text-4xl font-black text-gray-800">{{ stats.international }}</p>
                        <p class="font-bold mt-1 text-xs text-gray-500 uppercase tracking-widest">Internasional</p>
                    </div>

                    <div class="w-full md:w-1/5 flex flex-col items-center group cursor-default">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <Award class="w-6 h-6 text-primary"/>
                        </div>
                        <p class="text-3xl md:text-4xl font-black text-gray-800">{{ stats.national }}</p>
                        <p class="font-bold mt-1 text-xs text-gray-500 uppercase tracking-widest">Nasional</p>
                    </div>

                    <div class="w-full md:w-1/5 flex flex-col items-center group cursor-default">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <Star class="w-6 h-6 text-primary"/>
                        </div>
                        <p class="text-3xl md:text-4xl font-black text-gray-800">{{ stats.academic }}</p>
                        <p class="font-bold mt-1 text-xs text-gray-500 uppercase tracking-widest">Akademik</p>
                    </div>

                    <div class="w-full md:w-1/5 flex flex-col items-center group cursor-default">
                        <div class="w-14 h-14 bg-primary/10 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <Trophy class="w-6 h-6 text-primary"/>
                        </div>
                        <p class="text-3xl md:text-4xl font-black text-gray-800">{{ stats.non_academic }}</p>
                        <p class="font-bold mt-1 text-xs text-gray-500 uppercase tracking-widest">Non-Akademik</p>
                    </div>

                </div>
            </section>

            <section class="max-w-5xl mx-auto px-4 mt-20 mb-16" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary">Jelajahi Prestasi</h2>
                    <p class="text-gray-500 mt-2 font-medium">Temukan galeri capaian mahasiswa berdasarkan kategori dan tingkat </p>
                </div>

                <form @submit.prevent="applyFilters" class="bg-white p-2 md:p-3 rounded-3xl md:rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 flex flex-col md:flex-row items-center gap-2 md:gap-4">
                    
                    <div class="relative w-full md:w-2/5 md:ml-4">
                        <Search class="absolute left-0 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <input type="text" v-model="search" placeholder="Cari nama mahasiswa atau judul..." class="w-full pl-8 pr-4 py-3 bg-transparent border-none text-sm font-medium focus:ring-0 placeholder-gray-400">
                    </div>
                    
                    <div class="hidden md:block w-px h-8 bg-gray-200"></div>
                    
                    <div class="flex flex-col sm:flex-row w-full md:w-3/5 gap-2">
                        <div class="relative w-full sm:w-1/3">
                            <button ref="categoryBtnRef" @click="toggleDropdown('category')" type="button" class="w-full py-3 px-4 bg-gray-50 md:bg-transparent rounded-xl md:rounded-full text-xs font-bold text-gray-600 flex justify-between items-center hover:bg-gray-50 transition-colors">
                                <span class="truncate">{{ selectedCategory || 'Kategori' }}</span>
                                <ChevronDown class="w-4 h-4 ml-1 text-primary flex-shrink-0" :class="{'rotate-180': isCategoryOpen}" />
                            </button>
                        </div>

                        <div class="hidden sm:block w-px h-8 bg-gray-200 mt-1"></div>

                        <div class="relative w-full sm:w-1/3">
                            <button ref="levelBtnRef" @click="toggleDropdown('level')" type="button" class="w-full py-3 px-4 bg-gray-50 md:bg-transparent rounded-xl md:rounded-full text-xs font-bold text-gray-600 flex justify-between items-center hover:bg-gray-50 transition-colors">
                                <span class="truncate">{{ selectedLevel || 'Tingkat' }}</span>
                                <ChevronDown class="w-4 h-4 ml-1 text-primary flex-shrink-0" :class="{'rotate-180': isLevelOpen}" />
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
      </div>

                        <div class="hidden sm:block w-px h-8 bg-gray-200 mt-1"></div>

                        <div class="relative w-full sm:w-1/3 pr-0 md:pr-1">
                            <button type="submit" class="w-full bg-primary text-white text-sm font-bold py-3 md:py-3.5 rounded-xl md:rounded-full hover:bg-primary-hover transition-colors shadow-md flex items-center justify-center gap-2">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </section>

            <section class="max-w-[95%] xl:max-w-[100rem] mx-auto px-4 xl:px-8 mb-24 min-h-[400px]">
                
                <div v-if="search || selectedCategory || selectedLevel || selectedYear" class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center flex-wrap gap-x-1">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block shrink-0"></div>
                        <span>Hasil filter: </span>
                        <span v-if="search" class="text-primary">"{{ search }}"</span>
                        <span v-if="selectedCategory" class="text-primary">Kategori "{{ selectedCategory }}"</span>
                        <span v-if="selectedLevel" class="text-primary">Tingkat "{{ selectedLevel }}"</span>
                        <span v-if="selectedYear" class="text-primary">Tahun "{{ selectedYear }}"</span>
                    </h3>
                    
                    <button @click="resetFilters" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto shrink-0">
                        Reset Filter
                    </button>
                </div>
                <div v-if="achievements.data.length > 0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6 md:gap-8 lg:gap-10">
                        <div
                            v-for="(achievement, index) in achievements.data"
                            :key="achievement.id"
                            data-aos="fade-up"
                            :data-aos-delay="index * 50"
                            class="group flex h-full"
                        >
                            <AchievementCard :achievement="achievement" class="w-full h-full flex-grow hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-500" />
                        </div>
                    </div>

                    <div class="mt-16 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-gray-100" data-aos="fade-in">
                        <p class="text-sm font-medium text-gray-500 text-center md:text-left">
                            Menampilkan <span class="text-primary font-bold">{{ achievements.from }}</span> - <span class="text-primary font-bold">{{ achievements.to }}</span> dari <span class="text-primary font-bold">{{ achievements.total }}</span> Prestasi
                        </p>
                        
                        <div v-if="achievements.links.length > 3" class="flex flex-wrap justify-center items-center gap-2">
                            <template v-for="(link, index) in achievements.links" :key="index">
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    v-html="link.label"
                                    class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300"
                                    :class="{'bg-primary text-white shadow-md': link.active, 'text-gray-600 hover:bg-gray-100 hover:text-primary': !link.active}"
                                />
                                <span 
                                    v-else 
                                    v-html="link.label" 
                                    class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full text-gray-300 bg-gray-50/50 cursor-not-allowed"
                                />
                            </template>
                        </div>
                    </div>

                </div>

                <div v-else class="text-center py-24 bg-white border border-gray-100 rounded-[3rem] shadow-sm max-w-4xl mx-auto" data-aos="zoom-in">
                    <div class="bg-gray-50 w-24 h-24 flex items-center justify-center rounded-full mx-auto mb-6">
                        <FileWarning class="w-12 h-12 text-gray-300" />
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-800 font-optimus mb-3">Belum Ada Prestasi</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Silakan ubah filter pencarian Anda, atau tunggu admin memperbarui galeri capaian mahasiswa.</p>
                </div>
            </section>
            
            <section class="max-w-6xl mx-auto px-4 pb-12" data-aos="fade-up">
                <div class="bg-primary rounded-[3rem] p-10 md:p-16 flex flex-col md:flex-row items-center justify-between gap-12 relative overflow-hidden shadow-2xl">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 md:w-2/3 text-center md:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-white text-xs font-bold mb-4 uppercase tracking-widest border border-white/20">
                            Ikut Berkontribusi
                        </div>
                        <h2 class="text-3xl md:text-5xl font-bold font-optimus text-white mb-4 leading-tight">Jangan Biarkan Prestasimu Terlewat!</h2>
                        <p class="text-white/80 text-lg leading-relaxed">
                            Apakah kamu atau timmu baru saja menjuarai sebuah kompetisi? Laporkan pencapaianmu agar dapat dipublikasikan dan menginspirasi mahasiswa FSTI lainnya.
                        </p>
                    </div>
                    
                    <div class="relative z-10 md:w-1/3 flex justify-center md:justify-end">
                        <a :href="googleFormUrl" target="_blank" class="flex flex-col items-center justify-center w-48 h-48 bg-white text-primary rounded-full font-bold hover:scale-105 transition-transform duration-300 shadow-[0_0_40px_rgba(255,255,255,0.2)] group">
                            <Send class="w-8 h-8 mb-2 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform" />
                            <span class="text-center px-4 leading-tight uppercase tracking-wider">Laporkan<br>Sekarang</span>
                        </a>
                    </div>
                </div>
            </section>

        </div>

    </PublicLayout>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isCategoryOpen" id="category-dropdown-menu" :style="categoryDropdownStyle" class="z-[9999] bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-gray-100 py-2 overflow-hidden">
                <a @click="selectOption('category', '')" class="block px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary font-bold cursor-pointer transition-colors">Semua Kategori</a>
                <a v-for="c in categories" :key="c" @click="selectOption('category', c)" class="block px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary font-bold cursor-pointer transition-colors">{{ c }}</a>
            </div>
        </transition>
    </Teleport>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isLevelOpen" id="level-dropdown-menu" :style="levelDropdownStyle" class="z-[9999] bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-gray-100 py-2 overflow-hidden">
                <a @click="selectOption('level', '')" class="block px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary font-bold cursor-pointer transition-colors">Semua Tingkat</a>
                <a v-for="l in levels" :key="l" @click="selectOption('level', l)" class="block px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary font-bold cursor-pointer transition-colors">{{ l }}</a>
            </div>
        </transition>
    </Teleport>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isYearOpen" id="year-dropdown-menu" :style="yearDropdownStyle" class="z-[9999] bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-gray-100 py-2 overflow-hidden">
                <a @click="selectOption('year', '')" class="block px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary font-bold cursor-pointer transition-colors">Semua Tahun</a>
                <a v-for="y in years" :key="y" @click="selectOption('year', y)" class="block px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary font-bold cursor-pointer transition-colors">{{ y }}</a>
            </div>
        </transition>
    </Teleport>
</template>