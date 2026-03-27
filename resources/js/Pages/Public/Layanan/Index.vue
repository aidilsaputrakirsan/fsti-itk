<script setup>
import { onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { ArrowRight, AlertCircle, Globe, AppWindow, MonitorSmartphone, Link as LinkIcon, Compass } from 'lucide-vue-next';
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

        <div class="bg-[#F8FAFC] py-20 font-public-sans min-h-[65vh] relative overflow-hidden">
            
            <Globe class="absolute -top-10 -right-10 w-80 h-80 text-primary opacity-[0.03] transform rotate-12 pointer-events-none" />
            <Globe class="absolute -bottom-20 -left-20 w-96 h-96 text-primary opacity-[0.03] transform -rotate-12 pointer-events-none" />

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl relative z-10">

                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden p-8 md:p-12" data-aos="fade-up">
                    
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-primary"></div>
                    
                    <div class="border-b border-gray-100 pb-8 mb-8 text-center md:text-left">
                        <h2 class="text-2xl md:text-3xl font-extrabold text-primary mb-2 tracking-tight">
                            Akses Layanan FSTI
                        </h2>
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                            Temukan berbagai portal layanan dalam satu tempat untuk memudahkan aktivitas akademik Anda.
                        </p>
                    </div>

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
    </PublicLayout>
</template>