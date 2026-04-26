<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    meta: {
        type: Object,
        required: true,
    }
});

const formatLabel = (label) => {
    if (!label) return '';
    if (label.includes('Previous')) return 'Sebelumnya';
    if (label.includes('Next')) return 'Selanjutnya';
    return label;
};
</script>

<template>
    <div v-if="meta.links && meta.links.length > 3" class="mt-12 flex flex-col items-center justify-center gap-4 w-full">
        <div class="flex flex-wrap justify-center items-center gap-2">
            <template v-for="(link, index) in meta.links" :key="index">
                <Link 
                    v-if="link.url" 
                    :href="link.url" 
                    v-html="formatLabel(link.label)" 
                    preserve-scroll
                    class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl transition-all duration-300 whitespace-nowrap border" 
                    :class="link.active 
                        ? 'bg-primary text-white border-primary shadow-md' 
                        : 'text-gray-600 bg-white hover:bg-gray-50 border-gray-200 shadow-sm'" 
                />
                <span 
                    v-else 
                    v-html="formatLabel(link.label)" 
                    class="h-10 min-w-[2.5rem] px-4 flex items-center justify-center text-sm font-bold rounded-xl text-gray-300 bg-gray-50 border border-gray-100 cursor-not-allowed whitespace-nowrap" 
                />
            </template>
        </div>

        <p v-if="meta.total > 0" class="text-sm font-medium text-gray-400 mt-2">
            Menampilkan <span class="text-slate-700 font-bold">{{ meta.from }}</span> - <span class="text-slate-700 font-bold">{{ meta.to }}</span> dari <span class="text-slate-700 font-bold">{{ meta.total }}</span> data
        </p>
    </div>
</template>