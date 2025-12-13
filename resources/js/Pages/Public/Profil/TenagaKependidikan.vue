<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';

// Menerima data dari Controller
const props = defineProps({
    staffList: Array
});

const tendik = props.staffList;
</script>

<template>
    <PublicLayout>
        <Banner
            title="TENAGA KEPENDIDIKAN"
            subtitle="TENAGA KEPENDIDIKAN"
            background-image="/images/background-banner.png"
        />

        <div class="pt-12 pb-16 md:pb-24 bg-white overflow-x-hidden">
            <div>
                <div class="mb-12">
                    
                    <div class="bg-[#CBDCEB] text-center p-6 shadow-md mb-10" data-aos="fade-up">
                        <h2 class="text-2xl md:text-3xl font-kulim-park font-bold text-[#133E87]">
                            Tenaga Kependidikan <br> Fakultas Sains dan Teknologi Informasi
                        </h2>
                    </div>

                    <!-- Grid 2 kolom x 3 baris -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 container mx-auto px-4">
                        <div
                            v-for="(t, tIndex) in tendik"
                            :key="t.id"
                            data-aos="fade-up"
                            :data-aos-delay="tIndex * 100"
                        >
                            <div
                                class="bg-[#CBDCEB] rounded-lg shadow-lg p-8 text-center flex flex-col items-center h-full
                                       transform transition-transform duration-300 hover:scale-[1.02]"
                            >
                                <div class="w-40 h-40 rounded-full border-2 border-[#133E87] p-1 mb-6 flex-shrink-0">
                                    <img :src="t.image_path || '/images/default-avatar.png'" :alt="t.name" class="w-full h-full object-cover rounded-full">
                                </div>
                                
                                <h3 class="font-kulim-park font-bold text-xl text-[#133E87]">
                                    {{ t.name }}
                                </h3>
                                
                                <hr class="my-2 border-t-2 w-1/2 border-[#133E87]">
                                
                                <p class="font-kulim-park text-base text-[#133E87]">
                                    {{ t.position }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </PublicLayout>
</template>
