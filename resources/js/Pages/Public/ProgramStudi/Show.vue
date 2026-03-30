<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, computed } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { Target, Flag, Briefcase, Award, ExternalLink, FileDown, CheckCircle, GraduationCap } from 'lucide-vue-next';

const props = defineProps({
    prodi: Object
});

const formatGoals = computed(() => {
    if (!props.prodi.goals) return [];
    return props.prodi.goals.split('\n').filter(goal => goal.trim() !== '');
});

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});
</script>

<template>
    <PublicLayout>
        <Head :title="`${prodi.degree} ${prodi.name}`" />
        
        <Banner
            title="PROGRAM STUDI"
            :subtitle="`${prodi.degree} ${prodi.name}`.toUpperCase()"
            background-image="/images/background-banner.png"
        />

        <section class="bg-gray-50 pb-20 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl relative z-10 -mt-10 md:-mt-16">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12" data-aos="fade-up">
                    <div class="grid md:grid-cols-12 gap-8 items-center">
                        <div class="md:col-span-4 text-center md:text-left border-b md:border-b-0 md:border-r border-gray-200 pb-6 md:pb-0 md:pr-8">
                            <div class="inline-flex items-center justify-center p-4 bg-primary/10 rounded-2xl mb-6 text-primary">
                                <GraduationCap class="w-10 h-10" />
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-bold font-optimus text-gray-900 leading-tight mb-2">
                                {{ prodi.degree }} <br class="hidden md:block"/>
                                <span class="text-primary">{{ prodi.name }}</span>
                            </h1>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Profil Ringkas</p>
                        </div>
                        
                        <div class="md:col-span-8 text-center md:text-justify">
                            <p class="text-gray-700 text-lg leading-relaxed font-medium m-0">
                                {{ prodi.description || 'Deskripsi profil ringkas untuk program studi ini belum ditambahkan.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="prodi.vision || prodi.goals" class="bg-white py-16 md:py-24 border-t border-gray-200 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-5xl">
                <div class="flex flex-col gap-10">
                    
                    <div v-if="prodi.vision" class="bg-gray-50 rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100" data-aos="fade-up">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 text-center md:text-left">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary flex-shrink-0 shadow-sm border border-gray-100">
                                <Target class="w-8 h-8" />
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 font-optimus mb-4">Visi Program Studi</h3>
                                <p class="text-gray-800 leading-relaxed text-xl m-0 font-medium italic">"{{ prodi.vision }}"</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="prodi.goals" class="bg-gray-50 rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 text-center md:text-left mb-8">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary flex-shrink-0 shadow-sm border border-gray-100">
                                <Flag class="w-8 h-8" />
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 font-optimus m-0 mt-2">Tujuan Program Studi</h3>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4 ml-0 md:ml-20">
                            <div v-for="(goal, index) in formatGoals" :key="index" class="flex items-start gap-4 bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                                <CheckCircle class="w-6 h-6 text-primary flex-shrink-0 mt-0.5" />
                                <p class="text-gray-700 leading-relaxed text-lg m-0">
                                    {{ goal.replace(/^[0-9]+[\.\)]\s*/, '') }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section v-if="prodi.mission && prodi.mission.length > 0" class="bg-gray-50 py-16 md:py-24 border-y border-gray-200 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                <div class="grid lg:grid-cols-12 gap-10 items-start">
                    
                    <div class="lg:col-span-4 sticky top-28 text-center lg:text-left" data-aos="fade-right">
                        <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-4">Misi<br class="hidden lg:block"/> Program Studi</h2>
                        <div class="w-16 h-1 bg-primary mx-auto lg:mx-0 rounded-full mb-6"></div>
                        <p class="text-gray-600 font-medium text-lg">Langkah-langkah strategis yang diusung oleh {{ prodi.degree }} {{ prodi.name }} untuk mencapai Visi.</p>
                    </div>

                    <div class="lg:col-span-8 flex flex-col space-y-6 relative">
                        <div v-for="(misi, index) in prodi.mission" :key="index" class="flex items-start gap-6 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 hover:border-primary/40 transition-all" data-aos="fade-left" :data-aos-delay="index * 50">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xl font-bold">
                                {{ index + 1 }}
                            </div>
                            <p class="text-gray-700 leading-relaxed text-lg m-0 pt-1">
                                {{ misi.replace(/^[0-9]+[\.\)]\s*/, '') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section v-if="prodi.graduate_profiles && prodi.graduate_profiles.length > 0" class="bg-white py-20 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 text-center">
                <div class="text-center mb-14" data-aos="fade-up">
                    <div class="inline-block p-4 bg-gray-50 rounded-2xl mb-4 shadow-sm border border-gray-100">
                        <Briefcase class="w-8 h-8 text-primary" />
                    </div>
                    <h2 class="text-3xl font-bold font-optimus text-gray-900 mb-4">Profil Lulusan & Prospek Karier</h2>
                </div>

                <div class="flex flex-wrap justify-center gap-4 max-w-5xl mx-auto">
                    <div v-for="(karir, index) in prodi.graduate_profiles" :key="index" 
                         class="bg-gray-50 border border-gray-200 p-4 rounded-xl shadow-sm flex items-center gap-3 min-w-[240px] flex-grow md:flex-grow-0 text-left"
                         data-aos="zoom-in" :data-aos-delay="index * 50">
                        <CheckCircle class="w-5 h-5 text-primary flex-shrink-0" />
                        <span class="text-lg font-bold text-gray-800">
                            {{ karir.replace(/^[0-9]+[\.\)]\s*/, '') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="prodi.accreditation_text || prodi.accreditation_certificate_image" class="bg-gray-50 py-24 font-public-sans border-t border-gray-200">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                <div class="bg-primary rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative" data-aos="fade-up">
                    
                    <div class="p-10 md:p-14 md:w-1/2 flex flex-col justify-center text-white z-10">
                        <div class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg font-bold text-sm mb-6 w-max border border-white/30 backdrop-blur-sm">
                            <Award class="w-5 h-5" /> Tersertifikasi Nasional
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6 font-optimus uppercase">Sertifikat Akreditasi</h2>
                        <p class="text-blue-50 leading-relaxed mb-10 text-lg font-medium">
                            {{ prodi.accreditation_text }}
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                            <a v-if="prodi.website_link" :href="prodi.website_link" target="_blank" rel="noopener noreferrer" class="text-center py-3.5 px-6 bg-white text-primary hover:bg-gray-100 font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                                Kunjungi Website <ExternalLink class="w-5 h-5" />
                            </a>
                            <a v-if="prodi.accreditation_pdf_link" :href="prodi.accreditation_pdf_link" target="_blank" rel="noopener noreferrer" class="text-center py-3.5 px-6 bg-transparent border-2 border-white text-white hover:bg-white/10 font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                                Unduh (PDF) <FileDown class="w-5 h-5" />
                            </a>
                        </div>
                    </div>

                    <div class="md:w-1/2 bg-white relative min-h-[400px] flex items-center justify-center p-6 border-l-8 border-primary/20">
                        <img 
                            v-if="prodi.accreditation_certificate_image" 
                            :src="prodi.accreditation_certificate_image" 
                            alt="Sertifikat Akreditasi" 
                            class="w-full h-full max-h-[500px] object-contain hover:scale-105 transition-transform duration-500 drop-shadow-md"
                        >
                        <div v-else class="flex flex-col gap-3 items-center justify-center text-gray-400 font-medium">
                            <FileDown class="w-12 h-12 text-gray-300" /> <span class="text-gray-400">Preview Tidak Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>