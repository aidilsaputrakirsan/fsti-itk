<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { ImageOff } from 'lucide-vue-next';

const props = defineProps({
    pimpinan: Array
});

const pimpinanLab = props.pimpinan;
</script>

<template>
    <PublicLayout>
        <Head title="Pimpinan Laboratorium" />
        <Banner
            title="PIMPINAN LABORATORIUM"
            subtitle="Kepala Laboratorium FSTI"
            background-image="/images/background-banner.png"
        />

        <div class="bg-slate-50 py-16 md:py-24 overflow-x-hidden font-public-sans">
            <div class="container mx-auto px-4 max-w-7xl">
                
                <div class="text-center mb-16" data-aos="fade-up">
                    <div class="inline-block px-6 py-2.5 bg-primary text-white font-bold rounded-full uppercase tracking-widest text-xs mb-4 shadow-lg shadow-primary/20">
                        Struktur Laboratorium
                    </div>
                    <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary-hover">
                        Kepala Laboratorium FSTI
                    </h2>
                    <div class="w-24 h-1.5 bg-primary/50 mx-auto mt-6 rounded-full"></div>
                </div>

                <div v-if="pimpinanLab.length === 0" class="text-center text-gray-500 py-10">
                    Belum ada data pimpinan laboratorium.
                </div>

                <div class="flex flex-wrap justify-center gap-8">
                    <div
                        v-for="(p, pIndex) in pimpinanLab"
                        :key="p.id"
                        class="w-full sm:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] max-w-[380px]"
                        data-aos="fade-up"
                        :data-aos-delay="pIndex * 50"
                    >
                        <div class="bg-gradient-to-b from-primary to-primary-hover rounded-[2.5rem] shadow-xl p-8 md:p-10 text-center flex flex-col items-center h-full transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-primary/30 group border border-primary-hover relative overflow-hidden">
                            
                            <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            
                            <div class="w-40 h-40 rounded-full border-[5px] border-white/20 p-1.5 mb-6 flex-shrink-0 relative overflow-hidden bg-white/10 group-hover:border-white/40 transition-colors duration-500 shadow-inner z-10">
                                <img v-if="p.display_image" :src="p.display_image" :alt="p.name" class="w-full h-full object-cover rounded-full bg-white">
                                
                                <div v-else class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400 rounded-full">
                                    <ImageOff class="w-10 h-10 mb-1 opacity-40" />
                                    <span class="text-[10px] font-semibold text-gray-500">Belum Tersedia</span>
                                </div>
                            </div>
                            
                            <h3 class="font-bold text-lg text-white mb-3 group-hover:text-blue-100 transition-colors duration-300 z-10 leading-tight">
                                {{ p.name }}
                            </h3>
                            
                            <div class="w-12 h-1 bg-white/30 rounded-full my-3 z-10"></div>
                            
                            <p class="text-sm font-medium text-white/90 leading-snug z-10">
                                {{ p.structural_position }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>