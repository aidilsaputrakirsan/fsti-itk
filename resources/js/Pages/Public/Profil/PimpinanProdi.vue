=<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';

import { computed } from 'vue';

const props = defineProps({
    pimpinan: Array
});

// Group pimpinan by Jurusan
const departments = computed(() => {
    // Unique Jurusan
    const jurusans = [...new Set(props.pimpinan.map(p => p.jurusan))];
    
    // Sort logic (Hardcoded preference if needed, or simple alphanumeric)
    // Here we try to replicate 'Sains dan Analitika Data' first if present
    jurusans.sort((a, b) => {
        if (a && a.includes('Sains')) return -1;
        return 1;
    });

    return jurusans.map(jurusan => ({
        jurusan: ['Koordinator Program Studi', 'Jurusan ' + (jurusan || 'Lainnya')],
        pimpinan: props.pimpinan.filter(p => p.jurusan === jurusan)
    }));
});
</script>

<template>
    <PublicLayout>
        <Banner
            title="PIMPINAN PRODI"
            subtitle="PIMPINAN PRODI"
            background-image="/images/background-banner.png"
        />

        <div class="pt-12 pb-16 md:pb-24 bg-white overflow-x-hidden">
            <div>
                <div v-for="(dept, index) in departments" :key="index" class="mb-12">
                    
                    <div class="bg-[#CBDCEB] text-center p-6 shadow-md mb-10" data-aos="fade-up">
                        <h2 class="text-2xl md:text-3xl font-kulim-park font-bold text-[#133E87]">
                            {{ dept.jurusan[0] }} <br> {{ dept.jurusan[1] }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 container mx-auto px-4">
                        <div
                            v-for="(p, pIndex) in dept.pimpinan"
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