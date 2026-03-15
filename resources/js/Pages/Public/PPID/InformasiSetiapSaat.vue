<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, Link } from '@inertiajs/vue3';

// Menerima data dinamis dari database (via Controller)
const props = defineProps({
    kategoris: Array
});
</script>

<template>
    <PublicLayout>
        <Head title="Informasi Wajib Setiap Saat - PPID FSTI" />
        
        <Banner
            title="PPID - FSTI ITK"
            subtitle="DAFTAR INFORMASI PUBLIK FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <section class="bg-white py-12 md:py-20 min-h-screen font-inter">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                
                <div class="mb-8">
                    <Link href="/ppid" class="inline-flex items-center text-sm font-inter-semibold text-gray-900 hover:text-[#133E87] transition-colors group">
                        <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-3 group-hover:border-[#133E87] group-hover:bg-[#CBDCEB]/30 transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                        Kembali ke Beranda PPID
                    </Link>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-10 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#133E87]"></div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-kulim-park-bold text-[#133E87] mb-2">Katalog Dokumen Setiap Saat</h2>
                        <p class="text-gray-900 font-inter-semibold text-sm md:text-[15px]">Informasi publik yang wajib tersedia setiap saat oleh Fakultas Sains dan Teknologi Informasi.</p>
                    </div>
                </div>

                <div v-if="kategoris && kategoris.length > 0" class="space-y-10">
                    <div 
                        v-for="kat in kategoris" 
                        :key="kat.id" 
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
                    >
                        <div class="bg-[#CBDCEB]/40 px-6 py-5 border-b border-[#CBDCEB]/80 flex items-center justify-between">
                            <h3 class="text-[17px] md:text-lg font-kulim-park-bold text-[#133E87] flex items-start md:items-center tracking-tight leading-snug">
                                <div class="mr-3 mt-1 md:mt-0 text-[#4682A9] flex-shrink-0" v-html="kat.icon"></div>
                                {{ kat.nama_kategori }}
                            </h3>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <div 
                                v-for="doc in kat.dokumen" 
                                :key="doc.id"
                                class="group flex flex-col md:flex-row md:items-center justify-between p-5 md:px-6 hover:bg-[#CBDCEB]/10 transition-all duration-300 relative"
                            >
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#4682A9] scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-center"></div>

                                <div class="flex items-center mb-4 md:mb-0 pr-4 transform group-hover:translate-x-1 transition-transform duration-300">
                                    <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg border border-gray-200 text-[#4682A9] shadow-sm mr-4 group-hover:bg-[#133E87] group-hover:text-white group-hover:border-[#133E87] transition-all flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="font-inter-bold text-gray-900 group-hover:text-[#133E87] text-sm md:text-[15px] leading-relaxed">
                                        {{ doc.judul_dokumen }}
                                    </span>
                                </div>

                                <a 
                                    :href="doc.file_url"
                                    target="_blank"
                                    class="inline-flex items-center justify-center px-5 py-2 bg-white text-gray-900 hover:text-white hover:bg-[#133E87] border border-gray-200 hover:border-[#133E87] font-inter-semibold text-sm rounded-lg transition-all duration-300 flex-shrink-0 shadow-sm"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-500 font-inter-semibold">Sedang memuat data dokumen...</p>
                </div>

            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Kulim+Park:wght@600;700&display=swap');

.font-kulim-park-bold { font-family: 'Kulim Park', sans-serif; font-weight: 700; }
.font-inter-semibold { font-family: 'Inter', sans-serif; font-weight: 600; }
.font-inter-bold { font-family: 'Inter', sans-serif; font-weight: 700; }
</style>