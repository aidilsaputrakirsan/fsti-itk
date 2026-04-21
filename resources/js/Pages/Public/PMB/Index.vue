<script setup>
import { onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { 
    GraduationCap, 
    Target, 
    ExternalLink,
    Users,
    Laptop,
    Award
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});

const jalurMasuk = [
    {
        title: 'SNBP',
        kepanjangan: 'Seleksi Nasional Berdasarkan Prestasi',
        desc: 'Jalur seleksi nasional tanpa tes tertulis. Penilaian difokuskan pada penelusuran prestasi akademik (nilai rapor) dan non-akademik bagi siswa yang eligible dari sekolah.',
        color: 'from-[#00509D] to-[#D9FFFE]',
        iconBg: 'from-[#00509D] to-[#003566]',
        textColor: 'text-[#00509D]',
        icon: Award
    },
    {
        title: 'SNBT',
        kepanjangan: 'Seleksi Nasional Berdasarkan Tes',
        desc: 'Jalur seleksi nasional berbasis Ujian Tulis Berbasis Komputer (UTBK). Materi yang diujikan meliputi Tes Potensi Skolastik (TPS), Penalaran Matematika, dan Literasi.',
        color: 'from-[#FDC500] to-[#FFDF3A]',
        iconBg: 'from-[#FDC500] to-[#FFDF3A]',
        textColor: 'text-[#FDC500]',
        icon: Laptop
    },
    {
        title: 'SUMMIT ITK',
        kepanjangan: 'Seleksi Ujian Masuk Mandiri Terpadu',
        desc: 'Jalur seleksi mandiri resmi ITK yang terdiri dari Jalur Reguler dan Kemitraan. Calon mahasiswa dapat menggunakan sertifikat UTBK atau menggunakan nilai rapor/prestasi.',
        color: 'from-[#003566] to-[#00509D]',
        iconBg: 'from-[#003566] to-[#00509D]',
        textColor: 'text-[#003566]',
        icon: Target
    }
];
</script>

<template>
    <PublicLayout>
        <Head title="Penerimaan Mahasiswa Baru" />
        
        <Banner
            title="PENERIMAAN MAHASISWA BARU"
            subtitle="Jadilah Bagian dari Inovator Masa Depan di FSTI ITK"
            background-image="/images/background-banner.webp"
        />

        <div class="bg-white py-12 md:py-24 font-public-sans min-h-screen overflow-hidden">
            
            <div class="relative w-full mb-16 md:mb-32 pt-6 md:pt-10 flex flex-col md:flex-row items-center container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                
                <div class="absolute top-0 right-0 w-full md:w-3/4 h-[120%] bg-gradient-to-bl from-[#D9FFFE]/60 to-transparent -skew-x-12 translate-x-10 md:translate-x-20 rounded-[40px] md:rounded-[80px] pointer-events-none"></div>
                <div class="absolute -bottom-10 left-0 w-full md:w-1/2 h-1/2 bg-gradient-to-tr from-[#00509D]/10 to-transparent skew-y-6 -translate-x-10 rounded-[40px] md:rounded-[60px] pointer-events-none"></div>
                
                <div class="relative z-10 w-full md:w-3/5 pr-0 md:pr-12 text-center md:text-left" data-aos="fade-right">
                    
                    <div class="inline-flex items-center gap-2 px-4 py-2 md:px-5 md:py-2.5 rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm bg-[#003566] text-[#D9FFFE] text-[10px] md:text-xs font-bold mb-6 md:mb-8 uppercase tracking-widest shadow-md mx-auto md:mx-0">
                        <Users class="w-3.5 h-3.5 md:w-4 md:h-4" /> Informasi Penerimaan Mahasiswa Baru
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-optimus font-bold mb-4 md:mb-6 leading-[1.2] md:leading-[1.1] text-[#003566]">
                        Wujudkan Mimpimu di<br class="hidden sm:block"/>
                        <span class="text-primary drop-shadow-sm">Bidang Sains & Teknologi</span>
                    </h2>
                    
                    <div class="w-16 md:w-20 h-1.5 bg-[#00509D] mb-6 md:mb-8 rounded-full mx-auto md:mx-0"></div>
                    
                    <p class="text-slate-600 text-sm sm:text-base md:text-lg leading-relaxed max-w-2xl font-light mx-auto md:mx-0">
                        FSTI ITK membuka kesempatan buat kamu yang ingin berkembang di dunia sains dan teknologi, dengan lingkungan belajar yang aktif dan inovatif.
                    </p>
                </div>

                <div class="relative z-10 w-full md:w-2/5 mt-12 md:mt-0 flex justify-center group" data-aos="fade-left">
                    <div class="relative w-56 h-56 sm:w-72 sm:h-72 md:w-80 md:h-80">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#D9FFFE] to-[#00509D]/10 border border-white rotate-12 rounded-tl-[40px] md:rounded-tl-[60px] rounded-br-[40px] md:rounded-br-[60px] rounded-tr-xl md:rounded-tr-2xl rounded-bl-xl md:rounded-bl-2xl shadow-lg transform group-hover:rotate-6 transition-transform duration-700"></div>
                        
                        <div class="absolute inset-0 bg-gradient-to-tl from-[#003566] to-[#00509D] -rotate-6 rounded-tl-[40px] md:rounded-tl-[60px] rounded-br-[40px] md:rounded-br-[60px] rounded-tr-xl md:rounded-tr-2xl rounded-bl-xl md:rounded-bl-2xl shadow-2xl flex items-center justify-center transform group-hover:rotate-0 transition-transform duration-700 overflow-hidden">
                            <div class="absolute inset-0 bg-[url('/images/pattern-prestasi.webp')] opacity-10"></div>
                            <GraduationCap class="w-24 h-24 sm:w-32 sm:h-32 text-[#D9FFFE] drop-shadow-xl group-hover:scale-110 transition-transform duration-500 relative z-10" stroke-width="1.2" />
                        </div>
                        
                        <div class="absolute -top-4 -right-4 md:-top-6 md:-right-6 w-12 h-12 md:w-16 md:h-16 border-[3px] border-[#00509D]/50 rounded-full opacity-60"></div>
                        <div class="absolute -bottom-3 -left-6 md:-bottom-4 md:-left-8 w-8 h-8 md:w-10 md:h-10 border-[3px] border-[#D9FFFE] bg-[#00509D]/20 backdrop-blur-sm rotate-45 rounded-md animate-bounce" style="animation-duration: 3s;"></div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="mb-16 md:mb-24">
                    <div class="text-center mb-10 md:mb-16" data-aos="fade-up">
                        <h3 class="text-xs md:text-sm font-bold tracking-widest text-primary uppercase mb-2 md:mb-3">Informasi Seleksi</h3>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-optimus font-bold text-[#003566] px-4">Jalur Penerimaan Mahasiswa Baru</h2>
                        <div class="w-16 md:w-24 h-1.5 bg-primary mx-auto mt-4 md:mt-6 rounded-full opacity-80"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                        <div 
                            v-for="(jalur, index) in jalurMasuk" 
                            :key="index"
                            class="bg-white rounded-tl-2xl md:rounded-tl-3xl rounded-br-2xl md:rounded-br-3xl rounded-tr-lg rounded-bl-lg p-6 sm:p-8 md:p-10 border border-slate-100 shadow-sm hover:shadow-[0_15px_40px_rgba(0,53,102,0.08)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden group"
                            data-aos="fade-up"
                            :data-aos-delay="index * 150"
                        >
                            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r opacity-90" :class="jalur.color"></div>
                            
                            <div class="w-14 h-14 md:w-16 md:h-16 rounded-tl-xl md:rounded-tl-2xl rounded-br-xl md:rounded-br-2xl rounded-tr-sm rounded-bl-sm mb-6 md:mb-8 flex items-center justify-center text-white bg-gradient-to-br shadow-md group-hover:scale-110 transition-transform duration-500" :class="jalur.iconBg">
                                <component :is="jalur.icon" class="w-6 h-6 md:w-8 md:h-8" stroke-width="1.5" />
                            </div>
                            
                            <h3 class="text-xl md:text-2xl font-bold mb-1.5 md:mb-2 transition-colors" :class="jalur.textColor">{{ jalur.title }}</h3>
                            <p class="text-[9px] md:text-[10px] font-black tracking-widest text-slate-400 uppercase mb-4 md:mb-6 line-clamp-1">{{ jalur.kepanjangan }}</p>
                            
                            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed text-justify">
                                {{ jalur.desc }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#003566] via-[#00509D] to-[#003566] rounded-tl-[40px] md:rounded-tl-[80px] rounded-br-[40px] md:rounded-br-[80px] rounded-tr-xl md:rounded-tr-2xl rounded-bl-xl md:rounded-bl-2xl overflow-hidden shadow-[0_20px_50px_rgba(0,53,102,0.2)] flex flex-col md:flex-row items-center border border-white/10 relative" data-aos="zoom-in">
                    
                    <div class="absolute inset-0 bg-[url('/images/pattern-prestasi.webp')] opacity-10 pointer-events-none"></div>
                    <div class="absolute top-0 right-0 w-48 h-48 md:w-64 md:h-64 bg-[#D9FFFE]/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="p-8 sm:p-10 md:p-16 text-white w-full md:w-3/5 flex flex-col justify-center relative z-10 text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-2 mb-4 md:mb-6">
                            <span class="px-3 py-1 md:px-4 md:py-1.5 bg-[#FDC500] text-[#003566] text-[9px] md:text-[10px] font-black uppercase tracking-widest rounded-tl-lg rounded-br-lg shadow-sm">Pusat Informasi PMB ITK</span>
                        </div>
                        
                        <h3 class="text-2xl sm:text-3xl lg:text-4xl font-optimus font-bold mb-4 md:mb-6 leading-tight drop-shadow-sm text-white">Cek Jadwal & Syarat PMB ITK </h3>
                        
                        <p class="text-[#D9FFFE] text-sm md:text-base leading-relaxed mb-8 md:mb-10 max-w-xl mx-auto md:mx-0 font-light opacity-90">
                            Seluruh informasi mengenai daya tampung, biaya pendidikan (UKT), kalender akademik, dan panduan teknis pendaftaran dikelola terpusat melalui portal Penerimaan Mahasiswa Baru Institut Teknologi Kalimantan.
                        </p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4">
                            <a :href="$page.props.faculty_settings?.pmb_link || 'https://pmb.itk.ac.id/'" target="_blank" class="px-6 py-3.5 md:px-8 md:py-4 bg-white hover:bg-[#D9FFFE] text-primary font-black rounded-tl-2xl rounded-br-2xl rounded-tr-md rounded-bl-md flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 group w-full sm:w-auto text-sm md:text-base">
                               Lihat Selengkapnya <ExternalLink class="w-4 h-4 md:w-5 md:h-5 ml-2 md:ml-3 group-hover:translate-x-1 transition-transform" />
                            </a>
                        </div>
                    </div>

                    <div class="w-full md:w-2/5 bg-white/5 p-8 md:p-10 flex items-center justify-center relative min-h-[300px] md:min-h-[350px] z-10 backdrop-blur-sm border-t md:border-t-0 md:border-l border-white/10">
                         <div class="relative bg-white rounded-tl-[30px] md:rounded-tl-[40px] rounded-br-[30px] md:rounded-br-[40px] rounded-tr-lg rounded-bl-lg shadow-2xl overflow-hidden transform -rotate-3 md:-rotate-6 hover:rotate-0 transition-transform duration-500 w-full max-w-[220px] md:max-w-[250px] border-[5px] md:border-[6px] border-white/90 flex flex-col">
                             <div class="bg-gradient-to-r from-[#FDC500] to-[#FFDF3A] p-4 md:p-6 text-center text-[#003566] h-24 md:h-32 flex flex-col items-center justify-center">
                                 <Laptop class="w-6 h-6 md:w-8 md:h-8 mb-1 md:mb-2 opacity-90" stroke-width="1.5" />
                                 <h4 class="font-optimus font-bold text-lg md:text-xl">PMB ITK</h4>
                             </div>
                             <div class="p-5 md:p-6 bg-slate-50 flex flex-col gap-3 md:gap-4 flex-grow">
                                 <div class="h-1.5 md:h-2 bg-slate-200 rounded-full w-full"></div>
                                 <div class="h-1.5 md:h-2 bg-slate-200 rounded-full w-5/6"></div>
                                 <div class="h-1.5 md:h-2 bg-slate-200 rounded-full w-4/6 mb-2 md:mb-3"></div>
                                 <div class="grid grid-cols-2 gap-2 mt-auto">
                                     <div class="h-6 md:h-8 bg-[#D9FFFE] rounded-md"></div>
                                     <div class="h-6 md:h-8 bg-slate-200 rounded-md"></div>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>