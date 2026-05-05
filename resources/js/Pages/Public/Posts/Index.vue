<script setup lang="ts">
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import SidebarLatest from '@/Components/SidebarLatest.vue';
import { Link, Head } from '@inertiajs/vue3';
import { Search, ArrowRight, FileX2, Calendar, ChevronDown, ListFilter, X, Newspaper } from 'lucide-vue-next';
import { debounce } from 'lodash';

import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps<{
  isSearching: boolean;
  headline?: any;
  latestPosts?: any[]; 
  groupedPosts?: any[];
  searchResults?: any;
  categories: string[]; 
  filters: { search?: string; category?: string };
}>();

const bannerImage = '/images/background-banner.webp';
const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');

const isOpen = ref(false);
const dropdownRef = ref<HTMLButtonElement | null>(null);
const dropdownStyle = ref({});

function selectCategory(selected: string) {
  category.value = selected;
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
  AOS.init({ duration: 800, once: true, offset: 50 });
  document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
});

watch([search, category], debounce(() => {
    router.get(route('posts.index'), { search: search.value, category: category.value }, {
        preserveState: true, replace: true, onFinish: () => AOS.refresh()
    });
}, 400));
</script>

<template>
  <PublicLayout>
        <Head>
            <title>Berita</title>
            <meta name="description" content="Daftar Berita Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan." />
        </Head>

    <Banner title="Berita" subtitle="Pusat Berita & Pengumuman FSTI ITK" :background-image="bannerImage" />

    <div class="py-16 md:py-24 bg-white font-public-sans min-h-screen">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-primary-hover rounded-[2rem] p-8 md:p-12 mb-8 overflow-hidden shadow-xl flex items-center justify-between border border-primary-hover/50">
            
            <div class="absolute -top-[20%] -right-[10%] w-[60%] h-[140%] bg-blue-300/20 rounded-[100%] blur-[100px] pointer-events-none transform -rotate-12"></div>
            <div class="absolute -bottom-[30%] -left-[10%] w-[60%] h-[120%] bg-white/10 rounded-[100%] blur-[120px] pointer-events-none transform rotate-12"></div>
            <div class="absolute top-[20%] left-[40%] w-[30%] h-[50%] bg-blue-200/15 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="relative z-10 text-white w-full max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-sm font-bold mb-6 shadow-sm uppercase tracking-wider">
                    <Newspaper class="w-4 h-4" /> Berita FSTI
                </div>
                <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm">Lihat Berita <br/> Terbaru FSTI </h2>
                <p class="text-blue-50 md:text-lg font-light leading-relaxed max-w-xl opacity-90">
                    Dapatkan kabar terbaru seputar kegiatan penting di lingkungan Fakultas Sains dan Teknologi Informasi.
                </p>
            </div>

            <div class="hidden lg:flex relative z-10 flex-shrink-0 p-8 bg-white/5 backdrop-blur-sm rounded-[2.5rem] border border-white/10 items-center justify-center transform rotate-2 hover:-rotate-2 hover:scale-105 transition-all duration-500 shadow-2xl">
                <Newspaper class="w-32 h-32 text-white/90" stroke-width="1.5" />
            </div>
        </div>

        <div class="relative z-20 -mt-16 mx-4 md:mx-8 mb-16 bg-white p-4 md:p-5 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
          
          <div class="relative flex-grow">
            <input 
              type="text" 
              placeholder="Cari judul berita atau artikel..." 
              class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-slate-50 hover:bg-white text-slate-800 font-medium transition-colors"
              v-model="search"
            >
            <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary/60" />
            <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-primary transition-colors">
              <X class="w-5 h-5" />
            </button>
          </div>

          <div class="relative md:w-80">
            <button 
              ref="dropdownRef"
              @click="toggleDropdown"
              class="w-full pl-12 pr-10 py-3.5 border border-slate-200 rounded-xl bg-slate-50 hover:bg-white text-slate-800 font-medium flex items-center justify-between text-left transition-colors focus:ring-2 focus:ring-primary focus:border-primary"
            >
              <span class="truncate">{{ category || 'Semua Kategori' }}</span>
              <ChevronDown class="w-5 h-5 text-primary/60 transition-transform duration-200" :class="{'rotate-180': isOpen}" />
            </button>
            <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
          </div>
        </div>
        
        <Teleport to="body">
            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <div v-if="isOpen" id="teleported-dropdown" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-xl border border-slate-100 py-2 font-public-sans overflow-hidden">
                    <a @click="selectCategory('')" class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': category === ''}">Semua Kategori</a>
                    <a v-for="cat in categories" :key="cat" @click="selectCategory(cat)" class="block px-5 py-3 text-slate-700 font-medium hover:bg-blue-50 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary text-white hover:bg-primary hover:text-white': category === cat}">
                        {{ cat }}
                    </a>
                </div>
            </transition>
        </Teleport>

        <div v-if="!isSearching">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16 md:mb-24" data-aos="fade-up">
                
                <div class="lg:col-span-2 flex flex-col h-full">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-12 h-1.5 bg-primary rounded-full shadow-sm"></div>
                        <h2 class="text-3xl font-optimus font-bold text-slate-800 capitalize tracking-wide">Berita Utama</h2>
                        <div class="flex-grow h-px bg-slate-200"></div>
                    </div>
                    
                    <div v-if="headline" class="bg-white rounded-[2rem] overflow-hidden shadow-[0_2px_15px_rgba(0,0,0,0.03)] hover:shadow-[0_12px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex flex-col md:flex-row group flex-grow transition-all duration-300">
                        <div class="md:w-1/2 relative overflow-hidden bg-slate-100 min-h-[250px] md:min-h-full">
<Link :href="route('posts.show', headline.slug)" :aria-label="'Baca artikel utama: ' + headline.title" class="block w-full h-full">
    <img v-if="headline.image_url" :src="headline.image_url" :alt="headline.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
</Link>
                             <span v-if="headline.category" class="absolute top-5 left-5 bg-white/90 backdrop-blur-sm text-primary text-[11px] font-bold px-4 py-2 rounded-xl shadow-md uppercase tracking-wider border border-white/50">
                                 {{ headline.category }}
                             </span>
                        </div>
                        
                        <div class="md:w-1/2 p-8 lg:p-10 flex flex-col justify-center">
                            <div class="flex items-center text-xs text-slate-500 mb-4 font-semibold tracking-wide">
                                <Calendar class="w-4 h-4 mr-2 text-primary" />
                                {{ new Date(headline.published_at || headline.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                            </div>
                            <h2 class="text-2xl lg:text-3xl font-bold text-slate-800 mb-4 group-hover:text-primary transition-colors leading-snug line-clamp-3">
                                <Link :href="route('posts.show', headline.slug)">{{ headline.title }}</Link>
                            </h2>
                            <p class="text-slate-600 text-sm lg:text-base mb-8 line-clamp-3 leading-relaxed flex-grow">
                                {{ headline.excerpt }}
                            </p>
                            <Link :href="route('posts.show', headline.slug)" class="inline-flex items-center justify-center bg-primary text-white font-bold px-7 py-3.5 rounded-xl hover:bg-primary-hover transition-colors self-start shadow-md hover:shadow-lg hover:-translate-y-0.5 text-sm">
                                Baca Selengkapnya <ArrowRight class="w-4 h-4 ml-2" />
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 flex flex-col h-full mt-2 lg:mt-0">
                    <SidebarLatest :recent-posts="latestPosts || []" class="h-full flex-grow" />
                </div>
            </div>

            <div v-if="groupedPosts && groupedPosts.length > 0" class="space-y-16">
                <section 
                    v-for="group in groupedPosts" 
                    :key="group.category_name" 
                    class="bg-white p-6 md:p-10 rounded-[2rem] shadow-[0_2px_15px_rgba(0,0,0,0.02)] border border-slate-100 relative overflow-hidden" 
                    data-aos="fade-up"
                >
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full filter blur-3xl translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>

                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 pb-5 border-b border-slate-100 relative z-10">
                        <div>
                            <span class="text-sm font-bold tracking-widest text-slate-400 uppercase mb-1 block">Kategori</span>
                            <h3 class="text-3xl md:text-4xl font-optimus font-bold text-primary">
                                {{ group.category_name }}
                            </h3>
                        </div>
                        <button @click="selectCategory(group.category_name)" class="mt-4 sm:mt-0 text-sm font-bold text-primary hover:text-primary-hover hover:bg-blue-50 transition-colors flex items-center group/link bg-slate-50 border border-slate-100 px-5 py-2.5 rounded-xl">
                            Lihat Semua <ArrowRight class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" />
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                        <ArticleCard v-for="post in group.posts" :key="post.id" :post="post" />
                    </div>
                </section>
            </div>
        </div>

        <div v-else>
            
            <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                <h3 class="text-lg md:text-xl font-bold text-slate-800 flex items-center flex-wrap gap-x-1">
                    <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block shrink-0"></div>
                    <span v-if="search && category">Pencarian <span class="text-primary">"{{ search }}"</span> di <span class="text-primary">{{ category }}</span></span>
                    <span v-else-if="search">Hasil pencarian untuk <span class="text-primary">"{{ search }}"</span></span>
                    <span v-else-if="category">Menampilkan Kategori <span class="text-primary">"{{ category }}"</span></span>
                </h3>
                
                <button @click="search = ''; selectCategory('')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto shrink-0">
                    Reset Filter
                </button>
            </div>

            <div v-if="searchResults && searchResults.data.length > 0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <ArticleCard v-for="post in searchResults.data" :key="post.id" :post="post" />
                </div>

                <div v-if="searchResults.links.length > 3" class="mt-16 flex flex-col md:flex-row items-center justify-between gap-6 bg-white py-4 px-6 md:px-10 rounded-full shadow-sm border border-slate-100" data-aos="fade-in">
                    <p class="text-sm font-medium text-slate-500 text-center md:text-left">
                        Menampilkan <span class="text-primary font-bold">{{ searchResults.from }}</span> - <span class="text-primary font-bold">{{ searchResults.to }}</span> dari <span class="text-primary font-bold">{{ searchResults.total }}</span> Berita
                    </p>
                    
                    <div class="flex flex-wrap justify-center items-center gap-2">
                        <template v-for="(link, index) in searchResults.links" :key="index">
                            <Link 
                                v-if="link.url" 
                                :href="link.url" 
                                v-html="link.label" 
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full transition-all duration-300" 
                                :class="{'bg-primary text-white shadow-md': link.active, 'text-slate-600 bg-white hover:bg-slate-100 hover:text-primary': !link.active}" 
                            />
                            <span 
                                v-else 
                                v-html="link.label" 
                                class="min-w-[2.5rem] h-10 px-4 flex items-center justify-center text-sm font-bold rounded-full text-slate-400 bg-slate-50/50 cursor-not-allowed" 
                            />
                        </template>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm mt-8" data-aos="zoom-in">
                <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4">
                    <FileX2 class="h-10 w-10 text-primary" />
                </div>
                <h3 class="text-xl font-bold text-gray-900">Tidak Ditemukan</h3>
                <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">
                    Berita dengan kriteria pencarian atau kategori tersebut tidak tersedia.
                </p>
            </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>