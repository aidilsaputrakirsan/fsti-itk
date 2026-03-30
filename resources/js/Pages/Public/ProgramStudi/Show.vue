<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { Target, Flag, Briefcase, Award, ExternalLink, FileDown, BookMarked, CheckCircleIcon } from 'lucide-vue-next';

defineProps({
    prodi: Object
});

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});
</script>

<template>
    <PublicLayout>
        <Head :title="`Program Studi ${prodi.name}`" />
        
        <Banner
            title="PROGRAM STUDI"
            :subtitle="`${prodi.degree} ${prodi.name}`.toUpperCase()"
            background-image="/images/background-banner.png"
        />

        <section class="bg-white py-20 font-public-sans relative">
            <div class="container mx-auto px-6 lg:px-8 max-w-4xl text-center">
                <div data-aos="fade-up">
                    <BookMarked class="w-12 h-12 text-[#4682A9] mx-auto mb-6 opacity-80" />
                    <h2 class="text-3xl font-bold font-optimus text-gray-900 mb-6">Profil Ringkas</h2>
                    <div class="w-16 h-1 bg-[#4682A9] mx-auto mb-8 rounded-full"></div>
                    <p v-if="prodi.description" class="text-gray-700 text-lg leading-relaxed text-justify md:text-center">
                        {{ prodi.description }}
                    </p>
                </div>
            </div>
        </section>

        <section v-if="prodi.vision || prodi.goals" class="bg-gray-50 py-16 border-y border-gray-200">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                <div class="grid md:grid-cols-2 gap-10">
                    
                    <div v-if="prodi.vision" class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100" data-aos="fade-right">
                        <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-[#4682A9]">
                                <Target class="w-6 h-6" />
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-optimus">Visi</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed text-lg">{{ prodi.vision }}</p>
                    </div>

                    <div v-if="prodi.goals" class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100" data-aos="fade-left" data-aos-delay="100">
                        <div class="flex items-center gap-4 mb-6 border-b border-gray-100 pb-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-[#4682A9]">
                                <Flag class="w-6 h-6" />
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 font-optimus">Tujuan</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-line space-y-2">{{ prodi.goals }}</p>
                    </div>

                </div>
            </div>
        </section>

        <section v-if="prodi.mission && prodi.mission.length > 0" class="bg-white py-20">
            <div class="container mx-auto px-6 lg:px-8 max-w-5xl">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl font-bold font-optimus text-gray-900 mb-4">Misi Program Studi</h2>
                    <div class="w-16 h-1 bg-[#4682A9] mx-auto rounded-full"></div>
                </div>

                <div class="space-y-4">
                    <div v-for="(misi, index) in prodi.mission" :key="index" 
                         class="flex items-start gap-5 bg-white p-6 rounded-xl border border-gray-200 shadow-sm hover:border-[#4682A9] transition duration-300"
                         data-aos="fade-up" :data-aos-delay="index * 50">
                        
                        <div class="shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-[#4682A9] text-white font-bold shadow-md">
                            {{ index + 1 }}
                        </div>
                        
                        <p class="text-gray-700 leading-relaxed pt-1 text-lg">
                            {{ misi.replace(/^[0-9]+[\.\)]\s*/, '') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="prodi.graduate_profiles && prodi.graduate_profiles.length > 0" class="bg-[#CBDCEB] py-20 border-y border-white">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl text-center">
                <div data-aos="fade-up" class="mb-10">
                    <Briefcase class="w-12 h-12 text-[#4682A9] mx-auto mb-4" />
                    <h2 class="text-3xl font-bold font-optimus text-gray-900 mb-4">Profil Lulusan & Prospek Karier</h2>
                </div>

                <div class="flex flex-wrap justify-center gap-4 max-w-4xl mx-auto">
                    <div v-for="(karir, index) in prodi.graduate_profiles" :key="index" 
                         class="bg-white border border-gray-200 text-gray-800 font-bold px-6 py-3 rounded-lg shadow-sm flex items-center gap-3"
                         data-aos="zoom-in" :data-aos-delay="index * 50">
                        <CheckCircleIcon class="w-5 h-5 text-[#4682A9]" />
                        {{ karir }}
                    </div>
                </div>
            </div>
        </section>

        <section v-if="prodi.accreditation_text || prodi.accreditation_certificate_image" class="bg-white py-24">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                <div class="bg-[#4682A9] rounded-2xl overflow-hidden shadow-xl flex flex-col md:flex-row" data-aos="fade-up">
                    
                    <div class="p-10 md:p-12 md:w-3/5 flex flex-col justify-center text-white">
                        <div class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg font-bold text-sm mb-6 w-max border border-white/30">
                            <Award class="w-5 h-5" /> Tersertifikasi Nasional
                        </div>
                        <h2 class="text-3xl font-bold mb-4 font-optimus">Sertifikat Akreditasi</h2>
                        <p class="text-blue-50 leading-relaxed mb-8 text-lg">
                            {{ prodi.accreditation_text }}
                        </p>
                        
                        <div class="flex flex-wrap gap-4 mt-auto">
                            <a v-if="prodi.website_link" :href="prodi.website_link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-white text-[#4682A9] font-bold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">
                                Kunjungi Website Resmi <ExternalLink class="w-4 h-4" />
                            </a>
                            <a v-if="prodi.accreditation_pdf_link" :href="prodi.accreditation_pdf_link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-blue-900 text-white font-bold px-6 py-3 rounded-lg shadow hover:bg-blue-800 transition">
                                Unduh Sertifikat (PDF) <FileDown class="w-4 h-4" />
                            </a>
                        </div>
                    </div>

                    <div class="md:w-2/5 bg-gray-100 relative min-h-[300px]">
                        <img v-if="prodi.accreditation_certificate_image" :src="prodi.accreditation_certificate_image" alt="Preview Sertifikat" class="absolute inset-0 w-full h-full object-cover border-l border-white/20">
                        <div v-else class="absolute inset-0 flex flex-col gap-2 items-center justify-center text-gray-400 font-medium">
                            <FileDown :size="40" /> Belum ada preview gambar
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>