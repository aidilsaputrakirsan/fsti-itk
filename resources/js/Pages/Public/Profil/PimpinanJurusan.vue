<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { ImageOff } from 'lucide-vue-next';

const props = defineProps({
    pimpinan: Array
});
</script>

<template>
    <PublicLayout>
        <Head title="Pimpinan Jurusan" />
        <Banner
            title="PIMPINAN JURUSAN"
            subtitle="Fakultas Sains dan Teknologi Informasi"
            background-image="/images/background-banner.png"
        />

        <div class="bg-slate-50 py-16 md:py-24 overflow-x-hidden font-public-sans">
            <div class="container mx-auto px-6 max-w-5xl flex flex-col gap-12">
                
                <div v-if="pimpinan.length === 0" class="text-center text-gray-500 py-10">
                    Belum ada data pimpinan jurusan.
                </div>

                <template v-for="(p, index) in pimpinan" :key="p.id">
                    <div
                        :data-aos="index % 2 === 0 ? 'fade-right' : 'fade-left'"
                        class="flex flex-col md:flex-row rounded-[2.5rem] shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group bg-white border border-gray-100"
                        :class="{ 'md:flex-row-reverse': index % 2 !== 0 }"
                    >
                        <div class="w-full md:w-2/5 flex-shrink-0 relative overflow-hidden bg-gray-100 border-r border-gray-100">
                             <img v-if="p.display_image" :src="p.display_image" :alt="p.name" class="w-full h-80 md:h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 bg-white">
                             
                             <div v-else class="w-full h-80 md:h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 group-hover:scale-105 transition-transform duration-700">
                                <ImageOff class="w-12 h-12 mb-3 opacity-40" />
                                <span class="text-sm font-semibold text-gray-500">Foto Belum Tersedia</span>
                            </div>
                        </div>

                        <div class="w-full md:w-3/5 flex flex-col justify-center p-10 md:p-14 lg:p-16 text-center md:text-left relative bg-gradient-to-br from-primary to-primary-hover text-white">
                            <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            
                            <div class="inline-flex items-center justify-center md:justify-start gap-2 px-5 py-2 bg-white/10 text-white font-bold rounded-xl uppercase tracking-wider text-xs mb-6 w-max mx-auto md:mx-0 border border-white/20 backdrop-blur-sm z-10">
                                Ketua Jurusan
                            </div>
                            <h3 class="font-optimus font-bold text-3xl md:text-4xl text-white mb-4 leading-tight group-hover:text-blue-100 transition-colors duration-300 z-10">
                                {{ p.name }}
                            </h3>
                            <div class="w-16 h-1.5 bg-white/40 rounded-full mb-6 opacity-80 mx-auto md:mx-0 z-10"></div>
                            <p class="text-lg md:text-xl text-white/90 font-medium leading-relaxed tracking-wide z-10">
                                {{ p.structural_position }}
                            </p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </PublicLayout>
</template>