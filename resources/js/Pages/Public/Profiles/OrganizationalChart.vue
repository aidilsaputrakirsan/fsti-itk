<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { FileWarning } from 'lucide-vue-next';

const props = defineProps({
    baganImage: String 
});
</script>

<template>
    <PublicLayout>
        <Head title="Bagan Organisasi" />
        <Banner
            title="BAGAN ORGANISASI"
            subtitle="Fakultas Sains dan Teknologi Informasi"
            background-image="/images/background-banner.png"
        />

        <div class="py-16 md:py-24 bg-white font-public-sans">
            <div class="container mx-auto px-6 md:px-8 max-w-6xl">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4">
                        Bagan Organisasi <span class="text-primary">FSTI</span>
                    </h2>
                    <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
                </div>

                <div
                    class="bg-white border border-primary/10 rounded-3xl shadow-sm overflow-hidden transition-all duration-300 ease-in-out hover:shadow-md"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-3 bg-primary self-stretch"></div>
                        <div class="flex-grow p-6 md:p-10">
                            <div class="flex justify-center bg-primary/5 rounded-2xl p-4 border border-primary/10 min-h-[300px]">
                                
                                <img
                                    v-if="baganImage"
                                    :src="baganImage"
                                    alt="Bagan Organisasi FSTI ITK"
                                    class="w-full h-auto object-contain drop-shadow-sm mix-blend-multiply"
                                />
                                
                                <div v-else class="flex flex-col items-center justify-center text-center py-10 opacity-60">
                                    <FileWarning class="w-16 h-16 text-primary mb-4" />
                                    <h3 class="text-xl font-bold text-gray-800">Bagan Organisasi Belum Tersedia</h3>
                                    <p class="text-gray-500 mt-2">Admin belum mengunggah gambar bagan struktur organisasi.</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>