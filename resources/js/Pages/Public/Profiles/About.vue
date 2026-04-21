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
    profile: Object,
    statistics: Object 
});

const displayStats = computed(() => {
    const cmsData = props.profile?.statistik?.data || [];

    return cmsData.map(stat => {
        const labelLower = stat.label.toLowerCase();
        
        if (labelLower.includes('dosen')) {
            return { ...stat, angka: props.statistics?.dosen ?? stat.angka };
        }
        if (labelLower.includes('tendik') || labelLower.includes('kependidikan')) {
            return { ...stat, angka: props.statistics?.tendik ?? stat.angka };
        }
        if (labelLower.includes('s1')) {
            return { ...stat, angka: props.statistics?.prodi_s1 ?? stat.angka };
        }
        if (labelLower.includes('s2') || labelLower.includes('magister')) {
            return { ...stat, angka: props.statistics?.prodi_s2 ?? stat.angka };
        }
        if (labelLower.includes('prodi') || labelLower.includes('program studi')) {
            return { ...stat, angka: props.statistics?.prodi_total ?? stat.angka };
        }
        if (labelLower.includes('alumni') || labelLower.includes('lulusan')) {
            return { ...stat, angka: props.statistics?.alumni ?? stat.angka };
        }
        
        return stat; 
    });
});

const getStatIcon = (index) => {
    const icons = [Users, GraduationCap, Building, Zap, Beaker, Users, UserCheck, Network];
    return icons[index % icons.length];
};

const getFasilitasIcon = (index) => {
    const icons = [Users, Globe, GraduationCap, Zap, Cpu, Code, Beaker, Network, Building, FileText];
    return icons[index % icons.length];
};

const getImageUrl = (path) => {
    if (!path) return '';
    if (path.startsWith('http')) return path;
    if (path.startsWith('images/')) return `/${path}`; 
    return `/storage/${path}`; 
};

const countUpAnimation = (el, target, duration) => {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        
        const easeOut = progress * (2 - progress);
        const currentVal = Math.floor(easeOut * target);
        
        el.innerText = currentVal.toLocaleString('id-ID');
        
        if (progress < 1) {
            window.requestAnimationFrame(step);
        } else {
            el.innerText = target.toLocaleString('id-ID');
        }
    };
    window.requestAnimationFrame(step);
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
        <Head title="Tentang Fakultas">
            <meta name="description" content="Profil, Tugas, Fungsi, Visi Misi, dan Fasilitas dari Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan." />
        </Head>

        <Banner title="TENTANG FAKULTAS" subtitle="PROFIL, TUGAS, FUNGSI, SERTA VISI & MISI FSTI ITK" background-image="/images/background-banner.webp" />

        <section class="bg-white py-16 md:py-24 font-public-sans border-b border-gray-100 relative overflow-hidden">
            <Globe aria-hidden="true" class="absolute -top-16 -left-16 w-64 h-64 text-primary/5 -rotate-12 pointer-events-none" />
            <Cpu aria-hidden="true" class="absolute -bottom-10 -right-10 w-48 h-48 text-primary/5 rotate-12 pointer-events-none" />
            <div aria-hidden="true" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] bg-primary/5 rounded-full blur-3xl opacity-40 pointer-events-none"></div>

            <div class="container mx-auto px-6 lg:px-8 max-w-7xl relative z-10">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-4 tracking-tight">Mengenal FSTI ITK</h2>
                    <div class="w-16 h-1 bg-primary mx-auto mb-5 rounded-full opacity-50"></div>
                    <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto leading-relaxed">{{ profile?.statistik?.deskripsi }}</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mx-auto max-w-7xl">
                    <div v-for="(stat, index) in displayStats" :key="index" class="bg-white rounded-2xl p-6 text-center border-t-4 border-transparent hover:border-t-primary border border-x-gray-100 border-b-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-300 group" data-aos="zoom-in" :data-aos-delay="index * 40">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-50/50 rounded-xl text-primary mb-5 group-hover:bg-primary group-hover:text-white group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <component :is="getStatIcon(index)" aria-hidden="true" class="w-6 h-6" />
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
                            <Code aria-hidden="true" class="w-7 h-7" />
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-6 leading-tight">Tugas & Fungsi <br>Fakultas</h2>
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-md border-l-4 border-primary">
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                                <FileText aria-hidden="true" class="w-6 h-6 text-primary" /> Tugas Pokok
                            </h3>
                            <p class="text-gray-700 leading-relaxed text-justify font-medium">{{ profile?.tugas_fungsi?.tugas }}</p>
                        </div>
                    </div>

                    <div class="lg:col-span-7 space-y-5" data-aos="fade-left">
                        <div v-for="(fungsi, index) in profile?.tugas_fungsi?.fungsi" :key="index" class="bg-white p-5 md:p-7 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:shadow-blue-900/5 hover:-translate-x-2 transition-all duration-300 flex gap-5 items-start group relative overflow-hidden">
                            <div aria-hidden="true" class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-primary to-blue-300 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
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
            <svg aria-hidden="true" class="absolute bottom-0 left-0 w-full h-auto text-white z-0" viewBox="0 0 1440 320" fill="currentColor">
                <path d="M0,224L48,224C96,224,192,224,288,197.3C384,171,480,117,576,90.7C672,64,768,64,864,80C960,96,1056,128,1152,128C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>

            <div class="container mx-auto px-6 lg:px-8 max-w-6xl relative z-10">
                
                <div class="text-center max-w-4xl mx-auto mb-20" data-aos="fade-up">
                    <span class="inline-block py-1.5 px-6 rounded-full bg-blue-50 text-primary font-bold text-sm tracking-widest uppercase mb-8 border border-blue-100 font-optimus shadow-sm">Visi Fakultas</span>
                    
                    <div class="bg-gradient-to-br from-primary via-[#0f346e] to-[#0A2A5E] rounded-[2rem] p-10 md:p-14 shadow-2xl relative overflow-hidden group">
                        <div aria-hidden="true" class="absolute top-4 right-8 w-2 h-2 bg-yellow-300 rounded-full animate-ping"></div>
                        <div aria-hidden="true" class="absolute bottom-10 left-10 w-3 h-3 bg-blue-300 rounded-full animate-pulse"></div>

                        <Quote aria-hidden="true" class="absolute -top-6 -left-6 text-white/5 w-36 h-36 group-hover:scale-125 group-hover:rotate-12 transition-transform duration-700" />
                        <Quote aria-hidden="true" class="absolute -bottom-6 -right-6 text-white/5 w-36 h-36 transform rotate-180 group-hover:scale-125 group-hover:-rotate-12 transition-transform duration-700" />
                        
                        <h2 class="text-2xl md:text-3xl font-bold text-white leading-relaxed md:leading-relaxed relative z-10 font-public-sans drop-shadow-md">
                            "{{ profile?.visi_misi?.visi }}"
                        </h2>
                    </div>
                </div>

                <div class="mb-14 text-center" data-aos="fade-up">
                    <span class="inline-block py-1.5 px-6 rounded-full bg-blue-50 text-primary font-bold text-sm tracking-widest uppercase mb-6 border border-blue-100 font-optimus shadow-sm">Misi Fakultas</span>
                    <p class="text-2xl md:text-3xl font-black text-primary tracking-[0.2em] uppercase font-public-sans bg-clip-text text-transparent bg-gradient-to-r from-primary to-blue-400">
                        {{ profile?.visi_misi?.misi_tagline }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="(item, index) in profile?.visi_misi?.misi" :key="index" class="bg-white rounded-2xl p-6 border-t-4 border-transparent hover:border-t-primary border-x border-b border-gray-100 shadow-sm hover:shadow-xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group font-public-sans" data-aos="fade-up" :data-aos-delay="index * 60">
                        <div aria-hidden="true" class="absolute -right-4 -bottom-6 text-9xl font-black text-gray-100/50 group-hover:text-primary/10 transition-colors duration-500 select-none pointer-events-none">{{ item.huruf }}</div>
                        
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

        <section class="bg-primary/10 pt-16 pb-32 md:pt-20 md:pb-48 font-public-sans relative overflow-hidden">
            
            <svg aria-hidden="true" class="absolute bottom-0 left-0 w-full h-auto text-white z-0" viewBox="0 0 1440 320" fill="currentColor">
                <path d="M0,224L48,224C96,224,192,224,288,197.3C384,171,480,117,576,90.7C672,64,768,64,864,80C960,96,1056,128,1152,128C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>

            <div aria-hidden="true" class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/40 rounded-full blur-3xl pointer-events-none"></div>
            <div aria-hidden="true" class="absolute bottom-20 left-0 -ml-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="container mx-auto px-6 lg:px-8 max-w-7xl relative z-10">
                <div class="flex flex-col md:items-center text-center justify-center mb-16 gap-4">
                    <div data-aos="fade-up">
                        <span class="inline-flex items-center justify-center gap-2 py-1.5 px-5 rounded-full bg-white text-primary font-bold text-xs md:text-sm tracking-widest uppercase mb-4 border border-blue-100 shadow-sm">
                            <Building aria-hidden="true" class="w-4 h-4" /> Lingkungan Akademik
                        </span>
                        <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-4 tracking-tight leading-tight">
                            Fasilitas & Lingkungan Kampus
                        </h2>
                        <div class="w-16 h-1 bg-primary mx-auto mb-5 rounded-full opacity-50"></div>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed max-w-3xl mx-auto">
                            Kami menyediakan berbagai fasilitas yang nyaman dan memadai untuk mendukung proses belajar, praktik, serta aktivitas harian mahasiswa di kampus.
                        </p>
                    </div>
                </div>

                <div v-if="profile?.fasilitas && profile.fasilitas.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-6">
                    
                    <div v-for="(item, index) in profile.fasilitas" :key="index" 
                         class="group relative overflow-hidden rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 border border-white bg-white min-h-[16rem] md:min-h-[18rem]" 
                         :class="(index === 0 || index >= 5) ? 'md:col-span-2 lg:col-span-2' : 'md:col-span-1 lg:col-span-1'"
                         data-aos="fade-up" :data-aos-delay="(index % 3) * 100">
                        
                        <div class="absolute top-4 right-4 z-20 w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 shadow-lg group-hover:bg-primary transition-all duration-300">
                            <component :is="getFasilitasIcon(index)" aria-hidden="true" class="w-5 h-5" />
                        </div>
                        <div aria-hidden="true" class="absolute inset-0 bg-primary/20 mix-blend-multiply z-10 group-hover:opacity-0 transition-opacity duration-700"></div>
                        
                        <img :src="getImageUrl(item.gambar)" :alt="item.nama" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-in-out">
                        
                        <div class="absolute inset-0 z-10 bg-gradient-to-t from-gray-900/90 via-gray-900/30 to-transparent flex flex-col justify-end p-6 md:p-8">
                            <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <h3 class="text-white font-bold text-xl md:text-2xl mb-1 drop-shadow-md">{{ item.nama }}</h3>
                                <p class="text-gray-200 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100 leading-relaxed">{{ item.deskripsi }}</p>
                            </div>
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