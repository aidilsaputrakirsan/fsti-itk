<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';

// Menerima data dari Controller
const props = defineProps({
    pimpinan: Array
});

const pimpinanLab = props.pimpinan;
</script>

<template>
    <PublicLayout>
        <Banner
            title="PIMPINAN LABORATORIUM"
            subtitle="PIMPINAN LABORATORIUM"
            background-image="/images/background-banner.png"
        />

        <div class="pt-12 pb-16 md:pb-24 bg-white overflow-x-hidden">
            <div>
                <div class="mb-12">
                    
                    <div class="bg-[#CBDCEB] text-center p-6 shadow-md mb-10" data-aos="fade-up">
                        <h2 class="text-2xl md:text-3xl font-kulim-park font-bold text-[#133E87]">
                            Pimpinan Laboratorium <br> Fakultas Sains dan Teknologi Informasi
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 container mx-auto px-4">
                        <div
                            v-for="(p, pIndex) in pimpinanLab"
                            :key="p.id"
                            data-aos="fade-up"
                            :data-aos-delay="pIndex * 100"
                        >
                            <div
                                class="bg-[#CBDCEB] rounded-lg shadow-lg p-8 text-center flex flex-col items-center h-full
                                       transform transition-transform duration-300 hover:scale-[1.02]"
                            >
                                <div class="w-48 h-48 rounded-full border-2 border-[#133E87] p-1 mb-6 flex-shrink-0">
                                    <img :src="p.image_path || '/images/default-avatar.png'" :alt="p.name" class="w-full h-full object-cover rounded-full">
                                </div>
                                
                                <h3 class="font-kulim-park font-bold text-xl text-[#133E87]">
                                    {{ p.name }}
                                </h3>
                                
                                <hr class="my-2 border-t-2 w-1/2 border-[#133E87]">
                                
                                <p class="font-kulim-park text-base text-[#133E87]">
                                    {{ p.position }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </PublicLayout>
</template>