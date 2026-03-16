<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { DocumentTextIcon, ArrowDownTrayIcon, ShieldCheckIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({})
    },
    documents: {
        type: Array,
        default: () => []
    }
});

// Data Naratif 6 Area Perubahan (Statis/Baku dari KemenPAN-RB)
const areaZIData = [
    { id: 1, title: 'Manajemen Perubahan', desc: 'Mengubah sistem kerja dan budaya birokrasi menjadi lebih transparan, akuntabel, dan berintegritas tinggi melalui Role Model dan agen perubahan.' },
    { id: 2, title: 'Penataan Tata Laksana', desc: 'Meningkatkan efisiensi dan efektivitas sistem, proses, dan prosedur kerja yang jelas, efektif, efisien, dan terukur.' },
    { id: 3, title: 'Penataan Sistem Manajemen SDM', desc: 'Meningkatkan profesionalisme SDM aparatur pada Zona Integritas menuju Wilayah Bebas dari Korupsi (WBK).' },
    { id: 4, title: 'Penguatan Akuntabilitas', desc: 'Meningkatkan kapasitas dan akuntabilitas kinerja instansi pemerintah dengan budaya kinerja yang prima.' },
    { id: 5, title: 'Penguatan Pengawasan', desc: 'Meningkatkan penyelenggaraan pemerintahan yang bersih dan bebas KKN pada masing-masing instansi pemerintah.' },
    { id: 6, title: 'Peningkatan Kualitas Pelayanan Publik', desc: 'Meningkatkan kualitas dan inovasi pelayanan publik sesuai kebutuhan dan harapan masyarakat.' }
];

// Data Dummy SEMENTARA (Teks Role Model dihapus)
const displayDescription = props.profile?.description || `Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan senantiasa berkomitmen penuh dalam mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM) melalui reformasi birokrasi yang berkesinambungan serta peningkatan kualitas pelayanan publik yang transparan dan terukur.`;

const displayMaklumat = props.profile?.service_declaration_image_path || null;

const displayDocuments = props.documents?.length > 0 ? props.documents : [
    { id: 1, title: 'SK Tim Zona Integritas FSTI Tahun 2025', file_url: '#' },
    { id: 2, title: 'SK Role Model ZI FSTI 2025-2027', file_url: '#' },
    { id: 3, title: 'Rencana Kerja Zona Integritas FSTI', file_url: '#' },
];
</script>

<template>
    <PublicLayout>
        <Head title="Zona Integritas (ZI)" />
        
        <Banner
            title="Zona Integritas (ZI)"
            subtitle="WILAYAH BEBAS DARI KORUPSI (WBK) FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <section class="relative bg-white py-16 md:py-24 border-b border-gray-100 overflow-hidden">
            <div class="absolute top-0 left-0 w-72 h-72 bg-[#CBDCEB]/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-[#4682A9]/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 translate-x-1/3 translate-y-1/3"></div>

            <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center relative z-10">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-[#4682A9] blur opacity-20 rounded-xl"></div>
                        <span class="relative inline-flex items-center justify-center p-3.5 bg-gradient-to-br from-white to-blue-50 text-[#133E87] rounded-xl shadow-sm border border-blue-100 rotate-3 transform hover:rotate-0 transition-transform duration-300">
                            <ShieldCheckIcon class="w-8 h-8" />
                        </span>
                    </div>
                </div>

                <h2 class="text-3xl md:text-4xl font-kulim-park-bold text-[#133E87] uppercase mb-10 tracking-wide">
                    Komitmen Kami
                </h2>

                <div class="relative inline-block px-4 md:px-10">
                    <svg class="absolute -top-6 left-0 w-10 h-10 md:w-14 md:h-14 text-[#CBDCEB] transform -scale-x-100 -rotate-12" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/></svg>

                    <p class="text-base md:text-xl text-gray-700 font-inter-semibold leading-relaxed md:leading-9 whitespace-pre-wrap italic relative z-10">
                        {{ displayDescription }}
                    </p>

                    <svg class="absolute -bottom-6 right-0 w-10 h-10 md:w-14 md:h-14 text-[#CBDCEB] rotate-12" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/></svg>
                </div>
                
                <div class="w-12 h-1.5 bg-[#4682A9] mx-auto mt-12 rounded-full"></div>
            </div>
        </section>

        <section v-if="displayMaklumat" class="bg-white py-16 md:py-24">
            <div class="max-w-5xl mx-auto px-6 lg:px-8">
                <div class="bg-gradient-to-br from-[#133E87] to-[#4682A9] rounded-3xl p-8 md:p-12 shadow-xl text-center relative overflow-hidden">
                    <ShieldCheckIcon class="absolute -right-10 -bottom-10 w-64 h-64 text-white opacity-10" />
                    
                    <h2 class="text-2xl md:text-3xl font-kulim-park-bold text-white mb-8 relative z-10">Maklumat Pelayanan</h2>
                    <div class="inline-block p-2 bg-white/20 backdrop-blur-md rounded-2xl border border-white/30 relative z-10">
                        <img :src="displayMaklumat" alt="Maklumat Pelayanan FSTI" class="max-h-[600px] w-auto object-contain rounded-xl shadow-lg">
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-16 md:py-24 border-y border-gray-200">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="w-16 h-1 bg-[#4682A9] mx-auto mb-4"></div>
                    <h2 class="text-3xl md:text-4xl font-kulim-park-bold text-[#133E87] uppercase mb-4">6 Area Perubahan ZI</h2>
                    <p class="text-gray-600 font-inter-semibold max-w-2xl mx-auto">Sasaran strategis dalam mewujudkan birokrasi yang bersih, akuntabel, dan pelayanan publik yang prima.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="area in areaZIData" :key="area.id" class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 hover:border-[#4682A9] hover:shadow-md transition-all duration-300 group">
                        <div class="w-14 h-14 bg-[#CBDCEB]/60 text-[#133E87] rounded-xl flex items-center justify-center mb-6 font-kulim-park-bold text-2xl group-hover:bg-[#133E87] group-hover:text-white transition-colors">
                            {{ area.id }}
                        </div>
                        <h3 class="text-xl font-inter-bold text-gray-900 mb-3 group-hover:text-[#4682A9] transition-colors">{{ area.title }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed font-inter-semibold">{{ area.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-16 md:py-24">
            <div class="max-w-5xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="w-16 h-1 bg-[#133E87] mx-auto mb-4"></div>
                    <h2 class="text-3xl md:text-4xl font-kulim-park-bold text-[#133E87] uppercase mb-4">Dokumen Zona Integritas</h2>
                    <p class="text-gray-600 font-inter-semibold">Arsip dokumen, SK, dan bukti fisik pendukung pelaksanaan ZI di FSTI.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a 
                        v-for="doc in displayDocuments" 
                        :key="doc.id" 
                        :href="doc.file_url" 
                        target="_blank"
                        class="flex items-center bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md hover:border-[#4682A9] transition-all group"
                    >
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-50 text-[#4682A9] rounded-lg flex items-center justify-center mr-5 group-hover:bg-[#4682A9] group-hover:text-white transition-colors">
                            <DocumentTextIcon class="w-6 h-6" />
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-inter-bold text-gray-900 leading-snug group-hover:text-[#133E87] transition-colors line-clamp-2">
                                {{ doc.title }}
                            </h3>
                            <span class="text-xs font-inter-semibold text-[#4682A9] mt-1 flex items-center">
                                <ArrowDownTrayIcon class="w-3 h-3 mr-1" /> Lihat / Unduh
                            </span>
                        </div>
                    </a>
                </div>

            </div>
        </section>

    </PublicLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Kulim+Park:wght@600;700&display=swap');
.font-kulim-park-bold { font-family: 'Kulim Park', sans-serif; font-weight: 700; }
.font-inter-semibold { font-family: 'Inter', sans-serif; font-weight: 500; }
.font-inter-bold { font-family: 'Inter', sans-serif; font-weight: 700; }
</style>