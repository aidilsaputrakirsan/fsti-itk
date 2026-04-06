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
    <footer class="bg-gray-900 border-t border-gray-800 text-gray-300 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-6">
                
                <div class="text-sm text-gray-500">
                    &copy; {{ new Date().getFullYear() }} Fakultas Sains dan Teknologi Informasi ITK.
                </div>

                <div class="flex items-center gap-6 bg-gray-800/50 px-6 py-3 rounded-xl border border-gray-700">
                    <div class="flex items-center gap-2">
                        <Users class="w-4 h-4 text-blue-400" />
                        <div class="text-xs">
                            <p class="text-gray-400">Hari Ini</p>
                            <p class="font-bold text-gray-200">{{ visitors.today.toLocaleString() }}</p>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-gray-700"></div>
                    <div class="flex items-center gap-2">
                        <Calendar class="w-4 h-4 text-emerald-400" />
                        <div class="text-xs">
                            <p class="text-gray-400">Bulan Ini</p>
                            <p class="font-bold text-gray-200">{{ visitors.month.toLocaleString() }}</p>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-gray-700"></div>
                    <div class="flex items-center gap-2">
                        <Activity class="w-4 h-4 text-purple-400" />
                        <div class="text-xs">
                            <p class="text-gray-400">Total</p>
                            <p class="font-bold text-gray-200">{{ visitors.total.toLocaleString() }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </footer>
</template>