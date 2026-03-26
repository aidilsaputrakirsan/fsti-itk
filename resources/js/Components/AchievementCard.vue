<script setup lang="ts">
import { GraduationCap, Award, Calendar, Trophy, Medal } from 'lucide-vue-next';
import type { Achievement } from '@/types'; // Import dari tipe global agar sinkron!

const props = defineProps<{
  achievement: Achievement;
}>();
</script>

<template>
  <div 
    class="bg-gradient-to-br from-[#4361EE] via-[#2F4DD3] to-[#1E338A] rounded-lg overflow-hidden transition-all duration-300 ease-in-out 
           hover:scale-105 hover:shadow-xl hover:shadow-blue-900/20 border border-blue-600/30 flex flex-col h-full"
  >
    <div class="aspect-[3/2] relative shrink-0 overflow-hidden border-b border-blue-400/30">
      <img 
        :src="achievement.image_url || 'https://placehold.co/600x400/cccccc/FFFFFF?text=Image+Not+Found'" 
        :alt="'Foto ' + achievement.student_name" 
        class="w-full h-full object-cover"
        loading="lazy"
        onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/FFFFFF?text=Image+Not+Found';"
      >
      <div class="absolute inset-x-0 bottom-0 h-4 bg-gradient-to-t from-[#2F4DD3]/50 to-transparent"></div>
    </div>

    <div class="p-5 flex flex-col flex-grow">
      <div>
        <div class="flex items-center flex-wrap gap-2 mb-3">
          <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2F4DD3] bg-white px-2.5 py-1 rounded-full shadow-sm">
            <Trophy class="h-3.5 w-3.5 text-amber-500" /> {{ achievement.category }}
          </span>
          <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2F4DD3] bg-white px-2.5 py-1 rounded-full shadow-sm">
            <Medal class="h-3.5 w-3.5 text-amber-500" /> {{ achievement.level }}
          </span>
          <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2F4DD3] bg-white px-2.5 py-1 rounded-full shadow-sm">
            <Calendar class="h-3.5 w-3.5 text-blue-500" />
            {{ achievement.year }}
          </span>
        </div>

        <h3 class="text-xl font-bold text-white leading-snug whitespace-pre-line drop-shadow-sm">{{ achievement.student_name }}</h3>
        
        <p v-if="achievement.study_program" class="flex items-center gap-2 text-sm text-blue-100 mt-1.5">
          <GraduationCap class="h-4 w-4 text-blue-300" />
          {{ achievement.study_program }}
        </p>
      </div>

      <div class="mt-auto pt-4 border-t border-blue-400/30 flex flex-col">
        <p class="flex items-start gap-2 text-base font-bold text-white min-h-[3rem]">
          <Award class="h-5 w-5 flex-shrink-0 mt-0.5 text-yellow-400 drop-shadow-md" />
          <span class="flex-1 drop-shadow-sm">{{ achievement.title }}</span>
        </p>
        <p class="text-sm text-blue-100 mt-2">
          <span class="text-blue-300 font-medium">Oleh:</span> {{ achievement.organizer }}
        </p>
      </div>
    </div>
  </div>
</template>