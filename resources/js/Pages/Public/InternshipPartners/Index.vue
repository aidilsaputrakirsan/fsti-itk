<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import PublicPagination from '@/Components/PublicPagination.vue';
import { Head, router } from '@inertiajs/vue3';
import { Search, X, Building2, MapPin, Briefcase, GraduationCap, ExternalLink, FileX2, Info } from 'lucide-vue-next';
import { debounce } from 'lodash';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
    partners: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
    studyPrograms: { type: Array, default: () => [] },
    businessFields: { type: Array, default: () => [] },
    stats: { type: Object, default: () => ({ total: 0, cities: 0, fields: 0 }) },
});

const search = ref(props.filters.search || '');
const type = ref(props.filters.type || '');
const prodi = ref(props.filters.prodi || '');
const bidang = ref(props.filters.bidang || '');

const typeTabs = [
    { value: '', label: 'Semua' },
    { value: 'kp', label: 'Kerja Praktik' },
    { value: 'magang', label: 'Magang' },
];

const isFiltering = computed(() => !!(search.value || type.value || prodi.value || bidang.value));

const applyFilters = () => {
    const params = {};
    if (search.value) params.search = search.value;
    if (type.value) params.type = type.value;
    if (prodi.value) params.prodi = prodi.value;
    if (bidang.value) params.bidang = bidang.value;

    router.get(route('internship-partners.index'), params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onFinish: () => AOS.refresh(),
    });
};

watch(search, debounce(applyFilters, 350));
watch([type, prodi, bidang], applyFilters);

const resetFilters = () => {
    search.value = '';
    type.value = '';
    prodi.value = '';
    bidang.value = '';
};

const initials = (name) =>
    name
        .replace(/^(PT|CV|PD|Perum|Persero)\.?\s+/i, '')
        .split(/\s+/)
        .slice(0, 2)
        .map((w) => w[0])
        .join('')
        .toUpperCase();

onMounted(() => AOS.init({ duration: 800, once: true }));
</script>

<template>
    <PublicLayout>
        <Head title="Mitra KP & Magang" />

        <Banner
            title="MITRA KP & MAGANG"
            subtitle="Referensi Tempat Kerja Praktik dan Magang Mahasiswa FSTI ITK"
            background-image="/images/background-banner.webp"
        />

        <div class="bg-white py-12 md:py-24 font-public-sans min-h-[70vh]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <!-- Intro + statistik -->
                <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-primary-hover rounded-[2rem] p-6 sm:p-8 md:p-14 mb-8 md:mb-10 overflow-hidden shadow-xl shadow-primary/20 border border-white/10" data-aos="fade-down">
                    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                    <div class="absolute -top-[30%] -right-[10%] w-[60%] h-[150%] bg-white/10 rounded-[100%] blur-[80px] pointer-events-none -rotate-12"></div>

                    <div class="relative z-10 flex flex-col lg:flex-row lg:items-end justify-between gap-8 text-white">
                        <div class="max-w-2xl">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-[10px] md:text-[11px] font-bold mb-4 uppercase tracking-[0.15em] text-blue-50">
                                <Briefcase class="w-3.5 h-3.5" /> Kerja Praktik & Magang
                            </div>
                            <h2 class="text-2xl sm:text-3xl md:text-5xl font-optimus font-bold mb-3 md:mb-4 leading-tight">
                                Bingung Cari<br>Tempat KP/Magang?
                            </h2>
                            <p class="text-blue-100 text-sm sm:text-base md:text-lg leading-relaxed font-light opacity-90">
                                Ini daftar perusahaan dan instansi yang pernah menjadi tempat Kerja Praktik dan Magang mahasiswa FSTI. Filter sesuai prodi atau bidang yang kamu minati.
                            </p>
                        </div>

                        <div class="grid grid-cols-3 gap-3 sm:gap-4 shrink-0">
                            <div class="rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md px-4 py-4 sm:px-6 text-center">
                                <div class="text-2xl sm:text-4xl font-bold">{{ stats.total }}</div>
                                <div class="text-[10px] sm:text-xs uppercase tracking-wider text-blue-100 mt-1">Mitra</div>
                            </div>
                            <div class="rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md px-4 py-4 sm:px-6 text-center">
                                <div class="text-2xl sm:text-4xl font-bold">{{ stats.fields }}</div>
                                <div class="text-[10px] sm:text-xs uppercase tracking-wider text-blue-100 mt-1">Bidang</div>
                            </div>
                            <div class="rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md px-4 py-4 sm:px-6 text-center">
                                <div class="text-2xl sm:text-4xl font-bold">{{ stats.cities }}</div>
                                <div class="text-[10px] sm:text-xs uppercase tracking-wider text-blue-100 mt-1">Lokasi</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="relative z-20 -mt-12 md:-mt-16 mx-auto max-w-5xl mb-6 bg-white p-3 md:p-4 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-grow">
                            <input v-model="search" type="text" placeholder="Cari nama perusahaan, bidang, atau kota..."
                                class="w-full pl-10 md:pl-12 pr-10 py-3 border-none focus:ring-0 bg-transparent text-slate-800 font-medium text-sm md:text-base placeholder-slate-400">
                            <Search class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" />
                            <button v-if="search" @click="search = ''" class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 text-slate-300 hover:text-primary bg-slate-50 rounded-full" aria-label="Hapus pencarian">
                                <X class="w-4 h-4" />
                            </button>
                        </div>
                        <select v-model="prodi" class="md:w-56 rounded-xl border-slate-200 bg-slate-50 text-sm font-medium text-slate-700 focus:border-primary focus:ring-primary" aria-label="Filter prodi">
                            <option value="">Semua Prodi</option>
                            <option v-for="p in studyPrograms" :key="p.id" :value="String(p.id)">{{ p.name }}</option>
                        </select>
                        <select v-model="bidang" class="md:w-56 rounded-xl border-slate-200 bg-slate-50 text-sm font-medium text-slate-700 focus:border-primary focus:ring-primary" aria-label="Filter bidang usaha">
                            <option value="">Semua Bidang</option>
                            <option v-for="b in businessFields" :key="b" :value="b">{{ b }}</option>
                        </select>
                    </div>
                </div>

                <div class="mx-auto max-w-5xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
                    <div class="flex flex-wrap gap-2">
                        <button v-for="tab in typeTabs" :key="tab.value" @click="type = tab.value"
                            class="px-4 py-2 rounded-xl text-sm font-bold border transition-colors"
                            :class="type === tab.value ? 'bg-primary text-white border-primary shadow-md shadow-primary/20' : 'bg-white text-slate-600 border-slate-200 hover:border-primary hover:text-primary'">
                            {{ tab.label }}
                        </button>
                    </div>
                    <button v-if="isFiltering" @click="resetFilters" class="self-start sm:self-auto px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-bold rounded-xl border border-gray-200 transition-colors">
                        Reset Filter
                    </button>
                </div>

                <!-- Kosong -->
                <div v-if="partners.data.length === 0" class="bg-white border border-gray-100 rounded-3xl p-16 text-center shadow-sm mx-auto max-w-3xl" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-primary/5 rounded-full flex items-center justify-center mx-auto mb-4">
                        <FileX2 class="h-10 w-10 text-primary" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ isFiltering ? 'Tidak Ditemukan' : 'Belum Ada Data' }}</h3>
                    <p class="mt-2 text-gray-500 font-medium max-w-md mx-auto">
                        {{ isFiltering ? 'Tidak ada mitra yang cocok dengan filter tersebut. Coba ubah atau reset filter.' : 'Daftar mitra KP dan magang akan segera ditambahkan.' }}
                    </p>
                </div>

                <!-- Daftar mitra -->
                <div v-else>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
                        <article v-for="(partner, index) in partners.data" :key="partner.id"
                            class="group bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_15px_40px_rgba(47,77,211,0.08)] hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 flex flex-col p-5 sm:p-6"
                            data-aos="fade-up" :data-aos-delay="(index % 3) * 50">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="h-14 w-14 shrink-0 rounded-xl border border-slate-100 bg-white p-1.5 flex items-center justify-center overflow-hidden">
                                    <img v-if="partner.logo_url" :src="partner.logo_url" :alt="`Logo ${partner.name}`" loading="lazy" class="max-h-full max-w-full object-contain">
                                    <span v-else class="text-lg font-bold text-primary">{{ initials(partner.name) }}</span>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-slate-800 leading-snug group-hover:text-primary transition-colors">{{ partner.name }}</h3>
                                    <span class="mt-1.5 inline-flex rounded-full bg-primary/10 px-2.5 py-0.5 text-[11px] font-bold text-primary">{{ partner.type_label }}</span>
                                </div>
                            </div>

                            <dl class="space-y-2 text-sm text-slate-600 mb-4">
                                <div class="flex items-start gap-2">
                                    <dt class="sr-only">Bidang usaha</dt>
                                    <Building2 class="w-4 h-4 mt-0.5 shrink-0 text-slate-400" />
                                    <dd>{{ partner.business_field }}</dd>
                                </div>
                                <div class="flex items-start gap-2">
                                    <dt class="sr-only">Lokasi</dt>
                                    <MapPin class="w-4 h-4 mt-0.5 shrink-0 text-slate-400" />
                                    <dd>{{ partner.location }}</dd>
                                </div>
                            </dl>

                            <div v-if="partner.study_programs.length" class="mb-4">
                                <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-2">
                                    <GraduationCap class="w-3.5 h-3.5" /> Pernah diisi mahasiswa
                                </p>
                                <div class="flex flex-wrap gap-1.5">
                                    <span v-for="name in partner.study_programs" :key="name" class="rounded-md bg-slate-50 border border-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-600">{{ name }}</span>
                                </div>
                            </div>

                            <a v-if="partner.website" :href="partner.website" target="_blank" rel="noopener noreferrer"
                                class="mt-auto inline-flex items-center gap-1.5 text-sm font-bold text-primary hover:underline w-fit">
                                Kunjungi Website <ExternalLink class="w-3.5 h-3.5" />
                            </a>
                        </article>
                    </div>

                    <PublicPagination :meta="partners" />
                </div>

                <p class="mx-auto max-w-3xl mt-12 flex items-start gap-2 text-xs sm:text-sm text-slate-500 bg-slate-50 border border-slate-100 rounded-2xl p-4">
                    <Info class="w-4 h-4 mt-0.5 shrink-0 text-primary" />
                    <span>Daftar ini adalah referensi tempat yang pernah menjadi lokasi KP/magang mahasiswa FSTI, bukan daftar lowongan yang sedang dibuka. Hubungi perusahaan/instansi terkait atau koordinator KP prodi untuk informasi penerimaan terbaru.</span>
                </p>
            </div>
        </div>
    </PublicLayout>
</template>
