<script setup lang="ts">
import { computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import VueApexCharts from 'vue3-apexcharts';
import type { ApexOptions } from 'apexcharts';
import {
    Newspaper,
    Trophy,
    Users,
    Star,
    TrendingUp,
    Eye,
    MessageSquare,
    PieChart,
    Award,
    BarChart3,
    Calendar,
    Activity
} from 'lucide-vue-next';

defineOptions({ layout: AdminLayout });

interface Props {
    stats: {
        totalPosts: number;
        publishedPosts: number;
        totalAchievements: number;
        avgRating: number;
        totalVisitors: number;
        visitorsToday: number;
        visitorsMonth: number;
    };
    charts: {
        achievementsTrend: Array<{ year: string; total: number }>;
        postsByCategory: Array<{ name: string; total: number }>;
    };
    recent: {
        topViewedPosts: Array<{
            id: number;
            title: string;
            slug: string;
            views: number;
            category: string;
        }>;
        surveys: Array<{
            id: number;
            respondent_name: string;
            rating: number;
            feedback: string;
            service_category: string;
            created_at: string;
        }>;
        achievements: Array<{
            id: number;
            student_name: string;
            title: string;
            level: string;
            year: number;
            created_at: string;
        }>;
    };
}

const props = defineProps<Props>();

const colors = {
    primary: '#3B82F6',
    success: '#10B981',
    warning: '#F59E0B',
    purple: '#8B5CF6',
    teal: '#14B8A6',
};

// Grafik Tren Prestasi
const achievementsTrendOptions = computed((): ApexOptions => ({
    chart: { type: 'area', toolbar: { show: false }, fontFamily: 'inherit' },
    stroke: { curve: 'smooth', width: 3 }, 
    markers: { size: 5, colors: ['#ffffff'], strokeColors: colors.primary, strokeWidth: 2 },
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05 } },
    colors: [colors.primary],
    xaxis: { categories: props.charts.achievementsTrend.map(i => i.year) },
    yaxis: { min: 0, tickAmount: 4 },
    dataLabels: { enabled: false },
    tooltip: { theme: 'light' },
}));

const achievementsTrendSeries = computed(() => [{
    name: 'Total Prestasi',
    data: props.charts.achievementsTrend.map(i => i.total),
}]);

// Grafik Donut Berita
const postsByCategoryOptions = computed((): ApexOptions => ({
    chart: { type: 'donut', fontFamily: 'inherit' },
    labels: props.charts.postsByCategory.map(i => i.name),
    colors: [colors.primary, colors.success, colors.warning, colors.purple, colors.teal],
    legend: { position: 'bottom', fontSize: '12px' },
    plotOptions: {
        pie: {
            donut: {
                size: '70%',
                labels: { show: true, total: { show: true, label: 'Berita', fontWeight: 600 } }
            }
        }
    },
    stroke: { width: 0 },
    dataLabels: { enabled: false },
}));

const postsByCategorySeries = computed(() => props.charts.postsByCategory.map(i => i.total));

const getTimeAgo = (dateString: string) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const diffMs = new Date().getTime() - date.getTime();
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);
    if (diffMins < 60) return `${diffMins} mnt lalu`;
    if (diffHours < 24) return `${diffHours} jam lalu`;
    if (diffDays < 7) return `${diffDays} hari lalu`;
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
};

const getRatingStars = (rating: number) => '★'.repeat(rating) + '☆'.repeat(5 - rating);

const getLevelBadgeClass = (level: string) => {
    const classes: Record<string, string> = {
        'Internasional': 'bg-purple-50 text-purple-700 border-purple-200',
        'Nasional': 'bg-blue-50 text-blue-700 border-blue-200',
        'Provinsi': 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Kota/Kabupaten': 'bg-amber-50 text-amber-700 border-amber-200',
        'Universitas': 'bg-gray-50 text-gray-700 border-gray-200',
    };
    return classes[level] || 'bg-gray-50 text-gray-700 border-gray-200';
};
</script>

<template>
    <div class="space-y-6 max-w-7xl mx-auto pb-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-1">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Overview</h1>
                <p class="mt-1 text-sm text-gray-500 font-medium">Ringkasan performa sistem FSTI ITK.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between transition-all hover:shadow-md">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Berita Terbit</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-gray-900">{{ stats.publishedPosts }}</span>
                        <span class="text-sm text-gray-400 font-medium">/ {{ stats.totalPosts }}</span>
                    </div>
                </div>
                <div class="p-4 bg-blue-50 rounded-2xl text-blue-600"><Newspaper class="w-8 h-8" /></div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between transition-all hover:shadow-md">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Prestasi</p>
                    <span class="text-3xl font-extrabold text-gray-900">{{ stats.totalAchievements }}</span>
                </div>
                <div class="p-4 bg-emerald-50 rounded-2xl text-emerald-600"><Trophy class="w-8 h-8" /></div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between transition-all hover:shadow-md">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Indeks Kepuasan</p>
                    <div class="flex items-center gap-2">
                        <span class="text-3xl font-extrabold text-gray-900">{{ stats.avgRating || '0.0' }}</span>
                        <Star class="w-6 h-6 text-amber-400 fill-current" />
                    </div>
                </div>
                <div class="p-4 bg-amber-50 rounded-2xl text-amber-600"><MessageSquare class="w-8 h-8" /></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
            <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600"><BarChart3 class="w-5 h-5" /></div>
                    <h2 class="font-bold text-gray-800 uppercase tracking-wide text-sm">Statistik Pengunjung</h2>
                </div>
                
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex items-center gap-5 border-r border-gray-100 last:border-0">
                    <div class="p-4 bg-blue-50 rounded-xl text-blue-600"><Users class="w-7 h-7" /></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest leading-none">Hari Ini</p>
                        <p class="text-3xl font-black text-gray-900 mt-1.5">{{ stats.visitorsToday.toLocaleString() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5 border-r border-gray-100 last:border-0">
                    <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600"><Calendar class="w-7 h-7" /></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest leading-none">Bulan Ini</p>
                        <p class="text-3xl font-black text-emerald-600 mt-1.5">{{ stats.visitorsMonth.toLocaleString() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    <div class="p-4 bg-purple-50 rounded-xl text-purple-600"><Activity class="w-7 h-7" /></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest leading-none">Total Pengunjung</p>
                        <p class="text-3xl font-black text-purple-600 mt-1.5">{{ stats.totalVisitors.toLocaleString() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <TrendingUp class="w-5 h-5 text-blue-500" /> Tren Prestasi Mahasiswa
                </h3>
                <VueApexCharts v-if="charts.achievementsTrend.length > 0" type="area" height="300" :options="achievementsTrendOptions" :series="achievementsTrendSeries" />
                <div v-else class="h-[300px] flex items-center justify-center text-sm text-gray-400">Data belum tersedia</div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <PieChart class="w-5 h-5 text-purple-500" /> Sebaran Informasi Berita
                </h3>
                <VueApexCharts v-if="charts.postsByCategory.length > 0" type="donut" height="300" :options="postsByCategoryOptions" :series="postsByCategorySeries" />
                <div v-else class="h-[300px] flex items-center justify-center text-sm text-gray-400">Data belum tersedia</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-0.5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800">Berita Populer</h3>
                    <Link href="/admin/posts" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-tighter">Semua</Link>
                </div>
                <div class="space-y-4 flex-1">
                    <div v-for="(post, index) in recent.topViewedPosts" :key="post.id" class="flex items-start gap-3 group">
                        <span class="text-sm font-bold text-gray-300 mt-0.5">{{ index + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors cursor-pointer" :title="post.title">{{ post.title }}</p>
                            <div class="flex items-center gap-3 mt-1 text-[11px] text-gray-400 font-medium">
                                <span class="bg-gray-100 px-1.5 py-0.5 rounded">{{ post.category }}</span>
                                <span class="flex items-center gap-1"><Eye class="w-3 h-3" /> {{ post.views }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-if="!recent.topViewedPosts.length" class="text-center text-xs text-gray-400 py-4">Belum ada data berita</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800">Feedback Terakhir</h3>
                    <Link href="/admin/satisfaction-surveys" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-tighter">Semua</Link>
                </div>
                <div class="space-y-5 flex-1">
                    <div v-for="survey in recent.surveys" :key="survey.id" class="border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-gray-900">{{ survey.respondent_name || 'Anonim' }}</span>
                            <span class="text-amber-400 text-[10px] tracking-widest">{{ getRatingStars(survey.rating) }}</span>
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed italic">"{{ survey.feedback || 'Tidak ada pesan.' }}"</p>
                        <p class="text-[10px] text-gray-400 mt-2 font-medium uppercase tracking-tighter">{{ getTimeAgo(survey.created_at) }}</p>
                    </div>
                    <div v-if="!recent.surveys.length" class="text-center text-xs text-gray-400 py-4">Belum ada data feedback</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800">Prestasi Terbaru</h3>
                    <Link href="/admin/achievements" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-tighter">Semua</Link>
                </div>
                <div class="space-y-4 flex-1">
                    <div v-for="achievement in recent.achievements" :key="achievement.id" class="flex items-start gap-3">
                        <div class="mt-1 p-1.5 bg-gray-50 rounded-lg"><Award class="w-4 h-4 text-emerald-500" /></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 line-clamp-1" :title="achievement.title">{{ achievement.title }}</p>
                            
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ achievement.student_name }}</p>
                            
                            <div class="flex items-center gap-2 mt-1.5">
                                <span :class="['text-[9px] px-1.5 py-0.5 rounded-md border font-bold uppercase tracking-tighter', getLevelBadgeClass(achievement.level)]">
                                    {{ achievement.level }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-if="!recent.achievements.length" class="text-center text-xs text-gray-400 py-4">Belum ada data prestasi</div>
                </div>
            </div>
        </div>
    </div>
</template>