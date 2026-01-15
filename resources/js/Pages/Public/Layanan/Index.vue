<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    services: Object
});
</script>

<template>
    <PublicLayout>
        <Head title="Akses Layanan Internal" />
        <Banner
            title="PORTAL LAYANAN"
            subtitle="AKSES CEPAT FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <div class="bg-gray-50 py-12 md:py-24">
            <div class="container mx-auto px-6 lg:px-8">
                
                <div v-for="(categoryServices, categoryName) in services" :key="categoryName" class="mb-16">
                    <div class="flex items-center mb-8">
                        <div class="w-1 h-8 bg-[#133E87] mr-4"></div>
                        <h2 class="text-2xl font-kulim-park-bold text-[#133E87] uppercase tracking-wide">{{ categoryName || 'Layanan Umum' }}</h2>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                        <a 
                            v-for="service in categoryServices" 
                            :key="service.id"
                            :href="service.link_url"
                            target="_blank"
                            class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-[#4682A9] transform hover:-translate-y-1"
                            data-aos="fade-up"
                        >
                            <div class="flex items-center justify-center w-16 h-16 bg-[#CBDCEB] rounded-full mb-6 group-hover:bg-[#133E87] transition-colors">
                                <img v-if="service.icon_url" :src="service.icon_url" class="w-8 h-8" alt="icon">
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#133E87] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-inter-bold text-gray-800 group-hover:text-[#133E87] mb-2">{{ service.name }}</h3>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ service.description }}</p>
                        </a>
                    </div>
                </div>

                <div v-if="!services || Object.keys(services).length === 0" class="text-center py-20">
                    <div class="text-gray-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <p class="text-xl font-inter-semibold text-gray-500">Belum ada layanan internal yang ditambahkan.</p>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Kulim+Park:wght@700&display=swap');

.font-kulim-park-bold { font-family: 'Kulim Park', sans-serif; font-weight: 700; }
.font-inter-semibold { font-family: 'Inter', sans-serif; font-weight: 600; }
.font-inter-bold { font-family: 'Inter', sans-serif; font-weight: 700; }
</style>
