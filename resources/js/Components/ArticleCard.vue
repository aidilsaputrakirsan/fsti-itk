<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Calendar, Eye, ImageIcon, ArrowRight } from 'lucide-vue-next';
import type { Post } from '@/types';

defineProps<{
  post: Post;
}>();
</script>

<template>
  <div class="bg-white rounded-2xl overflow-hidden border-t-4 border-primary border-x border-b shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col group font-public-sans h-full">
    
    <div class="relative aspect-video overflow-hidden bg-gray-100">
      <Link :href="route('posts.show', post.slug)" class="block w-full h-full">
        <img 
          v-if="post.image_url" 
          class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" 
          :src="post.image_url" 
          :alt="post.title"
        >
        <div v-else class="w-full h-full flex items-center justify-center">
          <ImageIcon class="w-12 h-12 text-gray-300" />
        </div>
      </Link>

      <span v-if="post.category" class="absolute top-3 left-3 bg-primary text-white text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-wider">
        {{ post.category }}
      </span>
    </div>

    <div class="p-5 md:p-6 flex flex-col flex-grow">
      <div class="flex items-center justify-between text-xs text-gray-500 mb-3 font-semibold">
        <div class="flex items-center">
          <Calendar class="w-3.5 h-3.5 mr-1.5 text-primary" />
          <span>{{ new Date(post.published_at || post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}</span>
        </div>
        <div class="flex items-center">
          <Eye class="w-3.5 h-3.5 mr-1.5 text-primary" />
          <span>{{ post.views }}</span>
        </div>
      </div>

      <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-3 leading-snug group-hover:text-primary transition-colors line-clamp-2">
        <Link :href="route('posts.show', post.slug)">
          {{ post.title }}
        </Link>
      </h3>
      
      <p class="text-gray-600 text-sm leading-relaxed mb-6 line-clamp-3 flex-grow">
        {{ post.excerpt }}
      </p>

      <div class="mt-auto border-t border-gray-100 pt-4">
        <Link 
            :href="route('posts.show', post.slug)" 
            class="inline-flex items-center text-sm font-bold text-primary hover:text-primary-hover transition-colors"
        >
          Baca Selengkapnya
          <ArrowRight class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" />
        </Link>
      </div>
    </div>
  </div>
</template>