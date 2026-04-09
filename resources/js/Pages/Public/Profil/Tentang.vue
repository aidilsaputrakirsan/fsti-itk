<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, computed, nextTick } from 'vue'; 
import AOS from 'aos';
import 'aos/dist/aos.css';

import { 
    Users, GraduationCap, Building, Zap, Beaker, UserCheck, Briefcase, Network, Quote, FileText, Globe, Cpu, Code
} from 'lucide-vue-next';

const props = defineProps({ 
    tentang: Object,
    statistik: Object 
});

const displayStats = computed(() => {
    const cmsData = props.tentang?.statistik?.data || [];

    return cmsData.map(stat => {
        const labelLower = stat.label.toLowerCase();
        
        if (labelLower.includes('dosen')) {
            return { ...stat, angka: props.statistik?.dosen ?? stat.angka };
        }
        if (labelLower.includes('tendik') || labelLower.includes('kependidikan')) {
            return { ...stat, angka: props.statistik?.tendik ?? stat.angka };
        }
        if (labelLower.includes('s1')) {
            return { ...stat, angka: props.statistik?.prodi_s1 ?? stat.angka };
        }
        if (labelLower.includes('s2') || labelLower.includes('magister')) {
            return { ...stat, angka: props.statistik?.prodi_s2 ?? stat.angka };
        }
        if (labelLower.includes('prodi') || labelLower.includes('program studi')) {
            return { ...stat, angka: props.statistik?.prodi_total ?? stat.angka };
        }
        
        return stat; 
    });
});

const getStatIcon = (index) => {
    const icons = [Users, GraduationCap, Building, Zap, Beaker, Users, UserCheck, Network];
    return icons[index % icons.length];
};

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
    AOS.init({ duration: 800, once: true });
    
    nextTick(() => {
        setTimeout(() => {
            document.querySelectorAll('.stat-number').forEach(el => {
                const targetText = el.getAttribute('data-target') || '0';
                const target = parseInt(targetText.replace(/\./g, ''));
                if (!isNaN(target)) {
                    countUpAnimation(el, target, 1500);
                }
            });
        }, 100);
    });
});
</script>

<template>
    <PublicLayout>
        <Head title="Tentang Fakultas" />
        <Banner title="TENTANG FAKULTAS" subtitle="PROFIL, TUGAS, FUNGSI, SERTA VISI & MISI FSTI ITK" background-image="/images/background-banner.png" />

        <section class="bg-white py-16 md:py-24 font-public-sans border-b border-gray-100 relative overflow-hidden">
            <Globe class="absolute -top-16 -left-16 w-64 h-64 text-primary/5 -rotate-12 pointer-events-none" />
            <Cpu class="absolute -bottom-10 -right-10 w-48 h-48 text-primary/5 rotate-12 pointer-events-none" />
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] bg-primary/5 rounded-full blur-3xl opacity-40 pointer-events-none"></div>

            <div class="container mx-auto px-6 lg:px-8 max-w-7xl relative z-10">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-4 tracking-tight">Mengenal FSTI ITK</h2>
                    <div class="w-16 h-1 bg-primary mx-auto mb-5 rounded-full opacity-50"></div>
                    <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto leading-relaxed">{{ tentang?.statistik?.deskripsi }}</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mx-auto max-w-7xl">
                    <div v-for="(stat, index) in displayStats" :key="index" class="bg-white rounded-2xl p-6 text-center border-t-4 border-transparent hover:border-t-primary border border-x-gray-100 border-b-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-300 group" data-aos="zoom-in" :data-aos-delay="index * 40">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-50/50 rounded-xl text-primary mb-5 group-hover:bg-primary group-hover:text-white group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <component :is="getStatIcon(index)" class="w-6 h-6" />
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-1 stat-number drop-shadow-sm" :data-target="stat.angka">0</h3>
                        <p class="text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-widest group-hover:text-primary transition-colors leading-tight">{{ stat.label }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-primary/10 py-16 md:py-24 font-public-sans border-y border-white relative overflow-hidden">
            <div class="container mx-auto px-6 lg:px-8 max-w-7xl relative z-10">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">
                    
                    <div class="lg:col-span-5 lg:sticky lg:top-32" data-aos="fade-right">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-primary text-white rounded-2xl mb-6 shadow-lg shadow-primary/30">
                            <Code class="w-7 h-7" />
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-6 leading-tight">Tugas & Fungsi <br>Fakultas</h2>
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-md border-l-4 border-primary">
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                                <FileText class="w-6 h-6 text-primary" /> Tugas Pokok
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-justify font-medium">{{ tentang?.tugas_fungsi?.tugas }}</p>
                        </div>
                    </div>

                    <div class="lg:col-span-7 space-y-5" data-aos="fade-left">
                        <div v-for="(fungsi, index) in tentang?.tugas_fungsi?.fungsi" :key="index" class="bg-white p-5 md:p-7 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:shadow-blue-900/5 hover:-translate-x-2 transition-all duration-300 flex gap-5 items-start group relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-primary to-blue-300 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="shrink-0 flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 text-primary font-black text-lg group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-inner">
                                {{ index + 1 }}
                            </div>
                            <div>
                                <h4 class="text-base md:text-lg font-bold text-gray-900 mb-2 leading-tight group-hover:text-primary transition-colors">{{ fungsi.judul }}</h4>
                                <p class="text-gray-500 text-sm md:text-base leading-relaxed">{{ fungsi.deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 py-16 md:py-24 relative overflow-hidden">
            <svg class="absolute bottom-0 left-0 w-full h-auto text-white z-0" viewBox="0 0 1440 320" fill="currentColor">
                <path d="M0,224L48,224C96,224,192,224,288,197.3C384,171,480,117,576,90.7C672,64,768,64,864,80C960,96,1056,128,1152,128C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>

            <div class="container mx-auto px-6 lg:px-8 max-w-6xl relative z-10">
                
                <div class="text-center max-w-4xl mx-auto mb-20" data-aos="fade-up">
                    <span class="inline-block py-1.5 px-6 rounded-full bg-blue-50 text-primary font-bold text-sm tracking-widest uppercase mb-8 border border-blue-100 font-optimus shadow-sm">Visi Fakultas</span>
                    
                    <div class="bg-gradient-to-br from-primary via-[#0f346e] to-[#0A2A5E] rounded-[2rem] p-10 md:p-14 shadow-2xl relative overflow-hidden group">
                        <div class="absolute top-4 right-8 w-2 h-2 bg-yellow-300 rounded-full animate-ping"></div>
                        <div class="absolute bottom-10 left-10 w-3 h-3 bg-blue-300 rounded-full animate-pulse"></div>

                        <Quote class="absolute -top-6 -left-6 text-white/5 w-36 h-36 group-hover:scale-125 group-hover:rotate-12 transition-transform duration-700" />
                        <Quote class="absolute -bottom-6 -right-6 text-white/5 w-36 h-36 transform rotate-180 group-hover:scale-125 group-hover:-rotate-12 transition-transform duration-700" />
                        
                        <h2 class="text-2xl md:text-3xl font-bold text-white leading-relaxed md:leading-relaxed relative z-10 font-public-sans drop-shadow-md">
                            "{{ tentang?.visi_misi?.visi }}"
                        </h2>
                    </div>
                </div>

                <div class="mb-14 text-center" data-aos="fade-up">
                    <span class="inline-block py-1.5 px-6 rounded-full bg-blue-50 text-primary font-bold text-sm tracking-widest uppercase mb-6 border border-blue-100 font-optimus shadow-sm">Misi Fakultas</span>
                    <p class="text-2xl md:text-3xl font-black text-primary tracking-[0.2em] uppercase font-public-sans bg-clip-text text-transparent bg-gradient-to-r from-primary to-blue-400">
                        {{ tentang?.visi_misi?.misi_tagline }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="(item, index) in tentang?.visi_misi?.misi" :key="index" class="bg-white rounded-2xl p-6 border-t-4 border-transparent hover:border-t-primary border-x border-b border-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group font-public-sans" data-aos="fade-up" :data-aos-delay="index * 60">
                        <div class="absolute -right-4 -bottom-6 text-9xl font-black text-gray-100/50 group-hover:text-primary/10 transition-colors duration-500 select-none pointer-events-none">{{ item.huruf }}</div>
                        
                        <div class="relative z-10 flex flex-col h-full items-start">
                            <div class="w-12 h-12 rounded-xl bg-blue-50/80 shadow-inner text-primary flex items-center justify-center font-black text-2xl mb-5 group-hover:bg-primary group-hover:text-white transition-all duration-300 group-hover:scale-110">
                                {{ item.huruf }}
                            </div>
                            <h3 class="text-base md:text-lg font-bold text-gray-800 leading-snug group-hover:text-primary transition-colors">{{ item.teks }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.group:hover .shadow-inner {
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
}
</style>