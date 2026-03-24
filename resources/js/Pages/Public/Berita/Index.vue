<script setup lang="ts">
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import ArticleCard from '@/Components/ArticleCard.vue';
import SidebarLatest from '@/Components/SidebarLatest.vue';
import { Link } from '@inertiajs/vue3';
import { Search, ArrowRight, FileX2, Calendar, ChevronDown, ListFilter, X } from 'lucide-vue-next';
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

const bannerImage = '/images/background-banner.png';
const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');

// --- LOGIKA DROPDOWN ---
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

// Trigger pencarian & filter
watch([search, category], debounce(() => {
    router.get(route('berita.index'), { search: search.value, category: category.value }, {
        preserveState: true, replace: true, onFinish: () => AOS.refresh()
    });
}, 400));
</script>

<template>
  <PublicLayout title="Berita Utama">
    
    <Banner title="Berita" subtitle="Pusat Berita & Pengumuman FSTI ITK" :background-image="bannerImage" />

    <div class="py-12 md:py-20 bg-gray-50/50 font-public-sans min-h-screen">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <div class="mb-14 bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4" data-aos="fade-down">
          
          <div class="relative flex-grow">
            <input 
              type="text" 
              placeholder="Cari berita" 
              class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-gray-800 font-medium transition-all"
              v-model="search"
            >
            <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
            <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 transition-colors">
              <X class="w-5 h-5" />
            </button>
          </div>

          <div class="relative md:w-80">
            <button 
              ref="dropdownRef"
              @click="toggleDropdown"
              class="w-full pl-12 pr-10 py-3.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-gray-800 font-medium flex items-center justify-between text-left transition-all"
            >
              <span class="truncate">{{ category || 'Semua Kategori' }}</span>
              <ChevronDown class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': isOpen}" />
            </button>
            <ListFilter class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-primary pointer-events-none" />
          </div>
        </div>
        
        <Teleport to="body">
            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <div v-if="isOpen" id="teleported-dropdown" :style="dropdownStyle" class="z-[9999] bg-white rounded-xl shadow-lg border border-gray-100 py-2 font-public-sans">
                    <a @click="selectCategory('')" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': category === ''}">Semua Kategori</a>
                    <a v-for="cat in categories" :key="cat" @click="selectCategory(cat)" class="block px-5 py-3 text-gray-700 font-medium hover:bg-primary/5 hover:text-primary cursor-pointer transition-colors" :class="{'bg-primary/5 text-primary': category === cat}">
                        {{ cat }}
                    </a>
                </div>
            </transition>
        </Teleport>

        <div v-if="!isSearching">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16 md:mb-24" data-aos="fade-up">
                
                <div class="lg:col-span-2 flex flex-col h-full">
                    <h3 class="text-xl md:text-2xl font-optimus font-bold text-primary mb-6 border-b border-gray-200 pb-3 flex items-center">
                        <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div> Berita Terpopuler
                    </h3>
                    
                    <div v-if="headline" class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col md:flex-row group flex-grow">
                        <div class="md:w-1/2 relative overflow-hidden bg-gray-100 min-h-[250px] md:min-h-full">
                             <Link :href="route('berita.show', headline.slug)" class="block w-full h-full">
                                 <img v-if="headline.image_url" :src="headline.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                             </Link>
                             <span v-if="headline.category" class="absolute top-4 left-4 bg-primary text-white text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-md uppercase tracking-wider">
                                 {{ headline.category }}
                             </span>
                        </div>
                        
                        <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-center">
                            <div class="flex items-center text-xs text-gray-500 mb-3 font-semibold">
                                <Calendar class="w-4 h-4 mr-2 text-primary" />
                                {{ new Date(headline.published_at || headline.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                            </div>
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors leading-tight line-clamp-3">
                                <Link :href="route('berita.show', headline.slug)">{{ headline.title }}</Link>
                            </h2>
                            <p class="text-gray-600 text-sm md:text-base mb-8 line-clamp-3 leading-relaxed flex-grow">
                                {{ headline.excerpt }}
                            </p>
                            <Link :href="route('berita.show', headline.slug)" class="inline-flex items-center justify-center bg-primary text-white font-bold px-6 py-3 rounded-xl hover:bg-primary-hover transition-colors self-start shadow-sm hover:shadow-md text-sm">
                                Baca Selengkapnya <ArrowRight class="w-4 h-4 ml-2" />
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 flex flex-col h-full">
                    <SidebarLatest :recent-posts="latestPosts || []" class="h-full flex-grow" />
                </div>
            </div>

            <div v-if="groupedPosts && groupedPosts.length > 0" class="space-y-12">
                <section 
                    v-for="group in groupedPosts" 
                    :key="group.category_name" 
                    class="bg-white p-6 md:p-10 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden" 
                    data-aos="fade-up"
                >
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full filter blur-3xl translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>

                    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 pb-4 border-b border-gray-100 relative z-10">
                        <h3 class="text-2xl md:text-3xl font-optimus font-bold text-gray-900 uppercase tracking-wide">
                            Kategori: <span class="text-primary">{{ group.category_name }}</span>
                        </h3>
                        <button @click="selectCategory(group.category_name)" class="mt-4 sm:mt-0 text-sm font-bold text-primary hover:text-primary-hover transition-colors flex items-center group/link bg-primary/5 px-4 py-2 rounded-lg">
                            Lihat Semua <ArrowRight class="w-4 h-4 ml-1.5 transform group-hover/link:translate-x-1 transition-transform" />
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
                        <ArticleCard v-for="post in group.posts" :key="post.id" :post="post" />
                    </div>
                </section>
            </div>
        </div>

        <div v-else>
            
            <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
                <h3 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                    <div class="w-1.5 h-6 bg-primary mr-3 rounded-full hidden sm:block"></div>
                    <span v-if="search && category">Pencarian <span class="text-primary">"{{ search }}"</span> di Kategori <span class="text-primary">"{{ category }}"</span></span>
                    <span v-else-if="search">Hasil pencarian untuk <span class="text-primary">"{{ search }}"</span></span>
                    <span v-else-if="category">Semua berita Kategori <span class="text-primary">"{{ category }}"</span></span>
                </h3>
                
                <button @click="search = ''; selectCategory('')" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors self-start sm:self-auto">
                    Reset Filter
                </button>
            </div>

            <div v-if="searchResults && searchResults.data.length > 0">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <ArticleCard v-for="post in searchResults.data" :key="post.id" :post="post" />
                </div>

                <div v-if="searchResults.links.length > 3" class="mt-16 flex justify-center items-center space-x-2 pb-8">
                    <template v-for="(link, index) in searchResults.links" :key="index">
                        <Link v-if="link.url" :href="link.url" v-html="link.label" class="px-4 py-2 text-sm font-bold rounded-lg border transition-colors" :class="{'bg-primary text-white border-primary shadow-sm': link.active, 'text-gray-600 border-gray-200 bg-white hover:bg-gray-50 hover:text-primary': !link.active}" />
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
                    Berita atau pengumuman yang Anda cari tidak tersedia. Silakan coba kata kunci lain atau reset filter.
                </p>
            </div>
        </div>

      </div>
    </div>
  </PublicLayout>
</template>