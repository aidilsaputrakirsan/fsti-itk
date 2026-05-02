<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Users, Calendar, Activity } from 'lucide-vue-next';

interface VisitorStats {
    today: number;
    month: number;
    total: number;
}

const page = usePage();

const visitors = computed<VisitorStats>(() => {
    return (page.props.visitorStats as VisitorStats) || { today: 0, month: 0, total: 0 };
});
</script>

<template>
    <footer class="bg-gray-900 border-t border-gray-800 text-gray-300 py-4 md:py-10 font-public-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col-reverse lg:flex-row justify-between items-center gap-4 lg:gap-0 text-center lg:text-left">
                
                <div class="text-[9px] sm:text-sm text-gray-300 w-full lg:w-auto mt-2 lg:mt-0">
                    &copy; {{ new Date().getFullYear() }} Fakultas Sains dan Teknologi Informasi ITK.
                </div>

                <div class="flex flex-row items-center justify-center bg-gray-800/50 px-2.5 sm:px-6 py-1.5 sm:py-3.5 rounded-md sm:rounded-xl border border-gray-700 w-max shadow-sm mx-auto lg:mx-0">
                    
                    <div class="flex flex-row items-center gap-1 sm:gap-3">
                        <Users class="w-2.5 h-2.5 sm:w-5 sm:h-5 text-blue-400 shrink-0" />
                        <div class="text-left">
                            <p class="text-[10px] sm:text-xs text-gray-300 uppercase tracking-wider mb-0.5 leading-none">Hari Ini</p>
                            <p class="text-xs sm:text-base font-bold text-gray-200 leading-none whitespace-nowrap">{{ visitors.today.toLocaleString('id-ID') }}</p>
                        </div>
                    </div>
                    
                    <div class="w-px h-4 sm:h-8 bg-gray-600 shrink-0 mx-2 sm:mx-5"></div>
                    
                    <div class="flex flex-row items-center gap-1 sm:gap-3">
                        <Calendar class="w-2.5 h-2.5 sm:w-5 sm:h-5 text-emerald-400 shrink-0" />
                        <div class="text-left">
                            <p class="text-[10px] sm:text-xs text-gray-300 uppercase tracking-wider mb-0.5 leading-none">Bulan Ini</p>
                            <p class="text-xs sm:text-base font-bold text-gray-200 leading-none whitespace-nowrap">{{ visitors.month.toLocaleString('id-ID') }}</p>
                        </div>
                    </div>
                    
                    <div class="w-px h-4 sm:h-8 bg-gray-600 shrink-0 mx-2 sm:mx-5"></div>
                    
                    <div class="flex flex-row items-center gap-1 sm:gap-3">
                        <Activity class="w-2.5 h-2.5 sm:w-5 sm:h-5 text-purple-400 shrink-0" />
                        <div class="text-left">
                            <p class="text-[10px] sm:text-xs text-gray-300 uppercase tracking-wider mb-0.5 leading-none">Total</p>
                            <p class="text-xs sm:text-base font-bold text-gray-200 leading-none whitespace-nowrap">{{ visitors.total.toLocaleString('id-ID') }}</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </footer>
</template>