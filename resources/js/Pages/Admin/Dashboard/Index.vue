<script setup lang="ts">
import { computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import VueApexCharts from 'vue3-apexcharts';
import type { ApexOptions } from 'apexcharts';
import {
    Newspaper,
    Trophy,
    Users,
    Star,
    FileText,
    GraduationCap,
    Building2,
    Link2,
    TrendingUp,
    Eye,
    Clock,
    MessageSquare
} from 'lucide-vue-next';

defineOptions({ layout: AdminLayout });

// Props dari controller
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
        totalAlumni: number;
        totalZonaIntegritas: number;
        totalLayanan: number;
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

// Chart Colors
const colors = {
    primary: '#3B82F6',
    success: '#10B981',
    warning: '#F59E0B',
    danger: '#EF4444',
    purple: '#8B5CF6',
    pink: '#EC4899',
    indigo: '#6366F1',
    teal: '#14B8A6',
};

const chartColors = [colors.primary, colors.success, colors.warning, colors.purple, colors.pink, colors.indigo, colors.teal, colors.danger];

// === CHART OPTIONS ===

// 1. Prestasi per Program Studi (Horizontal Bar)
const achievementsByProdiOptions = computed((): ApexOptions => ({
    chart: {
        type: 'bar' as const,
        toolbar: { show: false },
        fontFamily: 'inherit',
    },
    plotOptions: {
        bar: {
            horizontal: true,
            borderRadius: 4,
            dataLabels: { position: 'top' },
        },
    },
    colors: [colors.primary],
    dataLabels: {
        enabled: true,
        offsetX: 20,
        style: { fontSize: '12px', colors: ['#374151'] },
    },
    xaxis: {
        categories: props.charts.achievementsByProdi.map(i => i.name),
    },
    yaxis: {
        labels: {
            style: { fontSize: '11px' },
            maxWidth: 150,
        },
    },
    tooltip: { y: { formatter: (val: number) => `${val} prestasi` } },
}));

const achievementsByProdiSeries = computed(() => [{
    name: 'Prestasi',
    data: props.charts.achievementsByProdi.map(i => i.total),
}]);

// 2. Prestasi per Tingkat (Donut)
const achievementsByLevelOptions = computed((): ApexOptions => ({
    chart: {
        type: 'donut' as const,
        fontFamily: 'inherit',
    },
    labels: props.charts.achievementsByLevel.map(i => i.name),
    colors: chartColors,
    legend: {
        position: 'bottom' as const,
        fontSize: '12px',
    },
    dataLabels: {
        enabled: true,
        formatter: (val: number) => `${val.toFixed(0)}%`,
    },
    plotOptions: {
        pie: {
            donut: {
                size: '60%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        fontSize: '14px',
                        fontWeight: 600,
                    },
                },
            },
        },
    },
    tooltip: { y: { formatter: (val: number) => `${val} prestasi` } },
}));

const achievementsByLevelSeries = computed(() =>
    props.charts.achievementsByLevel.map(i => i.total)
);

// 3. Trend Prestasi per Tahun (Line)
const achievementsTrendOptions = computed((): ApexOptions => ({
    chart: {
        type: 'area' as const,
        toolbar: { show: false },
        fontFamily: 'inherit',
        sparkline: { enabled: false },
    },
    stroke: {
        curve: 'smooth' as const,
        width: 3,
    },
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
        },
    },
    colors: [colors.success],
    xaxis: {
        categories: props.charts.achievementsTrend.map(i => i.year),
    },
    yaxis: {
        min: 0,
    },
    dataLabels: { enabled: false },
    tooltip: { y: { formatter: (val: number) => `${val} prestasi` } },
}));

const achievementsTrendSeries = computed(() => [{
    name: 'Prestasi',
    data: props.charts.achievementsTrend.map(i => i.total),
}]);

// 4. Berita per Kategori (Pie)
const postsByCategoryOptions = computed((): ApexOptions => ({
    chart: {
        type: 'pie' as const,
        fontFamily: 'inherit',
    },
    labels: props.charts.postsByCategory.map(i => i.name),
    colors: [colors.primary, colors.success, colors.warning, colors.purple],
    legend: {
        position: 'bottom' as const,
        fontSize: '12px',
    },
    dataLabels: {
        enabled: true,
        formatter: (val: number) => `${val.toFixed(0)}%`,
    },
    tooltip: { y: { formatter: (val: number) => `${val} berita` } },
}));

const postsByCategorySeries = computed(() =>
    props.charts.postsByCategory.map(i => i.total)
);

// 5. Distribusi Rating (Bar)
const ratingDistributionOptions = computed((): ApexOptions => ({
    chart: {
        type: 'bar' as const,
        toolbar: { show: false },
        fontFamily: 'inherit',
    },
    plotOptions: {
        bar: {
            borderRadius: 6,
            columnWidth: '60%',
            distributed: true,
        },
    },
    colors: [colors.danger, colors.warning, '#FCD34D', colors.teal, colors.success],
    dataLabels: {
        enabled: true,
        style: { fontSize: '12px', colors: ['#fff'] },
    },
    xaxis: {
        categories: ['1', '2', '3', '4', '5'],
        title: { text: 'Rating' },
    },
    yaxis: {
        title: { text: 'Jumlah Responden' },
    },
    legend: { show: false },
    tooltip: { y: { formatter: (val: number) => `${val} responden` } },
}));

const ratingDistributionSeries = computed(() => {
    // Ensure we have all ratings 1-5
    const ratings = [1, 2, 3, 4, 5].map(r => {
        const found = props.charts.ratingDistribution.find(i => i.rating === r);
        return found ? found.total : 0;
    });
    return [{ name: 'Responden', data: ratings }];
});

// 6. Staff per Kategori (Horizontal Bar)
const staffByCategoryOptions = computed((): ApexOptions => ({
    chart: {
        type: 'bar' as const,
        toolbar: { show: false },
        fontFamily: 'inherit',
    },
    plotOptions: {
        bar: {
            horizontal: true,
            borderRadius: 4,
            distributed: true,
        },
    },
    colors: chartColors,
    dataLabels: {
        enabled: true,
        style: { fontSize: '12px' },
    },
    xaxis: {
        categories: props.charts.staffByCategory.map(i => i.name),
    },
    legend: { show: false },
    tooltip: { y: { formatter: (val: number) => `${val} orang` } },
}));

const staffByCategorySeries = computed(() => [{
    name: 'Staff',
    data: props.charts.staffByCategory.map(i => i.total),
}]);

// Helper functions
const formatDate = (dateString: string) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
};

const getTimeAgo = (dateString: string) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now.getTime() - date.getTime();
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);

    if (diffMins < 60) return `${diffMins} menit lalu`;
    if (diffHours < 24) return `${diffHours} jam lalu`;
    if (diffDays < 7) return `${diffDays} hari lalu`;
    return formatDate(dateString);
};

const getLevelBadgeClass = (level: string) => {
    const classes: Record<string, string> = {
        'Internasional': 'bg-purple-100 text-purple-800',
        'Nasional': 'bg-blue-100 text-blue-800',
        'Provinsi': 'bg-green-100 text-green-800',
        'Kota/Kabupaten': 'bg-yellow-100 text-yellow-800',
        'Universitas': 'bg-gray-100 text-gray-800',
    };
    return classes[level] || 'bg-gray-100 text-gray-800';
};

const getRatingStars = (rating: number) => {
    return '★'.repeat(rating) + '☆'.repeat(5 - rating);
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Selamat datang di panel admin FSTI ITK</p>
        </div>

        <!-- Stats Cards - Row 1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Berita -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Berita</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.totalPosts }}</p>
                        <p class="text-xs text-green-600 mt-1">
                            {{ stats.publishedPosts }} terbit
                        </p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <Newspaper class="w-6 h-6 text-blue-600" />
                    </div>
                </div>
            </div>

            <!-- Total Prestasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Prestasi</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.totalAchievements }}</p>
                        <p class="text-xs text-gray-500 mt-1">Mahasiswa berprestasi</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl">
                        <Trophy class="w-6 h-6 text-yellow-600" />
                    </div>
                </div>
            </div>

            <!-- Total Dosen -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Dosen</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ stats.totalDosen }}</p>
                        <p class="text-xs text-gray-500 mt-1">+ {{ stats.totalTendik }} tendik</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl">
                        <GraduationCap class="w-6 h-6 text-green-600" />
                    </div>
                </div>
            </div>

            <!-- Rating Kepuasan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Rating Kepuasan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ stats.avgRating || '-' }}
                            <span class="text-yellow-500 text-lg">★</span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ stats.totalSurveys }} responden</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl">
                        <Star class="w-6 h-6 text-yellow-500" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards - Row 2 (Quick Stats) -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <FileText class="w-5 h-5 text-indigo-500 mx-auto" />
                <p class="text-xl font-bold text-gray-900 mt-2">{{ stats.totalPpid }}</p>
                <p class="text-xs text-gray-500">Dokumen PPID</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <Users class="w-5 h-5 text-teal-500 mx-auto" />
                <p class="text-xl font-bold text-gray-900 mt-2">{{ stats.totalAlumni }}</p>
                <p class="text-xs text-gray-500">Alumni Tracer</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <Building2 class="w-5 h-5 text-purple-500 mx-auto" />
                <p class="text-xl font-bold text-gray-900 mt-2">{{ stats.totalZonaIntegritas }}</p>
                <p class="text-xs text-gray-500">Zona Integritas</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <Link2 class="w-5 h-5 text-pink-500 mx-auto" />
                <p class="text-xl font-bold text-gray-900 mt-2">{{ stats.totalLayanan }}</p>
                <p class="text-xs text-gray-500">Layanan Internal</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <Users class="w-5 h-5 text-blue-500 mx-auto" />
                <p class="text-xl font-bold text-gray-900 mt-2">{{ stats.totalUsers }}</p>
                <p class="text-xs text-gray-500">Admin Users</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                <Users class="w-5 h-5 text-green-500 mx-auto" />
                <p class="text-xl font-bold text-gray-900 mt-2">{{ stats.totalStaff }}</p>
                <p class="text-xs text-gray-500">Total Staff</p>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Prestasi per Program Studi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Prestasi per Program Studi</h3>
                <VueApexCharts
                    v-if="charts.achievementsByProdi.length > 0"
                    type="bar"
                    height="300"
                    :options="achievementsByProdiOptions"
                    :series="achievementsByProdiSeries"
                />
                <div v-else class="h-[300px] flex items-center justify-center text-gray-400">
                    Belum ada data prestasi
                </div>
            </div>

            <!-- Prestasi per Tingkat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Prestasi per Tingkat</h3>
                <VueApexCharts
                    v-if="charts.achievementsByLevel.length > 0"
                    type="donut"
                    height="300"
                    :options="achievementsByLevelOptions"
                    :series="achievementsByLevelSeries"
                />
                <div v-else class="h-[300px] flex items-center justify-center text-gray-400">
                    Belum ada data prestasi
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Trend Prestasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">
                    <TrendingUp class="w-4 h-4 inline mr-1" />
                    Trend Prestasi per Tahun
                </h3>
                <VueApexCharts
                    v-if="charts.achievementsTrend.length > 0"
                    type="area"
                    height="250"
                    :options="achievementsTrendOptions"
                    :series="achievementsTrendSeries"
                />
                <div v-else class="h-[250px] flex items-center justify-center text-gray-400">
                    Belum ada data trend
                </div>
            </div>

            <!-- Berita per Kategori -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Berita per Kategori</h3>
                <VueApexCharts
                    v-if="charts.postsByCategory.length > 0"
                    type="pie"
                    height="250"
                    :options="postsByCategoryOptions"
                    :series="postsByCategorySeries"
                />
                <div v-else class="h-[250px] flex items-center justify-center text-gray-400">
                    Belum ada data berita
                </div>
            </div>
        </div>

        <!-- Charts Row 3 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Distribusi Rating -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Distribusi Rating Kepuasan</h3>
                <VueApexCharts
                    v-if="charts.ratingDistribution.length > 0"
                    type="bar"
                    height="250"
                    :options="ratingDistributionOptions"
                    :series="ratingDistributionSeries"
                />
                <div v-else class="h-[250px] flex items-center justify-center text-gray-400">
                    Belum ada data survey
                </div>
            </div>

            <!-- Staff per Kategori -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Staff per Kategori</h3>
                <VueApexCharts
                    v-if="charts.staffByCategory.length > 0"
                    type="bar"
                    height="250"
                    :options="staffByCategoryOptions"
                    :series="staffByCategorySeries"
                />
                <div v-else class="h-[250px] flex items-center justify-center text-gray-400">
                    Belum ada data staff
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Berita Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">
                        <Newspaper class="w-4 h-4 inline mr-1" />
                        Berita Terbaru
                    </h3>
                    <a href="/admin/posts" class="text-sm text-blue-600 hover:text-blue-800">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    <div
                        v-for="post in recent.posts"
                        :key="post.id"
                        class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ post.title }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">
                                    {{ post.category }}
                                </span>
                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                    <Eye class="w-3 h-3" /> {{ post.views }}
                                </span>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap">
                            {{ getTimeAgo(post.created_at) }}
                        </span>
                    </div>
                    <div v-if="recent.posts.length === 0" class="text-center text-gray-400 py-4">
                        Belum ada berita
                    </div>
                </div>
            </div>

            <!-- Prestasi Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">
                        <Trophy class="w-4 h-4 inline mr-1" />
                        Prestasi Terbaru
                    </h3>
                    <a href="/admin/achievements" class="text-sm text-blue-600 hover:text-blue-800">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    <div
                        v-for="achievement in recent.achievements"
                        :key="achievement.id"
                        class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ achievement.achievement_name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ achievement.student_name }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span :class="['text-xs px-2 py-0.5 rounded-full', getLevelBadgeClass(achievement.level)]">
                                    {{ achievement.level }}
                                </span>
                                <span class="text-xs text-gray-400">{{ achievement.year }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-if="recent.achievements.length === 0" class="text-center text-gray-400 py-4">
                        Belum ada prestasi
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Viewed Posts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">
                        <Eye class="w-4 h-4 inline mr-1" />
                        Berita Paling Banyak Dilihat
                    </h3>
                </div>
                <div class="space-y-2">
                    <div
                        v-for="(post, index) in recent.topViewedPosts"
                        :key="post.id"
                        class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <span class="text-lg font-bold text-gray-300 w-6">{{ index + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ post.title }}</p>
                            <span class="text-xs text-gray-400">{{ post.category }}</span>
                        </div>
                        <div class="flex items-center gap-1 text-sm text-gray-600">
                            <Eye class="w-4 h-4" />
                            <span class="font-medium">{{ post.views.toLocaleString() }}</span>
                        </div>
                    </div>
                    <div v-if="recent.topViewedPosts.length === 0" class="text-center text-gray-400 py-4">
                        Belum ada data
                    </div>
                </div>
            </div>

            <!-- Survey Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">
                        <MessageSquare class="w-4 h-4 inline mr-1" />
                        Feedback Terbaru
                    </h3>
                    <a href="/admin/satisfaction-surveys" class="text-sm text-blue-600 hover:text-blue-800">Lihat semua</a>
                </div>
                <div class="space-y-3">
                    <div
                        v-for="survey in recent.surveys"
                        :key="survey.id"
                        class="p-3 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-900">
                                {{ survey.respondent_name || 'Anonim' }}
                            </span>
                            <span class="text-yellow-500 text-sm">{{ getRatingStars(survey.rating) }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">{{ survey.respondent_type }} - {{ survey.service_category }}</p>
                        <p v-if="survey.feedback" class="text-sm text-gray-600 line-clamp-2">
                            "{{ survey.feedback }}"
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ getTimeAgo(survey.created_at) }}</p>
                    </div>
                    <div v-if="recent.surveys.length === 0" class="text-center text-gray-400 py-4">
                        Belum ada feedback
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
