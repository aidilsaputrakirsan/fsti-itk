<script setup>
import { onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { 
    ArrowRight, 
    AlertCircle, 
    Globe, 
    AppWindow, 
    MonitorSmartphone, 
    Link as LinkIcon, 
    Compass, 
    Monitor, 
    Server 
} from 'lucide-vue-next';
import AOS from 'aos';
import 'aos/dist/aos.css';

defineProps({
    services: Array
});

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});

// Merotasi ikon agar bervariasi
const getIcon = (index) => {
    const icons = [Globe, AppWindow, LinkIcon, MonitorSmartphone, Compass];
    return icons[index % icons.length];
};

// Rotasi warna pastel yang kalem dengan teks menggunakan warna primary
const getIconColorClasses = (index) => {
    const colors = [
        'bg-blue-50 text-primary',
        'bg-indigo-50 text-primary',
        'bg-sky-50 text-primary',
        'bg-slate-100 text-primary'
    ];
    return colors[index % colors.length];
};
</script>

<template>
    <PublicLayout>
        <Head title="Portal Layanan Mahasiswa" />
        
        <Banner
            title="PORTAL LAYANAN MAHASISWA"
            subtitle="DIREKTORI TAUTAN WEBSITE DAN SISTEM INFORMASI EKSTERNAL FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white py-20 font-public-sans min-h-[65vh] relative overflow-hidden">
            
            <Monitor class="absolute -top-10 -right-10 w-64 h-64 text-primary opacity-[0.03] transform rotate-12 pointer-events-none" />
            
            <Server class="absolute bottom-20 -left-10 w-72 h-72 text-primary opacity-[0.03] transform -rotate-12 pointer-events-none" />

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl relative z-10">

                <div class="bg-white rounded-[2rem] shadow-lg shadow-gray-200/50 border border-gray-100 relative" data-aos="fade-up">
                    
                    <div class="relative bg-gradient-to-br from-primary via-[#243db3] to-primary-hover px-8 py-10 md:px-12 md:py-14 rounded-t-[2rem] overflow-hidden">
                        
                        <div class="absolute -top-[50%] -right-[10%] w-[60%] h-[150%] bg-white/10 rounded-[100%] blur-[80px] pointer-events-none transform -rotate-12"></div>
                        <div class="absolute -bottom-[20%] left-[10%] w-[40%] h-[80%] bg-blue-300/20 rounded-[100%] blur-[60px] pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                            <div class="text-center md:text-left text-white max-w-2xl">
                                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-xs font-bold mb-4 shadow-sm uppercase tracking-widest">
                                    <AppWindow class="w-3.5 h-3.5" /> Layanan FSTI
                                </div>
                                <h2 class="text-3xl md:text-4xl font-optimus font-bold mb-3 leading-tight drop-shadow-sm text-white">
                                    Akses Layanan FSTI
                                </h2>
                                <p class="text-blue-50 text-sm md:text-base leading-relaxed opacity-90">
                                    Temukan berbagai portal layanan untuk memudahkan aktivitas akademik Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:flex absolute top-10 right-12 z-30 p-5 bg-white/5 backdrop-blur-sm rounded-[1.5rem] border border-white/10 items-center justify-center transform rotate-3 shadow-xl pointer-events-none">
                        <Globe class="w-20 h-20 text-white/90" stroke-width="1.5" />
                    </div>
                    
                    <div class="p-8 md:p-12 bg-white relative z-20 rounded-b-[2rem]">
                        <div v-if="services && services.length > 0" class="flex flex-col gap-4">
                            <a 
                                v-for="(service, index) in services" 
                                :key="service.id"
                                :href="service.link_url"
                                target="_blank"
                                class="group flex flex-col md:flex-row items-start md:items-center gap-5 bg-white hover:bg-blue-50/30 rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative overflow-hidden"
                                data-aos="fade-up"
                                :data-aos-delay="index * 50"
                            >
                                <div :class="[getIconColorClasses(index), 'w-14 h-14 shrink-0 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-110']">
                                    <component :is="getIcon(index)" class="w-6 h-6" />
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-primary mb-1 group-hover:opacity-80 transition-opacity leading-snug">
                                        {{ service.name }}
                                    </h3>
                                    <p class="text-gray-500 text-sm leading-relaxed max-w-3xl">
                                        {{ service.description }}
                                    </p>
                                </div>
                                
                                <div class="hidden md:flex shrink-0 w-10 h-10 rounded-full border border-gray-200 bg-white items-center justify-center group-hover:bg-primary group-hover:border-primary transition-all duration-300 relative z-10">
                                    <ArrowRight class="w-4 h-4 text-gray-400 group-hover:text-white group-hover:translate-x-1 transition-all duration-300" />
                                </div>
                                
                                <div class="md:hidden absolute top-5 right-5 w-8 h-8 rounded-full border border-gray-200 bg-white flex items-center justify-center group-hover:bg-primary group-hover:border-primary transition-all duration-300">
                                    <ArrowRight class="w-4 h-4 text-gray-400 group-hover:text-white transition-all duration-300" />
                                </div>
                            </a>
                        </div>

                        <div v-else class="flex flex-col items-center justify-center py-16 text-center bg-gray-50 rounded-2xl border border-gray-100" data-aos="zoom-in">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm border border-gray-100">
                                <AlertCircle class="w-8 h-8 text-gray-400" />
                            </div>
                            <h3 class="text-xl font-bold text-primary mb-2">Direktori Kosong</h3>
                            <p class="text-gray-500 text-sm max-w-md">Daftar tautan website eksternal saat ini belum ditambahkan oleh Admin.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </PublicLayout>
</template>