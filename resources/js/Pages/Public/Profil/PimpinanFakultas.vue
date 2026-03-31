<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    pimpinan: Array
});
</script>

<template>
    <PublicLayout>
        <Head title="Pimpinan Fakultas" />
        <Banner
            title="PIMPINAN FAKULTAS"
            subtitle="Fakultas Sains dan Teknologi Informasi"
            background-image="/images/background-banner.png"
        />

        <div class="bg-gray-50 py-16 md:py-24 overflow-x-hidden font-public-sans">
            <div class="container mx-auto px-6 max-w-5xl flex flex-col gap-10">
                <template v-for="(p, index) in pimpinan" :key="p.id">
                    <div
                        :data-aos="index % 2 === 0 ? 'fade-left' : 'fade-right'"
                        class="flex flex-col md:flex-row bg-white rounded-3xl shadow-sm border border-primary/10 overflow-hidden hover:shadow-md transition-shadow"
                        :class="{ 'md:flex-row-reverse': index % 2 !== 0 }"
                    >
                        <div class="w-full md:w-2/5 flex-shrink-0 bg-primary/5 relative">
                            <img :src="p.image_path || '/images/default-avatar.png'" :alt="p.name" class="w-full h-80 md:h-full object-cover object-top mix-blend-multiply">
                        </div>

                        <div class="w-full md:w-3/5 flex flex-col justify-center p-8 md:p-12 lg:p-16 text-center md:text-left">
                            <div class="inline-flex items-center justify-center md:justify-start gap-2 px-4 py-2 bg-primary/10 text-primary font-bold rounded-lg uppercase tracking-wider text-xs mb-6 w-max mx-auto md:mx-0 border border-primary/20">
                                Pimpinan
                            </div>
                            <h3 class="font-optimus font-bold text-3xl md:text-4xl text-gray-900 mb-4 leading-tight">
                                {{ p.name }}
                            </h3>
                            <div class="w-16 h-1.5 bg-primary rounded-full mb-6 opacity-80 mx-auto md:mx-0"></div>
                            <p class="text-lg md:text-xl text-primary font-bold leading-relaxed tracking-wide">
                                {{ p.position }}
                            </p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </PublicLayout>
</template>