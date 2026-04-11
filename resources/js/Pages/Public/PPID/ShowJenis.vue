<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    kategoris: Array,
    jenis_informasi: String 
});
</script>

<template>
    <PublicLayout>
        <Head :title="`Informasi ${jenis_informasi} - PPID FSTI`" />
        
        <Banner
            title="PPID - FSTI ITK"
            :subtitle="`INFORMASI ${jenis_informasi.toUpperCase()}`"
            background-image="/images/background-banner.png"
        />

        <section class="bg-white py-12 md:py-20 min-h-screen font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                
                <div class="mb-8">
                    <Link href="/ppid" class="inline-flex items-center text-sm font-semibold text-gray-900 hover:text-primary transition-colors group">
                        <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-3 group-hover:border-primary group-hover:bg-primary/10 transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                        Kembali ke Beranda PPID
                    </Link>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-10 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-optimus font-bold text-primary mb-2">Katalog Dokumen {{ jenis_informasi }}</h2>
                        <p class="text-gray-900 font-medium text-sm md:text-[15px]">Informasi publik tingkat fakultas yang masuk dalam kategori {{ jenis_informasi }}.</p>
                    </div>
                </div>

                <div v-if="kategoris && kategoris.length > 0" class="space-y-10">
                    <div v-for="kat in kategoris" :key="kat.id" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        
                        <div class="bg-primary/10 px-6 py-5 border-b border-primary/20 flex items-center">
                            <div class="mr-3 text-primary flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <h3 class="text-[17px] md:text-lg font-optimus font-bold text-primary tracking-tight leading-snug">
                                {{ kat.nama_kategori }}
                            </h3>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <div v-for="doc in kat.dokumen" :key="doc.id" class="group flex flex-col md:flex-row md:items-center justify-between p-5 md:px-6 hover:bg-primary/5 transition-all duration-300 relative">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-center"></div>

                                <div class="flex items-center mb-4 md:mb-0 pr-4 transform group-hover:translate-x-1 transition-transform duration-300">
                                    <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg border border-gray-200 text-primary shadow-sm mr-4 group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-900 group-hover:text-primary text-sm md:text-[15px] leading-relaxed">
                                        {{ doc.judul_dokumen }}
                                    </span>
                                </div>

                                <a :href="doc.file_url" target="_blank" class="inline-flex items-center justify-center px-5 py-2 bg-white text-gray-900 hover:text-white hover:bg-primary border border-gray-200 hover:border-primary font-semibold text-sm rounded-lg transition-all duration-300 flex-shrink-0 shadow-sm">
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

                <div v-else class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-500 font-semibold">Belum ada kategori informasi untuk klasifikasi ini.</p>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>