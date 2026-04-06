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
    Activity,
    MousePointer2
} from 'lucide-vue-next';

defineOptions({ layout: AdminLayout });

interface Props {
    stats: {
        totalPosts: number;
        publishedPosts: number;
        totalAchievements: number;
        totalStaff: number;
        totalDosen: number;
        totalTendik: number;
        totalUsers: number;
        totalSurveys: number;
        avgRating: number;
        totalPpid: number; 
        totalKategoriPpid: number; 
        totalAlumni: number;
        totalZonaIntegritas: number;
        totalLayanan: number;
        // Data Kunjungan dari Controller
        totalVisitors: number;
        visitorsToday: number;
        totalHits: number;
    };
    // Props tambahan dari HandleInertiaRequests (visitorStats)
    visitorStats?: {
        today: number;
        month: number;
        total: number;
    };
    charts: {
        achievementsByProdi: Array<{ name: string; total: number }>;
        achievementsByLevel: Array<{ name: string; total: number }>;
        achievementsByCategory: Array<{ name: string; total: number }>;
        achievementsTrend: Array<{ year: string; total: number }>;
        postsByCategory: Array<{ name: string; total: number }>;
        postsByStatus: Array<{ name: string; total: number }>;
        ratingDistribution: Array<{ rating: number; total: number }>;
        satisfactionByType: Array<{ name: string; avgRating: number; total: number }>;
        staffByCategory: Array<{ name: string; total: number }>;
    };
    recent: {
        posts: Array<{
            id: number;
            title: string;
            slug: string;
            category: string;
            status: string;
            views: number;
            published_at: string;
            created_at: string;
        }>;
        achievements: Array<{
            id: number;
            student_name: string;
            achievement_name: string;
            study_program: string;
            level: string;
            category: string;
            year: number;
            created_at: string;
        }>;
        surveys: Array<{
            id: number;
            respondent_name: string;
            respondent_type: string;
            service_category: string;
            rating: number;
            feedback: string;
            created_at: string;
        }>;
        topViewedPosts: Array<{
            id: number;
            title: string;
            slug: string;
            views: number;
            category: string;
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

// Grafik Tren
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

// Grafik Donut
const postsByCategoryOptions = computed((): ApexOptions => ({
    chart: { type: 'donut', fontFamily: 'inherit' },
    labels: props.charts.postsByCategory.map(i => i.name),
    colors: [colors.primary, colors.success, colors.warning, colors.purple, colors.teal],
    legend: { position: 'bottom', fontSize: '13px' },
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
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Overview</h1>
                <p class="mt-1 text-sm text-gray-500 font-medium">Ringkasan performa sistem dan statistik pengunjung.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between transition-all hover:shadow-md">
                <div class="space-y-1">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Berita Terbit</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-gray-900">{{ stats.publishedPosts }}</span>
                        <span class="text-sm text-gray-400 font-medium">/ {{ stats.totalPosts }} total</span>
                    </div>
                </div>
                <div class="p-4 bg-blue-50 rounded-2xl text-blue-600"><Newspaper class="w-8 h-8" /></div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between transition-all hover:shadow-md">
                <div class="space-y-1">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Prestasi</p>
                    <span class="text-3xl font-extrabold text-gray-900">{{ stats.totalAchievements }}</span>
                </div>
                <div class="p-4 bg-emerald-50 rounded-2xl text-emerald-600"><Trophy class="w-8 h-8" /></div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between transition-all hover:shadow-md">
                <div class="space-y-1">
                    <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Rating Layanan</p>
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
                    <h2 class="font-bold text-gray-800 uppercase tracking-wide text-sm">Laporan Statistik Pengunjung</h2>
                </div>
                <div class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Update Otomatis
                </div>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex items-center gap-4 border-r border-gray-100 last:border-0">
                    <div class="p-4 bg-blue-50 rounded-xl text-blue-600"><Users class="w-7 h-7" /></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Hari Ini</p>
                        <p class="text-3xl font-black text-gray-900 mt-0.5">{{ stats.visitorsToday.toLocaleString() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 border-r border-gray-100 last:border-0">
                    <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600"><Calendar class="w-7 h-7" /></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Bulan Ini</p>
                        <p class="text-3xl font-black text-emerald-600 mt-0.5">{{ (stats.totalHits || 0).toLocaleString() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-purple-50 rounded-xl text-purple-600"><Activity class="w-7 h-7" /></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Total Pengunjung</p>
                        <p class="text-3xl font-black text-purple-600 mt-0.5">{{ stats.totalVisitors.toLocaleString() }}</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800">Berita Populer</h3>
                    <Link href="/admin/posts" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-tighter">Semua</Link>
                </div>
                <div class="space-y-4">
                    <div v-for="(post, index) in recent.topViewedPosts.slice(0, 5)" :key="post.id" class="flex items-start gap-3 group">
                        <span class="text-sm font-bold text-gray-300 mt-0.5">{{ index + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ post.title }}</p>
                            <div class="flex items-center gap-3 mt-1 text-[11px] text-gray-400 font-medium">
                                <span class="bg-gray-100 px-1.5 py-0.5 rounded">{{ post.category }}</span>
                                <span class="flex items-center gap-1"><Eye class="w-3 h-3" /> {{ post.views }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800">Feedback Terakhir</h3>
                    <Link href="/admin/satisfaction-surveys" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-tighter">Semua</Link>
                </div>
                <div class="space-y-5">
                    <div v-for="survey in recent.surveys.slice(0, 3)" :key="survey.id" class="border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-gray-900">{{ survey.respondent_name || 'Anonim' }}</span>
                            <span class="text-amber-400 text-[10px] tracking-widest">{{ getRatingStars(survey.rating) }}</span>
                        </div>
                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed italic">"{{ survey.feedback || 'Tidak ada pesan.' }}"</p>
                        <p class="text-[10px] text-gray-400 mt-2 font-medium uppercase tracking-tighter">{{ getTimeAgo(survey.created_at) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800">Prestasi Terbaru</h3>
                    <Link href="/admin/achievements" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-tighter">Semua</Link>
                </div>
                <div class="space-y-4">
                    <div v-for="achievement in recent.achievements.slice(0, 4)" :key="achievement.id" class="flex items-start gap-3">
                        <div class="mt-1 p-1.5 bg-gray-50 rounded-lg"><Award class="w-4 h-4 text-emerald-500" /></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 line-clamp-1">{{ achievement.achievement_name }}</p>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span :class="['text-[9px] px-1.5 py-0.5 rounded-md border font-bold uppercase tracking-tighter', getLevelBadgeClass(achievement.level)]">
                                    {{ achievement.level }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>