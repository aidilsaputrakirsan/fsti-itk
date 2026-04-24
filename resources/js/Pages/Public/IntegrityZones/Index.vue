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
    StarIcon,
    GlobeAltIcon,
    ArrowTopRightOnSquareIcon,
    BanknotesIcon, 
    HandRaisedIcon, 
    GiftIcon, 
    BriefcaseIcon, 
    NoSymbolIcon
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

const areaZIData = [
    { id: 1, title: 'Manajemen Perubahan', desc: 'Mengubah sistem kerja dan budaya birokrasi menjadi lebih transparan, akuntabel, dan berintegritas tinggi melalui Role Model dan agen perubahan.', icon: ArrowPathRoundedSquareIcon },
    { id: 2, title: 'Penataan Tata Laksana', desc: 'Meningkatkan efisiensi dan efektivitas sistem, proses, dan prosedur kerja yang jelas, efektif, efisien, dan terukur.', icon: ClipboardDocumentListIcon },
    { id: 3, title: 'Penataan Sistem Manajemen SDM', desc: 'Meningkatkan profesionalisme SDM aparatur pada Zona Integritas menuju Wilayah Bebas dari Korupsi (WBK).', icon: UserGroupIcon },
    { id: 4, title: 'Penguatan Akuntabilitas', desc: 'Meningkatkan kapasitas dan akuntabilitas kinerja instansi pemerintah dengan budaya kinerja yang prima.', icon: ChartBarIcon },
    { id: 5, title: 'Penguatan Pengawasan', desc: 'Meningkatkan penyelenggaraan pemerintahan yang bersih dan bebas KKN pada masing-masing instansi pemerintah.', icon: MagnifyingGlassCircleIcon },
    { id: 6, title: 'Peningkatan Kualitas Pelayanan Publik', desc: 'Meningkatkan kualitas dan inovasi pelayanan publik sesuai kebutuhan dan harapan masyarakat.', icon: StarIcon }
];

const displayDescription = props.profile?.description || 'Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan senantiasa berkomitmen penuh dalam mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM).';
const displayMaklumat = props.profile?.service_declaration_image_path || null;

const displayDocuments = props.documents || [];
</script>

<template>
    <PublicLayout>
        <Head title="Zona Integritas (ZI)" />
        
        <Banner
            title="Zona Integritas (ZI)"
            subtitle="WILAYAH BEBAS DARI KORUPSI (WBK) FSTI ITK"
            background-image="/images/background-banner.webp"
        />

        <section class="relative bg-white py-12 md:py-16 overflow-hidden font-public-sans">
            <div class="absolute top-0 left-0 w-72 h-72 bg-primary/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-primary/5 rounded-full mix-blend-multiply filter blur-3xl opacity-70 translate-x-1/3 translate-y-1/3"></div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="flex justify-center mb-5 md:mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-primary blur opacity-20 rounded-xl"></div>
                        <span class="relative inline-flex items-center justify-center p-3 sm:p-3.5 bg-gradient-to-br from-white to-blue-50 text-primary rounded-xl shadow-sm border border-blue-100 rotate-3 transform hover:rotate-0 transition-transform duration-300">
                            <ShieldCheckIcon class="w-6 h-6 sm:w-8 sm:h-8" />
                        </span>
                    </div>
                </div>

                <h2 class="text-2xl sm:text-3xl md:text-4xl font-optimus font-bold text-primary uppercase mb-6 md:mb-10 tracking-wide">
                    Komitmen Kami
                </h2>

                <div class="relative inline-block px-4 md:px-10">
                    <svg class="absolute -top-4 md:-top-6 left-0 w-8 h-8 md:w-14 md:h-14 text-primary/20 transform -scale-x-100 -rotate-12" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/></svg>

                    <p class="text-sm sm:text-base md:text-xl text-black font-semibold leading-relaxed md:leading-9 whitespace-pre-wrap italic relative z-10 px-2 md:px-0">
                        {{ displayDescription }}
                    </p>

                    <svg class="absolute -bottom-4 md:-bottom-6 right-0 w-8 h-8 md:w-14 md:h-14 text-primary/20 rotate-12" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/></svg>
                </div>
            </div>
        </section>

        <section v-if="displayMaklumat" class="bg-white py-10 md:py-12 font-public-sans">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative bg-primary rounded-[1.5rem] md:rounded-[2rem] p-4 sm:p-6 md:p-10 shadow-2xl text-center overflow-hidden flex justify-center">
                    <div class="absolute top-0 left-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-white rounded-full mix-blend-screen filter blur-[60px] md:blur-[100px] opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-white rounded-full mix-blend-screen filter blur-[60px] md:blur-[100px] opacity-10 translate-x-1/3 translate-y-1/3"></div>
                    <ShieldCheckIcon class="absolute right-4 md:right-10 top-1/2 -translate-y-1/2 w-48 md:w-96 h-96 text-white opacity-[0.05] pointer-events-none" />
                    
                    <div class="inline-block p-1.5 md:p-2 bg-white/10 backdrop-blur-md rounded-[1rem] md:rounded-[1.5rem] border border-white/20 relative z-10 w-full max-w-4xl">
                        <img :src="displayMaklumat" alt="Maklumat Pelayanan FSTI" class="w-full max-h-[400px] md:max-h-[800px] object-contain rounded-lg md:rounded-xl shadow-lg bg-white/5">
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 md:py-16 font-public-sans">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10 md:mb-12">
                    <div class="w-12 md:w-16 h-1 bg-primary mx-auto mb-4 md:mb-8 rounded-full"></div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-optimus font-bold text-primary uppercase mb-3 md:mb-4">6 Area Perubahan ZI</h2>
                    <p class="text-gray-700 text-sm md:text-base font-medium max-w-2xl mx-auto">Sasaran strategis dalam mewujudkan birokrasi yang bersih, akuntabel, dan pelayanan publik yang prima.</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
                    <div v-for="area in areaZIData" :key="area.id" class="relative bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 hover:border-primary hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden flex flex-col h-full">
                        
                        <div class="absolute -right-2 -bottom-2 md:-right-4 md:-bottom-4 text-7xl md:text-9xl font-optimus font-bold text-gray-50 opacity-60 group-hover:text-primary/5 transition-colors pointer-events-none select-none">
                            {{ area.id }}
                        </div>

                        <div class="relative z-10 flex flex-col h-full">
                            <div class="w-10 h-10 md:w-14 md:h-14 bg-primary/10 text-primary rounded-lg md:rounded-xl flex items-center justify-center mb-3 md:mb-6 group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                                <component :is="area.icon" class="w-5 h-5 md:w-7 md:h-7" />
                            </div>
                            
                            <h3 class="text-sm sm:text-base md:text-xl font-bold text-primary mb-1.5 md:mb-3 group-hover:text-primary/80 transition-colors leading-tight">{{ area.title }}</h3>
                            
                            <p class="text-[10px] sm:text-xs md:text-sm text-gray-700 leading-relaxed font-medium flex-grow">{{ area.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-8 md:py-12 font-public-sans">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden bg-gradient-to-r from-primary to-blue-900 rounded-[2rem] shadow-[0_10px_40px_-10px_rgba(47,77,211,0.4)] p-8 md:p-12 lg:p-16 border border-blue-700/50">
                    
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3 pointer-events-none"></div>
                    <ShieldCheckIcon class="absolute right-8 md:right-24 top-1/2 -translate-y-1/2 w-40 h-40 md:w-64 md:h-64 text-white opacity-5 transform rotate-12 pointer-events-none" />

                    <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-16">
                        
                        <div class="flex-1 text-center lg:text-left">
                            <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-[10px] md:text-xs font-bold uppercase tracking-widest text-white mb-4 backdrop-blur-sm">
                                Kawasan Wilayah Bebas dari Korupsi (WBK)
                            </span>
                            <h3 class="text-4xl md:text-5xl lg:text-6xl font-optimus font-bold text-white mb-4 leading-tight drop-shadow-md">
                                BERANI JUJUR,<br/> <span class="text-yellow-400">HEBAT!</span>
                            </h3>
                            <p class="text-blue-100 text-sm md:text-lg font-medium leading-relaxed max-w-2xl mx-auto lg:mx-0">
                                Seluruh pimpinan, sivitas akademika, dan tenaga kependidikan FSTI ITK berkomitmen memberikan pelayanan prima yang transparan, akuntabel, dan terbebas dari segala bentuk penyimpangan.
                            </p>
                        </div>

                        <div class="shrink-0 w-full lg:w-auto">
                            <div class="grid grid-cols-2 gap-4 md:gap-5">
                                
                                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:bg-white/20 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="relative w-12 h-12 md:w-14 md:h-14 mb-3 mx-auto">
                                        <BanknotesIcon class="absolute inset-0 w-full h-full text-white p-2.5" stroke-width="1.5" />
                                        <NoSymbolIcon class="absolute inset-0 w-full h-full text-red-500 drop-shadow-md" stroke-width="2.5" />
                                    </div>
                                    <span class="font-black text-white tracking-widest text-sm md:text-base">NO SUAP</span>
                                </div>

                                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:bg-white/20 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="relative w-12 h-12 md:w-14 md:h-14 mb-3 mx-auto">
                                        <HandRaisedIcon class="absolute inset-0 w-full h-full text-white p-2.5" stroke-width="1.5" />
                                        <NoSymbolIcon class="absolute inset-0 w-full h-full text-red-500 drop-shadow-md" stroke-width="2.5" />
                                    </div>
                                    <span class="font-black text-white tracking-widest text-sm md:text-base">NO PUNGLI</span>
                                </div>

                                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:bg-white/20 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="relative w-12 h-12 md:w-14 md:h-14 mb-3 mx-auto">
                                        <GiftIcon class="absolute inset-0 w-full h-full text-white p-2.5" stroke-width="1.5" />
                                        <NoSymbolIcon class="absolute inset-0 w-full h-full text-red-500 drop-shadow-md" stroke-width="2.5" />
                                    </div>
                                    <span class="font-black text-white tracking-widest text-sm md:text-base">NO GRATIFIKASI</span>
                                </div>

                                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 flex flex-col items-center justify-center text-center hover:bg-white/20 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <div class="relative w-12 h-12 md:w-14 md:h-14 mb-3 mx-auto">
                                        <BriefcaseIcon class="absolute inset-0 w-full h-full text-white p-2.5" stroke-width="1.5" />
                                        <NoSymbolIcon class="absolute inset-0 w-full h-full text-red-500 drop-shadow-md" stroke-width="2.5" />
                                    </div>
                                    <span class="font-black text-white tracking-widest text-sm md:text-base">NO KORUPSI</span>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 md:py-16 font-public-sans">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10 md:mb-12">
                    <div class="w-12 md:w-16 h-1 bg-primary mx-auto mb-4 md:mb-8 rounded-full"></div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-optimus font-bold text-primary uppercase mb-3 md:mb-4">Dokumen Zona Integritas</h2>
                    <p class="text-gray-700 text-sm md:text-base font-medium">Arsip dokumen, SK, dan bukti fisik pendukung pelaksanaan ZI di FSTI.</p>
                </div>

                <div v-if="displayDocuments.length > 0" class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                    <a 
                        v-for="doc in displayDocuments" 
                        :key="doc.id" 
                        :href="doc.file_url" 
                        target="_blank"
                        class="relative flex flex-col sm:flex-row items-center sm:items-start md:items-center bg-white p-3 sm:p-4 md:p-6 rounded-xl md:rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-xl hover:border-primary transition-all duration-300 group overflow-hidden text-center sm:text-left h-full"
                    >
                        <div class="absolute left-0 top-0 bottom-0 w-1 md:w-1.5 bg-primary/50 group-hover:bg-primary transition-colors"></div>

                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 bg-primary/5 text-primary rounded-lg md:rounded-xl flex items-center justify-center mb-2 sm:mb-0 sm:mr-3 md:mr-5 group-hover:bg-primary group-hover:text-white transition-colors border border-primary/10">
                            <DocumentTextIcon class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7" />
                        </div>
                        <div class="flex-1 px-1 sm:px-0 sm:pr-2 flex flex-col justify-center">
                            <h3 class="text-[11px] sm:text-sm md:text-base font-bold text-primary leading-snug group-hover:text-primary/80 transition-colors line-clamp-2 mb-1.5 md:mb-0">
                                {{ doc.title }}
                            </h3>
                            <span class="inline-flex items-center justify-center sm:justify-start text-[9px] md:text-xs font-bold text-primary mt-auto md:mt-2 bg-primary/5 px-2 py-1 md:px-2.5 md:py-1 rounded-md group-hover:bg-primary group-hover:text-white transition-colors w-fit mx-auto sm:mx-0">
                                <ArrowDownTrayIcon class="w-3 h-3 md:w-3.5 md:h-3.5 mr-1 md:mr-1.5" /> <span class="hidden sm:inline">Lihat&nbsp;</span>Dokumen
                            </span>
                        </div>
                    </a>
                </div>

                <div v-else class="text-center bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-[1.5rem] md:rounded-3xl p-8 md:p-12 max-w-2xl mx-auto sm:mx-0">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-5">
                        <DocumentTextIcon class="w-8 h-8 md:w-10 md:h-10 text-gray-400" />
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">Belum Ada Dokumen Publikasi</h3>
                    <p class="text-xs md:text-sm text-gray-500 font-medium">Dokumen pendukung Zona Integritas FSTI sedang dalam tahap penyusunan dan akan segera dipublikasikan di sini.</p>
                </div>
            </div>
        </section>

        <section class="py-16 md:py-24 relative overflow-hidden bg-white font-public-sans">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 max-w-5xl">
                <div class="bg-gradient-to-br from-primary to-blue-700 rounded-[2rem] md:rounded-[2.5rem] p-8 md:p-12 lg:p-16 text-center text-white shadow-2xl relative overflow-hidden" data-aos="zoom-in">
                    
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3 pointer-events-none"></div>
                    <ShieldCheckIcon class="absolute -right-10 top-1/2 -translate-y-1/2 w-64 h-64 text-white opacity-[0.03] pointer-events-none" />
                    
                    <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-white/10 border border-white/20 backdrop-blur-md text-white rounded-full shadow-lg mb-6 relative z-10">
                        <GlobeAltIcon class="w-8 h-8 md:w-10 md:h-10" />
                    </div>
                    
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-optimus font-bold mb-6 leading-tight relative z-10">Portal Zona Integritas</h2>
                    
                    <p class="text-blue-100 text-base md:text-lg mb-10 max-w-3xl mx-auto relative z-10 font-medium leading-relaxed">
                        Untuk mengakses informasi yang lebih komprehensif, layanan pengaduan, survei, serta inovasi pelayanan publik terkait Zona Integritas, silakan kunjungi website terpisah khusus ZI FSTI ITK.
                    </p>
                    
                    <div class="flex justify-center relative z-10">
                        <a 
                            :href="profile?.external_website_url || '#'" 
                            :target="profile?.external_website_url ? '_blank' : null" 
                            :rel="profile?.external_website_url ? 'noopener noreferrer' : null"
                            class="px-8 py-4 bg-white text-primary font-bold rounded-xl hover:bg-gray-50 hover:-translate-y-1 hover:shadow-[0_10px_20px_-10px_rgba(255,255,255,0.5)] transition-all duration-300 flex items-center justify-center gap-2"
                        >
                            Kunjungi Website ZI FSTI <ArrowTopRightOnSquareIcon class="w-5 h-5" />
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>