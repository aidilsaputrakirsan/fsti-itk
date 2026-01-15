<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    policies: Array,
    news: Array
});
</script>

<template>
    <PublicLayout>
        <Head title="Zona Integritas" />
        <Banner
            title="ZONA INTEGRITAS"
            subtitle="WILAYAH BEBAS DARI KORUPSI"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white py-12 md:py-24">
            <div class="container mx-auto px-6 lg:px-8">
                
                <!-- Section Kebijakan -->
                <div class="mb-20">
                    <h2 class="text-4xl font-kulim-park-bold text-[#133E87] mb-8 text-center" data-aos="fade-up">Kebijakan & Regulasi</h2>
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <div 
                            v-for="policy in policies" 
                            :key="policy.id"
                            class="bg-[#CBDCEB] rounded-xl p-6 shadow-lg transform hover:-translate-y-2 transition-transform duration-300"
                            data-aos="fade-up"
                        >
                            <div class="flex items-center mb-4">
                                <span class="bg-[#133E87] text-white p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </span>
                                <h3 class="ml-4 text-xl font-inter-bold text-[#133E87]">{{ policy.title }}</h3>
                            </div>
                            <div class="text-gray-700 font-inter-regular mb-4 line-clamp-3" v-html="policy.content"></div>
                            <a 
                                v-if="policy.document_path" 
                                :href="'/storage/' + policy.document_path"
                                target="_blank"
                                class="text-[#4682A9] font-inter-semibold hover:underline flex items-center"
                            >
                                Unduh Dokumen
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section Berita ZI -->
                <div v-if="news.length > 0">
                    <h2 class="text-4xl font-kulim-park-bold text-[#4682A9] mb-8 text-center" data-aos="fade-up">Kabar Integritas</h2>
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <div 
                            v-for="item in news" 
                            :key="item.id"
                            class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100"
                            data-aos="fade-up"
                        >
                            <img 
                                v-if="item.image_path" 
                                :src="'/storage/' + item.image_path" 
                                alt="News Image" 
                                class="w-full h-48 object-cover"
                            >
                            <div class="p-6">
                                <span class="text-sm text-gray-500 mb-2 block">{{ new Date(item.published_at).toLocaleDateString('id-ID') }}</span>
                                <h3 class="text-lg font-inter-bold text-[#133E87] mb-2">{{ item.title }}</h3>
                                <div class="text-sm text-gray-600 line-clamp-3" v-html="item.content"></div>
                            </div>
                        </div>
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
