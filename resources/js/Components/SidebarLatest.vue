<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Calendar } from 'lucide-vue-next';
import type { Post } from '@/types';

defineProps<{
    recentPosts: Post[];
}>();
</script>

<template>
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] font-public-sans">
        <h3 class="text-xl font-optimus font-bold text-primary mb-6 flex items-center border-b border-gray-100 pb-4">
            <div class="w-1.5 h-6 bg-primary mr-3 rounded-full"></div>
            Berita Terbaru
        </h3>
        
        <div v-if="recentPosts.length > 0" class="space-y-5">
            <Link 
                v-for="post in recentPosts" 
                :key="post.id" 
                :href="route('posts.show', post.slug)" 
                class="group flex gap-4 items-start"
            >
                <div class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden bg-gray-50">
                    <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-2 leading-snug">
                        {{ post.title }}
                    </h4>
                    <div class="text-xs text-gray-500 mt-2 flex items-center font-medium">
                        <Calendar class="w-3.5 h-3.5 mr-1.5 text-primary" />
                        {{ new Date(post.published_at || post.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                    </div>
                </div>
            </Link>
        </div>
        <div v-else class="text-sm text-gray-500 italic">
            Belum ada berita terbaru lainnya.
        </div>
    </div>
</template>