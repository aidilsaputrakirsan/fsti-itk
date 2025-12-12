<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    documents: Object
});

const activeTab = ref(Object.keys(props.documents)[0] || 'Informasi Berkala');
</script>

<template>
    <PublicLayout>
        <Head title="PPID" />
        <Banner
            title="PPID - FSTI ITK"
            subtitle="PEJABAT PENGELOLA INFORMASI DAN DOKUMENTASI"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white py-12 md:py-24">
            <div class="container mx-auto px-6 lg:px-8">
                <!-- Tabs -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <button 
                        v-for="(docs, category) in documents" 
                        :key="category"
                        @click="activeTab = category"
                        :class="[
                            'px-6 py-2 rounded-full font-inter-semibold transition-all duration-300',
                            activeTab === category 
                                ? 'bg-[#133E87] text-white shadow-lg' 
                                : 'bg-[#CBDCEB] text-[#133E87] hover:bg-[#133E87] hover:text-white'
                        ]"
                    >
                        {{ category }}
                    </button>
                </div>

                <!-- Content -->
                <div v-show="documents[activeTab]">
                    <h2 class="text-3xl font-kulim-park-bold text-[#4682A9] mb-8 text-center">{{ activeTab }}</h2>
                    
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <div 
                            v-for="doc in documents[activeTab]" 
                            :key="doc.id"
                            class="bg-[#F3F4F6] p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border-l-4 border-[#133E87]"
                        >
                            <h3 class="font-inter-bold text-xl text-[#133E87] mb-2">{{ doc.title }}</h3>
                            <p v-if="doc.description" class="text-gray-600 mb-4 text-sm">{{ doc.description }}</p>
                            
                            <a 
                                v-if="doc.file_path"
                                :href="'/storage/' + doc.file_path" 
                                target="_blank"
                                class="inline-flex items-center text-[#4682A9] font-inter-semibold hover:underline"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Unduh Dokumen
                            </a>
                        </div>
                    </div>
                </div>

                <div v-if="!documents || Object.keys(documents).length === 0" class="text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada dokumen yang tersedia saat ini.</p>
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
