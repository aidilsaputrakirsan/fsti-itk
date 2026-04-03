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

// Data Jalur Masuk (Rangkuman Pmb.itk.ac.id)
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
            background-image="/images/background-banner.png"
        />

        <div class="bg-white py-16 md:py-24 font-public-sans min-h-screen overflow-hidden">
            
            <div class="relative w-full mb-32 pt-10 flex flex-col md:flex-row items-center container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
                
                <div class="absolute top-0 right-0 w-3/4 h-[120%] bg-gradient-to-bl from-[#D9FFFE]/60 to-transparent -skew-x-12 translate-x-20 rounded-[80px] pointer-events-none"></div>
                <div class="absolute -bottom-10 left-0 w-1/2 h-1/2 bg-gradient-to-tr from-[#00509D]/10 to-transparent skew-y-6 -translate-x-10 rounded-[60px] pointer-events-none"></div>
                
                <div class="relative z-10 w-full md:w-3/5 pr-0 md:pr-12" data-aos="fade-right">
                    
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm bg-[#003566] text-[#D9FFFE] text-xs font-bold mb-8 uppercase tracking-widest shadow-md">
                        <Users class="w-4 h-4" /> Informasi Penerimaan Mahasiswa Baru
                    </div>
                    
                    <h2 class="text-4xl md:text-6xl font-optimus font-bold mb-6 leading-[1.1] text-[#003566]">
                        Wujudkan Mimpimu di<br/>
                        <span class="text-primary drop-shadow-sm">Bidang Sains & Teknologi</span>
                    </h2>
                    
                    <div class="w-20 h-1.5 bg-[#00509D] mb-8 rounded-full"></div>
                    
                    <p class="text-slate-600 md:text-lg leading-relaxed max-w-2xl font-light">
FSTI ITK membuka kesempatan buat kamu yang ingin berkembang di dunia sains dan teknologi, dengan lingkungan belajar yang aktif dan inovatif.                    </p>
                </div>

                <div class="relative z-10 w-full md:w-2/5 mt-16 md:mt-0 flex justify-center group" data-aos="fade-left">
                    <div class="relative w-72 h-72 md:w-80 md:h-80">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#D9FFFE] to-[#00509D]/10 border border-white rotate-12 rounded-tl-[60px] rounded-br-[60px] rounded-tr-2xl rounded-bl-2xl shadow-lg transform group-hover:rotate-6 transition-transform duration-700"></div>
                        
                        <div class="absolute inset-0 bg-gradient-to-tl from-[#003566] to-[#00509D] -rotate-6 rounded-tl-[60px] rounded-br-[60px] rounded-tr-2xl rounded-bl-2xl shadow-2xl flex items-center justify-center transform group-hover:rotate-0 transition-transform duration-700 overflow-hidden">
                            <div class="absolute inset-0 bg-[url('/images/pattern-prestasi.png')] opacity-10"></div>
                            <GraduationCap class="w-32 h-32 text-[#D9FFFE] drop-shadow-xl group-hover:scale-110 transition-transform duration-500 relative z-10" stroke-width="1.2" />
                        </div>
                        
                        <div class="absolute -top-6 -right-6 w-16 h-16 border-[3px] border-[#00509D]/50 rounded-full opacity-60"></div>
                        <div class="absolute -bottom-4 -left-8 w-10 h-10 border-[3px] border-[#D9FFFE] bg-[#00509D]/20 backdrop-blur-sm rotate-45 rounded-md animate-bounce" style="animation-duration: 3s;"></div>
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="mb-24">
                    <div class="text-center mb-16" data-aos="fade-up">
                        <h3 class="text-sm font-bold tracking-widest text-primary uppercase mb-3">Informasi Seleksi</h3>
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-[#003566]">Jalur Penerimaan Mahasiswa Baru</h2>
                        <div class="w-24 h-1.5 bg-primary mx-auto mt-6 rounded-full opacity-80"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div 
                            v-for="(jalur, index) in jalurMasuk" 
                            :key="index"
                            class="bg-white rounded-tl-3xl rounded-br-3xl rounded-tr-lg rounded-bl-lg p-8 md:p-10 border border-slate-100 shadow-sm hover:shadow-[0_15px_40px_rgba(0,53,102,0.08)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden group"
                            data-aos="fade-up"
                            :data-aos-delay="index * 150"
                        >
                            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r opacity-90" :class="jalur.color"></div>
                            
                            <div class="w-16 h-16 rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm mb-8 flex items-center justify-center text-white bg-gradient-to-br shadow-md group-hover:scale-110 transition-transform duration-500" :class="jalur.iconBg">
                                <component :is="jalur.icon" class="w-8 h-8" stroke-width="1.5" />
                            </div>
                            
                            <h3 class="text-2xl font-bold mb-2 transition-colors" :class="jalur.textColor">{{ jalur.title }}</h3>
                            <p class="text-[10px] font-black tracking-widest text-slate-400 uppercase mb-6">{{ jalur.kepanjangan }}</p>
                            
                            <p class="text-slate-600 text-sm leading-relaxed text-justify">
                                {{ jalur.desc }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-[#003566] via-[#00509D] to-[#003566] rounded-tl-[80px] rounded-br-[80px] rounded-tr-2xl rounded-bl-2xl overflow-hidden shadow-[0_20px_50px_rgba(0,53,102,0.2)] flex flex-col md:flex-row items-center border border-white/10 relative" data-aos="zoom-in">
                    
                    <div class="absolute inset-0 bg-[url('/images/pattern-prestasi.png')] opacity-10 pointer-events-none"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#D9FFFE]/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="p-10 md:p-16 text-white md:w-3/5 flex flex-col justify-center relative z-10">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="px-4 py-1.5 bg-[#FDC500] text-[#003566] text-[10px] font-black uppercase tracking-widest rounded-tl-lg rounded-br-lg shadow-sm">Pusat Informasi PMB ITK</span>
                        </div>
                        
                        <h3 class="text-3xl lg:text-4xl font-optimus font-bold mb-6 leading-tight drop-shadow-sm text-white">Cek Jadwal & Syarat PMB ITK </h3>
                        <p class="text-[#D9FFFE] text-base leading-relaxed mb-10 max-w-xl font-light opacity-90">
                            Seluruh informasi mengenai daya tampung, biaya pendidikan (UKT), kalender akademik, dan panduan teknis pendaftaran dikelola terpusat melalui portal Penerimaan Mahasiswa Baru Institut Teknologi Kalimantan.
                        </p>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="https://pmb.itk.ac.id/" target="_blank" class="px-8 py-4 bg-white hover:bg-[#D9FFFE] text-primary font-black rounded-tl-2xl rounded-br-2xl rounded-tr-md rounded-bl-md flex items-center transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5 group w-full sm:w-auto">
                               Lihat Selengkapnya <ExternalLink class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" />
                            </a>
                        </div>
                    </div>

                    <div class="md:w-2/5 bg-white/5 p-10 w-full h-full flex items-center justify-center relative min-h-[350px] z-10 backdrop-blur-sm border-l border-white/10">
                         <div class="relative bg-white rounded-tl-[40px] rounded-br-[40px] rounded-tr-lg rounded-bl-lg shadow-2xl overflow-hidden transform -rotate-6 hover:rotate-0 transition-transform duration-500 w-full max-w-[250px] border-[6px] border-white/90 flex flex-col">
                             <div class="bg-gradient-to-r from-[#FDC500] to-[#FFDF3A] p-6 text-center text-[#003566] h-32 flex flex-col items-center justify-center">
                                 <Laptop class="w-8 h-8 mb-2 opacity-90" stroke-width="1.5" />
                                 <h4 class="font-optimus font-bold text-xl">PMB ITK</h4>
                             </div>
                             <div class="p-6 bg-slate-50 flex flex-col gap-4 flex-grow">
                                 <div class="h-2 bg-slate-200 rounded-full w-full"></div>
                                 <div class="h-2 bg-slate-200 rounded-full w-5/6"></div>
                                 <div class="h-2 bg-slate-200 rounded-full w-4/6 mb-3"></div>
                                 <div class="grid grid-cols-2 gap-2 mt-auto">
                                     <div class="h-8 bg-[#D9FFFE] rounded-md"></div>
                                     <div class="h-8 bg-slate-200 rounded-md"></div>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>