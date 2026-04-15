<script setup>
import { onMounted, computed } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { 
    Users,
    Briefcase,
    LineChart,
    Building2,
    BookOpen,
    ExternalLink
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});

const surveyUrl = 'https://docs.google.com/forms/d/e/1FAIpQLSe09s1JB6Sm4005NakxU9uNVnLyGBEiIEv8oSO2EdLG81LIeA/viewform';

const embedUrl = computed(() => {
    if (surveyUrl.includes('docs.google.com/forms') && !surveyUrl.includes('embedded=true')) {
        return surveyUrl.includes('?') ? `${surveyUrl}&embedded=true` : `${surveyUrl}?embedded=true`;
    }
    return surveyUrl;
});

const benefits = [
    {
        title: 'Evaluasi Kurikulum',
        desc: 'Membantu FSTI dalam mengevaluasi dan menyesuaikan kurikulum agar selalu relevan dengan kebutuhan industri saat ini.',
        icon: BookOpen
    },
    {
        title: 'Akreditasi Program Studi',
        desc: 'Data partisipasi alumni sangat krusial dalam pemeringkatan dan akreditasi Program Studi di lingkungan FSTI.',
        icon: LineChart
    },
    {
        title: 'Pemetaan Karir',
        desc: 'Memberikan gambaran komprehensif mengenai serapan lulusan di dunia kerja maupun studi lanjut.',
        icon: Building2
    }
];
</script>

<template>
    <PublicLayout>
        <Head title="Tracer Study Alumni" />
        
        <Banner
            title="TRACER STUDY ALUMNI"
            subtitle="Bantu Kami Meningkatkan Kualitas Pendidikan FSTI ITK"
            background-image="/images/background-banner.webp"
        />

        <div class="bg-white py-16 md:py-24 font-public-sans min-h-screen overflow-hidden">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full mb-20 pt-10 flex flex-col md:flex-row items-center" data-aos="fade-down">
                    
                    <div class="absolute top-0 right-0 w-3/4 h-[120%] bg-gradient-to-bl from-[#D9FFFE]/60 to-transparent -skew-x-12 translate-x-20 rounded-[80px] pointer-events-none"></div>
                    <div class="absolute -bottom-10 left-0 w-1/2 h-1/2 bg-gradient-to-tr from-[#00509D]/5 to-transparent skew-y-6 -translate-x-10 rounded-[60px] pointer-events-none"></div>
                    
                    <div class="relative z-10 w-full md:w-1/2 pr-0 md:pr-12 text-center md:text-left flex flex-col items-center md:items-start">
                        <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-tl-2xl rounded-br-2xl rounded-tr-sm rounded-bl-sm bg-[#003566] text-[#D9FFFE] text-xs font-bold mb-8 uppercase tracking-widest shadow-md">
                            <Users class="w-4 h-4" /> Tracer Study FSTI
                        </div>
                        
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-optimus font-bold mb-6 leading-[1.1] text-[#003566]">
                            Isi Tracer Study<br/>
                            <span class="text-[#00509D] drop-shadow-sm">Dukung FSTI</span>
                        </h2>
                        
                        <div class="w-20 h-1.5 bg-[#00509D] mb-8 rounded-full"></div>
                        
                        <p class="text-slate-600 md:text-lg leading-relaxed max-w-xl font-light">
                            Tracer Study adalah pelacakan jejak lulusan untuk mengetahui masa transisi dari dunia kampus menuju dunia kerja. Partisipasi Anda sangat berarti bagi pengembangan kurikulum almamater.
                        </p>
                    </div>

                    <div class="relative z-10 w-full md:w-1/2 mt-16 md:mt-0 flex justify-center group">
                        <div class="relative w-72 h-72 md:w-96 md:h-96">
                            <div class="absolute inset-0 bg-transparent border-[3px] border-[#D9FFFE] rotate-6 rounded-tl-[60px] rounded-br-[60px] rounded-tr-2xl rounded-bl-2xl transform group-hover:rotate-12 transition-transform duration-700"></div>
                            
                            <div class="absolute inset-0 bg-gradient-to-tl from-[#003566] to-[#00509D] -rotate-3 rounded-tl-[60px] rounded-br-[60px] rounded-tr-2xl rounded-bl-2xl shadow-2xl flex items-center justify-center transform group-hover:rotate-0 transition-transform duration-700 overflow-hidden">
                                <div class="absolute inset-0 bg-[url('/images/pattern-prestasi.webp')] opacity-10"></div>
                                <Briefcase class="w-32 h-32 md:w-40 md:h-40 text-[#D9FFFE] drop-shadow-xl group-hover:scale-110 transition-transform duration-500 relative z-10" stroke-width="1.2" />
                            </div>
                            
                            <div class="absolute -top-4 -right-4 w-12 h-12 border-[2px] border-[#00509D]/50 rounded-full opacity-60"></div>
                            <div class="absolute -bottom-6 -left-6 w-14 h-14 border-[2px] border-[#00509D]/30 rotate-12 rounded-md animate-bounce" style="animation-duration: 4s;"></div>
                        </div>
                    </div>
                </div>

                <div class="mb-24 relative z-20" data-aos="fade-up">
                    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,53,102,0.08)] border border-slate-100 overflow-hidden">
                        
                        <div class="bg-gradient-to-r from-[#003566] to-[#00509D] px-8 py-6 flex flex-col sm:flex-row items-center justify-between">
                            <div class="w-full text-center sm:text-left">
                                <h3 class="text-2xl font-optimus font-bold text-white flex items-center justify-center sm:justify-start gap-3">
                                    <Briefcase class="w-6 h-6 text-[#FDC500]" /> 
                                    Formulir Tracer Study
                                </h3>
                                <p class="text-[#D9FFFE] text-sm mt-1 opacity-90">Silakan isi kuesioner langsung pada formulir di bawah ini.</p>
                            </div>
                        </div>
                        
                        <div class="w-full bg-slate-50 p-4 md:p-8 flex flex-col items-center">
                            
                            <div class="w-full max-w-4xl bg-white rounded-2xl shadow-inner overflow-hidden border border-slate-200">
                                <iframe 
                                    :src="embedUrl" 
                                    class="w-full h-[800px] border-0"
                                    title="Tracer Study Google Form"
                                    allowfullscreen
                                >
                                    Memuat Formulir...
                                </iframe>
                            </div>

                            <div class="mt-8 flex justify-center w-full">
                                <a :href="surveyUrl" target="_blank" class="px-8 py-3.5 bg-white text-[#003566] border border-slate-200 hover:border-[#00509D]/30 shadow-[0_4px_15px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_25px_rgba(0,0,0,0.08)] hover:bg-slate-50 text-sm font-bold tracking-wide rounded-xl flex items-center transition-all hover:-translate-y-0.5 group">
                                    Buka di Tab Baru <ExternalLink class="w-5 h-5 ml-2 text-[#00509D] group-hover:text-[#FDC500] transition-colors" />
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mb-10">
                    <div class="text-center mb-16" data-aos="fade-up">
                        <h3 class="text-sm font-bold tracking-widest text-[#00509D] uppercase mb-3">Tujuan Pelaksanaan</h3>
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-[#003566]">Mengapa Tracer Study Penting?</h2>
                        <div class="w-24 h-1.5 bg-[#00509D] mx-auto mt-6 rounded-full opacity-80"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div 
                            v-for="(benefit, index) in benefits" 
                            :key="index"
                            class="bg-white rounded-tl-3xl rounded-br-3xl rounded-tr-lg rounded-bl-lg p-8 border border-slate-100 shadow-sm hover:shadow-[0_15px_40px_rgba(0,53,102,0.06)] hover:-translate-y-2 transition-all duration-500 relative overflow-hidden group"
                            data-aos="fade-up"
                            :data-aos-delay="index * 150"
                        >
                            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#00509D] to-[#D9FFFE] opacity-90"></div>
                            
                            <div class="w-14 h-14 rounded-tl-xl rounded-br-xl rounded-tr-sm rounded-bl-sm mb-6 flex items-center justify-center text-white bg-gradient-to-br from-[#00509D] to-[#003566] shadow-md group-hover:scale-110 transition-transform duration-500">
                                <component :is="benefit.icon" class="w-6 h-6" stroke-width="1.5" />
                            </div>
                            
                            <h3 class="text-xl font-bold mb-3 text-[#003566] group-hover:text-[#00509D] transition-colors">{{ benefit.title }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ benefit.desc }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>