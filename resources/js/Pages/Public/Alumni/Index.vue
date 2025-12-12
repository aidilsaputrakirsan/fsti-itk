<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    tracers: Array
});
</script>

<template>
    <PublicLayout>
        <Head title="Alumni & Tracer Study" />
        <Banner
            title="ALUMNI CENTER"
            subtitle="JARINGAN ALUMNI FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white py-12 md:py-24">
            <div class="container mx-auto px-6 lg:px-8">
                
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl font-kulim-park-bold text-[#133E87]">Tracer Study & Karir</h2>
                    <p class="mt-4 text-xl text-gray-600">Informasi survei lulusan dan laporan tracer study</p>
                </div>

                <div class="grid gap-8 md:grid-cols-2 max-w-5xl mx-auto">
                    <!-- Card Survey -->
                    <div class="bg-[#133E87] rounded-2xl p-8 text-white text-center shadow-xl" data-aos="flip-left">
                        <div class="bg-white/10 rounded-full p-4 w-20 h-20 mx-auto flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-inter-bold mb-4">Isi Tracer Study</h3>
                        <p class="font-inter-regular mb-8 text-blue-100">
                            Bagi alumni FSTI ITK, partisipasi Anda sangat berharga untuk pengembangan mutu pendidikan kami.
                        </p>
                        <a 
                            href="https://tracer.itk.ac.id" 
                            target="_blank"
                            class="inline-block bg-white text-[#133E87] px-8 py-3 rounded-full font-inter-bold hover:bg-gray-100 transition-colors"
                        >
                            Menuju Kuisioner
                        </a>
                    </div>

                    <!-- Card List Laporan -->
                    <div class="bg-gray-50 rounded-2xl p-8 border border-gray-200" data-aos="flip-right">
                        <h3 class="text-2xl font-inter-bold text-[#133E87] mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Arsip Laporan
                        </h3>
                        <ul class="space-y-4">
                            <li v-for="item in tracers" :key="item.id" class="border-b pb-4 last:border-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-inter-semibold text-gray-800">{{ item.title }}</h4>
                                        <span class="text-sm text-gray-500">Tahun: {{ item.year }}</span>
                                    </div>
                                    <a 
                                        v-if="item.url || item.file_path"
                                        :href="item.url || '/storage/' + item.file_path"
                                        target="_blank"
                                        class="bg-[#4682A9] text-white px-3 py-1 rounded text-sm hover:bg-[#133E87] transition-colors"
                                    >
                                        Buka
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <p v-if="tracers.length === 0" class="text-gray-500 italic">Belum ada laporan dipublikasikan.</p>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Kulim+Park:wght@700&display=swap');

.font-kulim-park-bold { font-family: 'Kulim Park', sans-serif; font-weight: 700; }
.font-inter-regular { font-family: 'Inter', sans-serif; font-weight: 400; }
.font-inter-semibold { font-family: 'Inter', sans-serif; font-weight: 600; }
.font-inter-bold { font-family: 'Inter', sans-serif; font-weight: 700; }
</style>
