<script setup>
import { ref, computed, onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { 
    GraduationCap, 
    Landmark, 
    Banknote, 
    BookOpen, 
    Award, 
    Search, 
    X, 
    AlertCircle, 
    ChevronRight 
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

const props = defineProps({
    beasiswas: {
        type: Array,
        default: () => []
    }
});

const searchQuery = ref('');

const filteredBeasiswas = computed(() => {
    if (!searchQuery.value) return props.beasiswas;
    const query = searchQuery.value.toLowerCase();
    return props.beasiswas.filter(b => 
        b.title.toLowerCase().includes(query) || 
        b.description.toLowerCase().includes(query) ||
        (b.provider && b.provider.toLowerCase().includes(query))
    );
});

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});

// Merotasi ikon agar grid terlihat dinamis dan berwarna
const getIcon = (index) => {
    const icons = [GraduationCap, Banknote, Landmark, BookOpen, Award];
    return icons[index % icons.length];
};

const getIconColorClasses = (index) => {
    const colors = [
        'bg-blue-50 text-primary',
        'bg-indigo-50 text-indigo-500',
        'bg-sky-50 text-sky-500',
        'bg-cyan-50 text-cyan-500',
        'bg-slate-100 text-slate-600'
    ];
    return colors[index % colors.length];
};
</script>

<template>
    <PublicLayout>
        <Head title="Informasi Beasiswa" />
        
        <Banner
            title="INFORMASI BEASISWA"
            subtitle="DAFTAR PROGRAM BEASISWA DAN BANTUAN PENDIDIKAN UNTUK MAHASISWA FSTI"
            background-image="/images/background-banner.png"
        />

        <div class="bg-slate-50 py-16 md:py-24 font-public-sans min-h-[70vh]">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

                <div class="relative w-full bg-gradient-to-br from-primary via-[#243db3] to-primary-hover rounded-[2rem] p-8 md:p-14 mb-10 overflow-hidden shadow-xl shadow-primary/20 flex flex-col md:flex-row items-center justify-between border border-white/10" data-aos="fade-down">
                    
                    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                    <div class="absolute -top-[30%] -right-[10%] w-[60%] h-[150%] bg-white/10 rounded-[100%] blur-[80px] pointer-events-none transform -rotate-12"></div>
                    <div class="absolute -bottom-[20%] left-[10%] w-[40%] h-[80%] bg-blue-300/20 rounded-[100%] blur-[60px] pointer-events-none"></div>

                    <div class="relative z-10 text-white w-full max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-[11px] font-bold mb-5 shadow-sm uppercase tracking-[0.15em] text-blue-50">
                            <GraduationCap class="w-3.5 h-3.5" /> Bantuan Pendidikan
                        </div>
                        <h2 class="text-3xl md:text-5xl font-optimus font-bold mb-4 leading-tight drop-shadow-sm">
                            Raih Peluang Masa<br/>Depan Gemilang
                        </h2>
                        <p class="text-blue-100 md:text-lg leading-relaxed font-light opacity-90">
                            FSTI ITK berkomitmen mendukung potensi mahasiswa. Temukan berbagai program beasiswa dari pemerintah, institusi, dan mitra industri kami.
                        </p>
                    </div>

                    <div class="hidden md:flex shrink-0 p-6 bg-white/10 backdrop-blur-md rounded-[2rem] border border-white/20 items-center justify-center transform rotate-6 hover:rotate-0 hover:scale-105 transition-all duration-500 shadow-2xl relative z-10">
                        <GraduationCap class="w-24 h-24 text-white" stroke-width="1.2" />
                    </div>
                </div>

                <div class="relative z-20 -mt-16 mx-4 md:mx-auto max-w-3xl mb-16 bg-white p-3 md:p-4 rounded-2xl shadow-[0_8px_30px_rgba(47,77,211,0.08)] border border-slate-100 flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative flex-grow">
                        <input 
                            type="text" 
                            placeholder="Cari nama beasiswa atau penyelenggara..." 
                            class="w-full pl-12 pr-10 py-3.5 md:py-4 border-none focus:ring-0 bg-transparent text-slate-800 font-medium text-lg placeholder-slate-400"
                            v-model="searchQuery"
                        >
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-slate-300" />
                        <button v-if="searchQuery" @click="searchQuery = ''" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-300 hover:text-primary transition-colors bg-slate-50 hover:bg-blue-50 rounded-full">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                <div v-if="filteredBeasiswas.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(beasiswa, index) in filteredBeasiswas" 
                        :key="beasiswa.id"
                        class="group bg-white rounded-[2rem] border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_15px_40px_rgba(47,77,211,0.08)] hover:-translate-y-1 hover:border-primary/20 transition-all duration-300 flex flex-col overflow-hidden relative"
                        data-aos="fade-up"
                        :data-aos-delay="(index % 3) * 50"
                    >
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary to-primary-hover opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="p-8 flex-grow flex flex-col">
                            <div class="flex items-start justify-between mb-6">
                                <div :class="[getIconColorClasses(index), 'w-14 h-14 rounded-2xl flex items-center justify-center transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3 shadow-sm']">
                                    <component :is="getIcon(index)" class="w-7 h-7" />
                                </div>
                                <span class="px-3 py-1 bg-green-50 text-green-600 border border-green-100 font-bold text-[10px] uppercase tracking-widest rounded-full">
                                    {{ beasiswa.status || 'Tersedia' }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                {{ beasiswa.title }}
                            </h3>
                            
                            <p class="text-xs font-semibold tracking-wider text-slate-400 uppercase mb-4 flex items-center gap-1.5">
                                <Landmark class="w-3.5 h-3.5" /> {{ beasiswa.provider || 'Mitra FSTI ITK' }}
                            </p>

                            <p class="text-slate-500 text-sm leading-relaxed flex-grow line-clamp-4 mb-6">
                                {{ beasiswa.description }}
                            </p>

                            <button class="mt-auto flex items-center justify-between w-full py-3.5 px-5 bg-slate-50 hover:bg-primary group-hover:bg-primary rounded-xl text-slate-600 hover:text-white group-hover:text-white text-sm font-bold transition-all duration-300">
                                Info Selengkapnya 
                                <ChevronRight class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" />
                            </button>
                        </div>
                    </div>
                </div>

                <div v-else class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-[2rem] shadow-sm border border-dashed border-slate-200" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-5 border border-slate-100">
                        <AlertCircle class="w-10 h-10 text-slate-300" />
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Pencarian Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-md">Tidak ada beasiswa yang cocok dengan kata kunci "{{ searchQuery }}".</p>
                    <button @click="searchQuery = ''" class="mt-6 px-6 py-2.5 bg-blue-50 text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition-colors">
                        Reset Pencarian
                    </button>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>