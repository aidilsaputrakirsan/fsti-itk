<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

import { 
    Users, graduationCap, Building, Zap, Beaker, UserCheck, Briefcase, Network, Quote, DocumentText
} from 'lucide-vue-next';

defineProps({ tentang: Object });

// Mapping Ikon Dinamis berdasarkan Index Statistik
const getStatIcon = (index) => {
    const icons = [Users, graduationCap, Building, Zap, Beaker, Users, UserCheck, Network];
    return icons[index % icons.length];
};

// Animasi Count Up Sederhana
const countUpAnimation = (el, target, duration) => {
    let start = 0;
    const increment = target / (duration / 10);
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            el.innerText = target.toLocaleString('id-ID');
            clearInterval(timer);
        } else {
            el.innerText = Math.floor(start).toLocaleString('id-ID');
        }
    }, 10);
};

onMounted(() => {
    AOS.init({ duration: 1000, once: true });
    
    // Jalankan animasi count-up pada angka statistik
    document.querySelectorAll('.stat-number').forEach(el => {
        const target = parseInt(el.getAttribute('data-target').replace(/\./g, ''));
        if (!isNaN(target)) {
            countUpAnimation(el, target, 1500);
        }
    });
});
</script>

<template>
    <PublicLayout>
        <Head title="Tentang Fakultas" />
        <Banner title="TENTANG FAKULTAS" subtitle="PROFIL, TUGAS, FUNGSI, SERTA VISI & MISI FSTI ITK" background-image="/images/background-banner.png" />

        <section class="bg-white py-20 md:py-28 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-7xl">
                <div class="text-center mb-20" data-aos="fade-up">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-primary mb-4 leading-tight">Mengenal FSTI ITK</h2>
                    <p class="text-gray-600 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">{{ tentang?.statistik?.deskripsi }}</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8 mx-auto max-w-6xl">
                    <div v-for="(stat, index) in tentang?.statistik?.data" :key="index" class="bg-gray-50 rounded-3xl p-8 text-center border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden" data-aos="zoom-in" :data-aos-delay="index * 100">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-primary/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        <div class="relative z-10 flex flex-col items-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-3xl shadow-md text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-all duration-300 group-hover:scale-110">
                                <component :is="getStatIcon(index)" class="w-10 h-10" />
                            </div>
                            <h3 class="text-4xl md:text-5xl font-black text-gray-900 mb-2 stat-number" :data-target="stat.angka">0</h3>
                            <p class="text-base md:text-lg font-bold text-gray-500 uppercase tracking-widest leading-tight group-hover:text-primary transition-colors">{{ stat.label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white pb-16 font-public-sans border-t border-gray-100">
            <div class="relative py-16 md:py-28 overflow-hidden">
                <div class="absolute inset-y-0 left-0 w-[95%] bg-primary/10 rounded-r-[4rem] md:rounded-r-[6rem] z-0"></div>

                <div class="container mx-auto px-6 lg:px-8 max-w-7xl relative z-10">
                    <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                        
                        <div class="lg:col-span-5 lg:sticky lg:top-32" data-aos="fade-right">
                            <div class="w-16 h-1.5 bg-primary mb-6 rounded-full"></div>
                            <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-6 leading-tight">Tugas & Fungsi <br>Fakultas</h2>
                            <div class="bg-white p-8 rounded-3xl shadow-lg border border-white/50">
                                <h3 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-3">
                                    <DocumentTextIcon class="w-6 h-6 text-primary" /> Tugas Fakultas
                                </h3>
                                <p class="text-gray-700 leading-relaxed text-justify">{{ tentang?.tugas_fungsi?.tugas }}</p>
                            </div>
                        </div>

                        <div class="lg:col-span-7 space-y-6" data-aos="fade-left">
                            <div v-for="(fungsi, index) in tentang?.tugas_fungsi?.fungsi" :key="index" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-white/50 hover:shadow-xl hover:-translate-y-1 transition-all flex gap-5 items-start">
                                <div class="shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-primary/10 text-primary font-bold text-lg">{{ index + 1 }}</div>
                                <div>
                                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-2 leading-tight">{{ fungsi.judul }}</h4>
                                    <p class="text-gray-600 leading-relaxed">{{ fungsi.deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-16 md:py-28 font-public-sans border-t border-gray-200 relative overflow-hidden">
            <svg class="absolute bottom-0 left-0 w-full h-auto text-primary/5 opacity-50 z-0" viewBox="0 0 1440 320" fill="currentColor">
                <path d="M0,224L48,224C96,224,192,224,288,197.3C384,171,480,117,576,90.7C672,64,768,64,864,80C960,96,1056,128,1152,128C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>

            <div class="container mx-auto px-6 lg:px-8 max-w-6xl relative z-10">
                
                <div class="text-center max-w-5xl mx-auto mb-24 md:mb-28" data-aos="fade-up">
                    <span class="inline-block py-2 px-5 rounded-full bg-primary/10 text-primary font-bold text-sm tracking-widest uppercase mb-8">Visi Fakultas</span>
                    
                    <div class="bg-gradient-to-tr from-primary to-[#133E87] rounded-[3rem] p-12 md:p-16 shadow-2xl relative overflow-hidden group">
                        <Quote class="absolute -top-10 -left-10 text-white/10 w-52 h-52 group-hover:scale-125 transition-transform duration-500" />
                        <Quote class="absolute -bottom-10 -right-10 text-white/10 w-52 h-52 transform rotate-180 group-hover:scale-125 transition-transform duration-500" />
                        
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-white leading-normal md:leading-relaxed drop-shadow-md relative z-10">
                            "{{ tentang?.visi_misi?.visi }}"
                        </h2>
                    </div>
                </div>

                <div class="mb-16 text-center" data-aos="fade-up">
                    <span class="inline-block py-2 px-5 rounded-full bg-primary/10 text-primary font-bold text-sm tracking-widest uppercase mb-5">Misi Fakultas</span>
                    <h2 class="text-3xl md:text-5xl font-black font-optimus text-primary tracking-widest leading-tight">{{ tentang?.visi_misi?.misi_tagline }}</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="(item, index) in tentang?.visi_misi?.misi" :key="index" class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:border-primary/40 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group" data-aos="fade-up" :data-aos-delay="index * 80">
                        <div class="absolute -right-4 -bottom-8 text-9xl font-black text-gray-50 group-hover:text-primary/10 transition-colors duration-500 select-none pointer-events-none">{{ item.huruf }}</div>
                        
                        <div class="relative z-10 flex flex-col h-full items-start">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-primary flex items-center justify-center font-bold text-2xl mb-5 group-hover:bg-primary group-hover:text-white transition-colors">
                                {{ item.huruf }}
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 leading-snug">{{ item.teks }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>