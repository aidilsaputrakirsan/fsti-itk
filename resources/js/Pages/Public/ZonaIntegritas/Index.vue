<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { 
    DocumentTextIcon, 
    ArrowDownTrayIcon, 
    ShieldCheckIcon,
    ArrowPathRoundedSquareIcon, 
    ClipboardDocumentListIcon,  
    UserGroupIcon,              
    ChartBarIcon,               
    MagnifyingGlassCircleIcon,  
    StarIcon                    
} from '@heroicons/vue/24/outline';

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

// Data Naratif 6 Area Perubahan dengan Ikon Spesifik
const areaZIData = [
    { id: 1, title: 'Manajemen Perubahan', desc: 'Mengubah sistem kerja dan budaya birokrasi menjadi lebih transparan, akuntabel, dan berintegritas tinggi melalui Role Model dan agen perubahan.', icon: ArrowPathRoundedSquareIcon },
    { id: 2, title: 'Penataan Tata Laksana', desc: 'Meningkatkan efisiensi dan efektivitas sistem, proses, dan prosedur kerja yang jelas, efektif, efisien, dan terukur.', icon: ClipboardDocumentListIcon },
    { id: 3, title: 'Penataan Sistem Manajemen SDM', desc: 'Meningkatkan profesionalisme SDM aparatur pada Zona Integritas menuju Wilayah Bebas dari Korupsi (WBK).', icon: UserGroupIcon },
    { id: 4, title: 'Penguatan Akuntabilitas', desc: 'Meningkatkan kapasitas dan akuntabilitas kinerja instansi pemerintah dengan budaya kinerja yang prima.', icon: ChartBarIcon },
    { id: 5, title: 'Penguatan Pengawasan', desc: 'Meningkatkan penyelenggaraan pemerintahan yang bersih dan bebas KKN pada masing-masing instansi pemerintah.', icon: MagnifyingGlassCircleIcon },
    { id: 6, title: 'Peningkatan Kualitas Pelayanan Publik', desc: 'Meningkatkan kualitas dan inovasi pelayanan publik sesuai kebutuhan dan harapan masyarakat.', icon: StarIcon }
];

// Data Profil (Teks Komitmen & Maklumat)
const displayDescription = props.profile?.description || 'Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan senantiasa berkomitmen penuh dalam mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM).';
const displayMaklumat = props.profile?.service_declaration_image_path || null;

// Data Dokumen
const displayDocuments = props.documents || [];
</script>

<template>
    <PublicLayout>
        <Head title="Zona Integritas (ZI)" />
        
        <Banner
            title="Zona Integritas (ZI)"
            subtitle="WILAYAH BEBAS DARI KORUPSI (WBK) FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <section class="relative bg-white py-12 md:py-16 overflow-hidden font-public-sans">
            <div class="absolute top-0 left-0 w-72 h-72 bg-primary/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-primary/5 rounded-full mix-blend-multiply filter blur-3xl opacity-70 translate-x-1/3 translate-y-1/3"></div>

            <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center relative z-10">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-primary blur opacity-20 rounded-xl"></div>
                        <span class="relative inline-flex items-center justify-center p-3.5 bg-gradient-to-br from-white to-blue-50 text-primary rounded-xl shadow-sm border border-blue-100 rotate-3 transform hover:rotate-0 transition-transform duration-300">
                            <ShieldCheckIcon class="w-8 h-8" />
                        </span>
                    </div>
                </div>

                <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary uppercase mb-10 tracking-wide">
                    Komitmen Kami
                </h2>

                <div class="relative inline-block px-4 md:px-10">
                    <svg class="absolute -top-6 left-0 w-10 h-10 md:w-14 md:h-14 text-primary/20 transform -scale-x-100 -rotate-12" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/></svg>

                    <p class="text-base md:text-xl text-black font-semibold leading-relaxed md:leading-9 whitespace-pre-wrap italic relative z-10">
                        {{ displayDescription }}
                    </p>

                    <svg class="absolute -bottom-6 right-0 w-10 h-10 md:w-14 md:h-14 text-primary/20 rotate-12" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/></svg>
                </div>
            </div>
        </section>

        <section v-if="displayMaklumat" class="bg-white py-10 md:py-12 font-public-sans">
            <div class="max-w-6xl mx-auto px-6 lg:px-8">
                <div class="relative bg-primary rounded-[2rem] p-6 md:p-10 shadow-2xl text-center overflow-hidden flex justify-center">
                    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-white rounded-full mix-blend-screen filter blur-[100px] opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-white rounded-full mix-blend-screen filter blur-[100px] opacity-10 translate-x-1/3 translate-y-1/3"></div>
                    <ShieldCheckIcon class="absolute right-10 top-1/2 -translate-y-1/2 w-96 h-96 text-white opacity-[0.05] pointer-events-none" />
                    
                    <div class="inline-block p-2 bg-white/10 backdrop-blur-md rounded-[1.5rem] border border-white/20 relative z-10 w-full max-w-4xl">
                        <img :src="displayMaklumat" alt="Maklumat Pelayanan FSTI" class="w-full max-h-[800px] object-contain rounded-xl shadow-lg bg-white/5">
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 md:py-16 font-public-sans">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="w-16 h-1 bg-primary mx-auto mb-8"></div>
                    <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary uppercase mb-4">6 Area Perubahan ZI</h2>
                    <p class="text-gray-700 font-medium max-w-2xl mx-auto">Sasaran strategis dalam mewujudkan birokrasi yang bersih, akuntabel, dan pelayanan publik yang prima.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="area in areaZIData" :key="area.id" class="relative bg-white p-8 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 hover:border-primary hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden">
                        
                        <div class="absolute -right-4 -bottom-4 text-9xl font-optimus font-bold text-gray-50 opacity-60 group-hover:text-primary/5 transition-colors pointer-events-none select-none">
                            {{ area.id }}
                        </div>

                        <div class="relative z-10">
                            <div class="w-14 h-14 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                                <component :is="area.icon" class="w-7 h-7" />
                            </div>
                            
                            <h3 class="text-xl font-bold text-primary mb-3 group-hover:text-primary/80 transition-colors">{{ area.title }}</h3>
                            
                            <p class="text-sm text-gray-700 leading-relaxed font-medium">{{ area.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 md:py-16 font-public-sans">
            <div class="max-w-5xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-12">
                    <div class="w-16 h-1 bg-primary mx-auto mb-8"></div>
                    <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary uppercase mb-4">Dokumen Zona Integritas</h2>
                    <p class="text-gray-700 font-medium">Arsip dokumen, SK, dan bukti fisik pendukung pelaksanaan ZI di FSTI.</p>
                </div>

                <div v-if="displayDocuments.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a 
                        v-for="doc in displayDocuments" 
                        :key="doc.id" 
                        :href="doc.file_url" 
                        target="_blank"
                        class="relative flex items-center bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:border-primary transition-all duration-300 group overflow-hidden"
                    >
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary/50 group-hover:bg-primary transition-colors"></div>

                        <div class="flex-shrink-0 w-14 h-14 bg-primary/5 text-primary rounded-xl flex items-center justify-center mr-5 group-hover:bg-primary group-hover:text-white transition-colors border border-primary/10">
                            <DocumentTextIcon class="w-7 h-7" />
                        </div>
                        <div class="flex-1 pr-2">
                            <h3 class="text-base font-bold text-primary leading-snug group-hover:text-primary/80 transition-colors line-clamp-2">
                                {{ doc.title }}
                            </h3>
                            <span class="inline-flex items-center text-xs font-bold text-primary mt-2 bg-primary/5 px-2.5 py-1 rounded-md group-hover:bg-primary group-hover:text-white transition-colors">
                                <ArrowDownTrayIcon class="w-3.5 h-3.5 mr-1.5" /> Lihat Dokumen
                            </span>
                        </div>
                    </a>
                </div>

                <div v-else class="text-center bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-3xl p-12 max-w-2xl mx-auto">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <DocumentTextIcon class="w-10 h-10 text-gray-400" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Dokumen Publikasi</h3>
                    <p class="text-gray-500 font-medium">Dokumen pendukung Zona Integritas FSTI sedang dalam tahap penyusunan dan akan segera dipublikasikan di sini.</p>
                </div>

            </div>
        </section>

    </PublicLayout>
</template>