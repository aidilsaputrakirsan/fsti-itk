<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { MapPin, Clock, Map, GraduationCap, Wallet, Mail } from 'lucide-vue-next';

defineProps({
    contact: Object
});
</script>

<template>
    <PublicLayout>
        <Head title="Kontak FSTI" />
        <Banner
            title="KONTAK KAMI"
            subtitle="HUBUNGI DAN TEMUKAN KAMI DI KAMPUS FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white py-16 md:py-24 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8">

                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-3 tracking-tight">
                        Alamat & Jam Operasional
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg max-w-2xl mx-auto">
                        Temukan lokasi Fakultas Sains dan Teknologi Informasi (FSTI) ITK beserta jam layanan yang dapat Anda kunjungi.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 max-w-6xl mx-auto">
                    <div class="flex flex-col gap-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="bg-gray-50 rounded-3xl p-8 flex items-start space-x-5 border border-gray-100 hover:shadow-md transition duration-300">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-primary shadow-sm transform -rotate-3">
                                    <MapPin class="h-6 w-6 text-white" />
                                </span>
                            </div>
                            <div class="w-full">
                                <h3 class="text-gray-900 text-2xl font-bold mb-2">Alamat</h3>
                                <hr class="border-t-2 border-primary w-12 mb-4">
                                <p class="text-gray-600 leading-relaxed whitespace-pre-wrap">
                                    {{ contact?.address || 'Alamat belum diatur oleh sistem.' }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-3xl p-8 flex items-start space-x-5 border border-gray-100 hover:shadow-md transition duration-300">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-primary shadow-sm transform rotate-3">
                                    <Clock class="h-6 w-6 text-white" />
                                </span>
                            </div>
                            <div class="w-full">
                                <h3 class="text-gray-900 text-2xl font-bold mb-2">Jam Operasional</h3>
                                <hr class="border-t-2 border-primary w-12 mb-4">
                                <p class="text-gray-600 leading-relaxed">
                                    {{ contact?.operating_hours || 'Jam operasional belum diatur.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 shadow-lg rounded-3xl p-6 flex flex-col hover:shadow-xl transition duration-300" data-aos="fade-left" data-aos-delay="200">
                        <div class="flex items-center space-x-4 mb-6">
                            <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-blue-50">
                                <Map class="h-6 w-6 text-primary" />
                            </span>
                            <h3 class="text-gray-900 text-xl font-bold">Peta Lokasi</h3>
                        </div>
                        <div class="w-full flex-grow rounded-2xl overflow-hidden min-h-[300px] bg-gray-100 border border-gray-100">
                            <iframe
                                v-if="contact?.google_maps_iframe"
                                :src="contact.google_maps_iframe"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                            <div v-else class="flex h-full items-center justify-center text-gray-400">Peta belum diatur</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-primary py-16 md:py-24 font-public-sans relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute -top-32 -right-32 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 -left-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            </div>

            <div class="container mx-auto px-6 lg:px-8 max-w-6xl relative z-10">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold font-optimus text-white mb-4 tracking-tight drop-shadow-md">
                        Layanan Komunikasi & Konsultasi
                    </h2>
                    <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto">
                        Hubungi kami untuk pertanyaan akademik, keuangan, maupun informasi resmi lainnya.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-4xl mx-auto">
                    <a :href="contact?.academic_wa_link || '#'" target="_blank" rel="noopener noreferrer" class="group block" data-aos="fade-up" data-aos-delay="100">
                        <div class="bg-white rounded-3xl p-8 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 h-full text-center border-b-4 border-transparent hover:border-[#00509D] relative overflow-hidden">
                            <div class="relative z-10 flex flex-col items-center">
                                <span class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-blue-50 text-primary shadow-sm mb-5 group-hover:bg-primary group-hover:text-white transition-all duration-300 group-hover:scale-110">
                                    <GraduationCap class="h-8 w-8" />
                                </span>
                                <h3 class="text-gray-900 font-extrabold text-2xl mb-1">Layanan Akademik</h3>
                                <p class="text-gray-500 text-sm mb-6">WhatsApp (Chat Only)</p>
                                <div class="bg-gray-50 px-6 py-3 rounded-full border border-gray-100 group-hover:bg-[#00509D] group-hover:border-[#00509D] transition-colors duration-300 w-full">
                                    <p class="text-primary group-hover:text-white font-bold text-lg tracking-wide">{{ contact?.academic_wa_number || '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a :href="contact?.finance_wa_link || '#'" target="_blank" rel="noopener noreferrer" class="group block" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-white rounded-3xl p-8 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 h-full text-center border-b-4 border-transparent hover:border-[#00509D] relative overflow-hidden">
                            <div class="relative z-10 flex flex-col items-center">
                                <span class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-blue-50 text-primary shadow-sm mb-5 group-hover:bg-primary group-hover:text-white transition-all duration-300 group-hover:scale-110">
                                    <Wallet class="h-8 w-8" />
                                </span>
                                <h3 class="text-gray-900 font-extrabold text-2xl mb-1">Layanan Keuangan</h3>
                                <p class="text-gray-500 text-sm mb-6">WhatsApp (Chat Only)</p>
                                <div class="bg-gray-50 px-6 py-3 rounded-full border border-gray-100 group-hover:bg-[#00509D] group-hover:border-[#00509D] transition-colors duration-300 w-full">
                                    <p class="text-primary group-hover:text-white font-bold text-lg tracking-wide">{{ contact?.finance_wa_number || '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="flex justify-center mt-6 lg:mt-8 max-w-4xl mx-auto">
                    <div class="w-full md:w-[calc(50%-0.75rem)]">
                        <a :href="`mailto:${contact?.email || 'fsti@itk.ac.id'}`" class="group block" data-aos="fade-up" data-aos-delay="300">
                            <div class="bg-white rounded-3xl p-8 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 h-full text-center border-b-4 border-transparent hover:border-[#00509D] relative overflow-hidden">
                                <div class="relative z-10 flex flex-col items-center">
                                    <span class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-blue-50 text-primary shadow-sm mb-5 group-hover:bg-primary group-hover:text-white transition-all duration-300 group-hover:scale-110">
                                        <Mail class="h-8 w-8" />
                                    </span>
                                    <h3 class="text-gray-900 font-extrabold text-2xl mb-1">Email Resmi</h3>
                                    <p class="text-gray-500 text-sm mb-6">Surel Kelembagaan</p>
                                    <div class="bg-gray-50 px-6 py-3 rounded-full border border-gray-100 group-hover:bg-[#00509D] group-hover:border-[#00509D] transition-colors duration-300 w-full overflow-hidden">
                                        <p class="text-primary group-hover:text-white font-bold text-lg tracking-wide truncate">{{ contact?.email || '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-gray-50 py-16 md:py-24 font-public-sans border-t border-gray-200">
            <div class="container mx-auto px-6 lg:px-8 max-w-4xl">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-3 tracking-tight">
                        Media Sosial Resmi
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg">
                        Ikuti akun resmi FSTI ITK untuk mendapatkan pembaruan kegiatan dan konten menarik lainnya.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <a :href="contact?.instagram_link || '#'" target="_blank" rel="noopener noreferrer" class="group block" data-aos="zoom-in" data-aos-delay="100">
                        <div class="bg-white rounded-3xl p-8 flex flex-col items-center text-center border border-gray-100 shadow-sm hover:border-primary/40 hover:shadow-lg hover:-translate-y-2 transition-all duration-300">
                            <span class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-primary text-white shadow-md mb-5 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                </svg>
                            </span>
                            <h3 class="text-gray-900 font-bold text-xl mb-1">Instagram</h3>
                            <p class="text-primary font-semibold">{{ contact?.instagram_username || '-' }}</p>
                        </div>
                    </a>

                    <a :href="contact?.tiktok_link || '#'" target="_blank" rel="noopener noreferrer" class="group block" data-aos="zoom-in" data-aos-delay="200">
                        <div class="bg-white rounded-3xl p-8 flex flex-col items-center text-center border border-gray-100 shadow-sm hover:border-primary/40 hover:shadow-lg hover:-translate-y-2 transition-all duration-300">
                            <span class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-primary text-white shadow-md mb-5 group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 449.45 515.38" fill="currentColor">
                                    <path d="M382.31 103.3c-27.76-18.1-47.79-47.07-54.04-80.82-1.35-7.29-2.1-14.8-2.1-22.48h-88.6l-.15 355.09c-1.48 39.77-34.21 71.68-74.33 71.68-12.47 0-24.21-3.11-34.55-8.56-23.71-12.47-39.94-37.32-39.94-65.91 0-41.07 33.42-74.49 74.48-74.49 7.67 0 15.02 1.27 21.97 3.44V190.8c-7.2-.99-14.51-1.59-21.97-1.59C73.16 189.21 0 262.36 0 352.3c0 55.17 27.56 104 69.63 133.52 26.48 18.61 58.71 29.56 93.46 29.56 89.93 0 163.08-73.16 163.08-163.08V172.23c34.75 24.94 77.33 39.64 123.28 39.64v-88.61c-24.75 0-47.8-7.35-67.14-19.96z"/>
                                </svg>
                            </span>
                            <h3 class="text-gray-900 font-bold text-xl mb-1">TikTok</h3>
                            <p class="text-primary font-semibold">{{ contact?.tiktok_username || '-' }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </PublicLayout>
</template>