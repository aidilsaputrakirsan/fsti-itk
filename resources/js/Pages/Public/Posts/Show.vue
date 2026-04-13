<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import SidebarLatest from '@/Components/SidebarLatest.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Calendar, Eye, Copy, Share2, ChevronRight, Home } from 'lucide-vue-next';
import type { Post } from '@/types';
import { ref, onMounted } from 'vue';

import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps<{
  post: Post;
  recentPosts: Post[];
}>();

const bannerImage = '/images/background-banner.png';
const notificationText = ref('');
const showNotification = ref(false);

const whatsAppUrl = ref('#');

onMounted(() => {
  AOS.init({ duration: 800, once: true });
  const currentUrl = window.location.href;
  whatsAppUrl.value = `https://wa.me/?text=${encodeURIComponent(props.post.title + ' - ' + currentUrl)}`;
});

const triggerNotification = (message: string) => {
    notificationText.value = message;
    showNotification.value = true;
    setTimeout(() => showNotification.value = false, 2500);
};

const copyToClipboard = () => {
    const textArea = document.createElement("textarea");
    textArea.value = window.location.href;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        triggerNotification('Tautan berhasil disalin!');
    } catch (err) {
        triggerNotification('Gagal menyalin tautan.');
    }
    document.body.removeChild(textArea);
};

const shareToInstagram = () => {
    copyToClipboard();
    setTimeout(() => { triggerNotification('Tautan disalin, tempel di Instagram!'); }, 100); 
};

const formatDate = (dateString: string | null) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
};
</script>

<template>
    <PublicLayout :title="post.title">
        <Head>
            <title>{{ post.title }}</title>
            <meta name="description" :content="post.excerpt">
        </Head>

        <Banner title="Berita" :background-image="bannerImage" />

        <div class="bg-white py-12 md:py-20 font-public-sans min-h-screen">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                    
                    <div class="lg:col-span-2">
                        
                        <article class="bg-white p-6 md:p-12 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100" data-aos="fade-up">
                            
                            <nav class="flex items-center text-sm text-gray-500 font-medium mb-8 whitespace-nowrap overflow-x-auto pb-2 border-b border-gray-50">
                                <Link :href="route('home')" class="hover:text-primary transition-colors flex items-center">
                                    <Home class="w-4 h-4 mr-1.5" /> Beranda
                                </Link>
                                <ChevronRight class="w-4 h-4 mx-2 flex-shrink-0 text-gray-300" />
                                <Link :href="route('posts.index')" class="hover:text-primary transition-colors">
                                    Berita
                                </Link>
                                <ChevronRight class="w-4 h-4 mx-2 flex-shrink-0 text-gray-300" />
                                <span class="text-primary truncate max-w-[150px] sm:max-w-[250px]">{{ post.category || 'Umum' }}</span>
                            </nav>

                            <header class="mb-10">
                                <span v-if="post.category" class="inline-block bg-primary/10 text-primary text-xs font-bold px-3 py-1.5 rounded-lg mb-5 uppercase tracking-wider">
                                    {{ post.category }}
                                </span>
                                
                                <h1 class="text-3xl md:text-4xl lg:text-[42px] font-public-sans font-extrabold text-gray-900 leading-[1.3] mb-8">
                                    {{ post.title }}
                                </h1>
                                
                                <div class="flex flex-wrap items-center text-[13px] md:text-sm text-gray-500 font-semibold gap-4 md:gap-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                                    <div class="flex items-center">
                                        <Calendar class="w-4 h-4 mr-2 text-primary" />
                                        <span>{{ formatDate(post.published_at) }}</span>
                                    </div>
                                    <div class="hidden sm:block w-1.5 h-1.5 rounded-full bg-gray-300"></div>
                                    <div class="flex items-center">
                                        <Eye class="w-4 h-4 mr-2 text-primary" />
                                        <span>{{ post.views }} tayangan</span>
                                    </div>
                                </div>
                            </header>

                           <figure v-if="post.image_url" class="mb-12 text-center" data-aos="zoom-in">
    <img :src="post.image_url" :alt="post.title" class="max-w-full h-auto max-h-[700px] mx-auto rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
</figure>

                            <div 
                                class="prose prose-lg md:prose-xl max-w-none 
                                       prose-headings:font-public-sans prose-headings:font-bold prose-headings:text-gray-900 
                                       prose-p:text-gray-700 prose-p:leading-relaxed 
                                       prose-a:text-primary hover:prose-a:text-primary-hover prose-a:font-semibold prose-a:no-underline hover:prose-a:underline
                                       prose-blockquote:border-l-4 prose-blockquote:border-primary prose-blockquote:bg-primary/5 prose-blockquote:py-2 prose-blockquote:px-5 prose-blockquote:rounded-r-xl prose-blockquote:font-medium prose-blockquote:italic prose-blockquote:text-gray-800
                                       prose-img:rounded-2xl prose-img:shadow-sm" 
                                v-html="post.content" 
                                data-aos="fade-up"
                            ></div>

                            <footer class="mt-14 pt-8 border-t border-gray-100" data-aos="fade-up">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-gray-50/80 p-5 md:p-6 rounded-2xl border border-gray-100 gap-4">
                                    
                                    <div class="flex items-center">
                                        <Share2 class="w-5 h-5 text-primary mr-3" />
                                        <span class="text-base font-bold text-gray-800">Bagikan Artikel Ini</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-3 w-full sm:w-auto relative">
                                        <button @click="copyToClipboard" class="flex-1 sm:flex-none flex items-center justify-center px-4 py-2.5 rounded-xl bg-white text-gray-700 hover:text-primary shadow-sm hover:shadow-md transition-all border border-gray-200" title="Salin Tautan">
                                            <Copy class="w-4 h-4 mr-2" /> <span class="text-sm font-semibold">Salin Link</span>
                                        </button>
                                        
                                        <a :href="whatsAppUrl" target="_blank" class="p-2.5 rounded-xl bg-[#25D366] text-white hover:scale-105 shadow-sm transition-all" title="Bagikan ke WhatsApp">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                        </a>
                                        
                                        <button @click="shareToInstagram" class="p-2.5 rounded-xl bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white hover:scale-105 shadow-sm transition-all" title="Salin Tautan untuk Instagram">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9 26.3 26.2 58 34.4 93.9 36.2 37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                        </button>
                                        
                                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-2">
                                            <div v-if="showNotification" class="absolute bottom-full mb-4 right-0 bg-gray-900 text-white text-xs font-bold rounded-lg px-4 py-2.5 shadow-xl whitespace-nowrap">
                                                {{ notificationText }}
                                                <div class="absolute -bottom-1 right-6 w-2 h-2 bg-gray-900 transform rotate-45"></div>
                                            </div>
                                        </transition>
                                    </div>
                                </div>
                            </footer>
                        </article>
                    </div>

                    <div class="lg:col-span-1">
                        <aside class="sticky top-28" data-aos="fade-left" data-aos-delay="100">
                            <SidebarLatest :recent-posts="recentPosts" />
                        </aside>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>