<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, computed } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { Target, Flag, Briefcase, Award, ExternalLink, FileDown, CheckCircle, GraduationCap, ArrowRight } from 'lucide-vue-next';

const props = defineProps({
    studyProgram: Object
});

const formatGoals = computed(() => {
    if (!props.studyProgram.goals) return [];
    return props.studyProgram.goals.split('\n').filter(goal => goal.trim() !== '');
});

onMounted(() => {
    AOS.init({ duration: 800, once: true });
});
</script>

<template>
    <PublicLayout>
        <Head :title="`${studyProgram.degree} ${studyProgram.name}`" />
        
        <Banner
            title="PROGRAM STUDI"
            :subtitle="`${studyProgram.degree} ${studyProgram.name}`.toUpperCase()"
            background-image="/images/background-banner.webp"
        />

        <section class="bg-white py-20 md:py-28 font-public-sans relative overflow-hidden">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl relative z-10">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-10 md:gap-16" data-aos="fade-up">
                    
                    <div class="md:w-1/3 flex-shrink-0 text-center md:text-left border-b md:border-b-0 md:border-r border-gray-100 pb-8 md:pb-0 md:pr-10">
                        <div class="inline-flex items-center justify-center p-4 bg-primary/10 rounded-2xl mb-6 text-primary">
                            <GraduationCap class="w-10 h-10" />
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-bold font-optimus text-gray-900 leading-tight mb-2">
                            {{ studyProgram.degree }} <br class="hidden md:block"/>
                            <span class="text-primary">{{ studyProgram.name }}</span>
                        </h1>
                        <p class="text-sm font-bold text-primary/80 uppercase tracking-widest mt-4">Profil Ringkas</p>
                    </div>
                    
                    <div class="md:w-2/3 md:pt-4 text-center md:text-justify">
                        <p class="text-gray-700 text-xl leading-relaxed font-medium m-0">
                            {{ studyProgram.description || 'Deskripsi profil ringkas untuk program studi ini belum ditambahkan.' }}
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <section v-if="studyProgram.vision" class="bg-white pb-16 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-5xl">
                <div class="bg-primary/5 rounded-3xl p-8 md:p-12 shadow-sm border border-primary/10" data-aos="fade-up">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 text-center md:text-left">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary flex-shrink-0 shadow-sm border border-primary/10">
                            <Target class="w-8 h-8" />
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-primary font-optimus mb-4">Visi Program Studi</h2>
                            <p class="text-gray-800 leading-relaxed text-xl m-0 font-medium italic">"{{ studyProgram.vision }}"</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="studyProgram.mission && studyProgram.mission.length > 0" class="bg-primary/5 py-20 md:py-24 border-y border-primary/10 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                <div class="grid lg:grid-cols-12 gap-10 items-start">
                    
                    <div class="lg:col-span-4 sticky top-28 text-center lg:text-left" data-aos="fade-right">
                        <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-4">Misi<br class="hidden lg:block"/> Program Studi</h2>
                        <div class="w-16 h-1 bg-primary mx-auto lg:mx-0 rounded-full mb-6"></div>
                        <p class="text-gray-600 font-medium text-lg">Langkah-langkah strategis yang diusung oleh {{ studyProgram.degree }} {{ studyProgram.name }} untuk mencapai Visi.</p>
                    </div>

                    <div class="lg:col-span-8 flex flex-col space-y-6 relative">
                        <div v-for="(misi, index) in studyProgram.mission" :key="index" class="flex items-start gap-6 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-primary/10 hover:border-primary/40 transition-all" data-aos="fade-left" :data-aos-delay="index * 50">
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

        <section v-if="studyProgram.goals" class="bg-white py-20 md:py-24 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-5xl">
                <div class="bg-primary/5 rounded-3xl p-8 md:p-12 shadow-sm border border-primary/10" data-aos="fade-up">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 text-center md:text-left mb-8">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary flex-shrink-0 shadow-sm border border-primary/10">
                            <Flag class="w-8 h-8" />
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-primary font-optimus m-0 mt-2">Tujuan Program Studi</h2>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-4 ml-0 md:ml-20">
                        <div v-for="(goal, index) in formatGoals" :key="index" class="flex items-start gap-4 bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:border-primary/30 transition-all">
                            <CheckCircle class="w-6 h-6 text-primary flex-shrink-0 mt-0.5" />
                            <p class="text-gray-700 leading-relaxed text-lg m-0">
                                {{ goal.replace(/^[0-9]+[\.\)]\s*/, '') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="studyProgram.graduate_profiles && studyProgram.graduate_profiles.length > 0" class="bg-primary/5 py-20 font-public-sans border-y border-primary/10">
            <div class="container mx-auto px-6 lg:px-8 text-center">
                <div class="text-center mb-14" data-aos="fade-up">
                    <Briefcase class="w-10 h-10 text-primary mx-auto mb-4" />
                    <h2 class="text-3xl md:text-4xl font-bold font-optimus text-primary mb-4">Profil Lulusan & Prospek Karier</h2>
                    <p class="text-gray-600 font-medium">Peluang karier unggulan bagi lulusan {{ studyProgram.name }}.</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4 max-w-5xl mx-auto">
                    <div v-for="(karir, index) in studyProgram.graduate_profiles" :key="index" 
                         class="bg-white border-2 border-primary/10 p-4 rounded-xl shadow-sm flex items-center gap-3 min-w-[240px] flex-grow md:flex-grow-0 text-left hover:border-primary/40 hover:shadow-md transition-all"
                         data-aos="zoom-in" :data-aos-delay="index * 50">
                        <CheckCircle class="w-5 h-5 text-primary flex-shrink-0" />
                        <span class="text-lg font-bold text-gray-800">
                            {{ karir.replace(/^[0-9]+[\.\)]\s*/, '') }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="studyProgram.accreditation_text || studyProgram.accreditation_certificate_image" class="bg-white py-24 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8 max-w-6xl">
                <div class="bg-primary rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row relative" data-aos="fade-up">
                    
                    <div class="p-10 md:p-14 flex flex-col text-white z-10 transition-all duration-500"
                         :class="studyProgram.accreditation_certificate_image ? 'md:w-1/2 justify-center' : 'w-full items-center text-center'">
                        
                        <div class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg font-bold text-sm mb-6 w-max border border-white/30 backdrop-blur-sm">
                            <Award class="w-5 h-5" /> Tersertifikasi Nasional
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold mb-6 font-optimus uppercase">Sertifikat Akreditasi</h2>
                        
                        <p class="text-blue-50 leading-relaxed mb-10 text-lg font-medium" 
                           :class="!studyProgram.accreditation_certificate_image ? 'max-w-2xl mx-auto' : ''">
                            {{ studyProgram.accreditation_text }}
                        </p>
                        
                        <div v-if="studyProgram.accreditation_pdf_link" class="mt-auto">
                            <a :href="studyProgram.accreditation_pdf_link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 py-3.5 px-6 bg-white text-primary hover:bg-gray-100 font-bold rounded-xl shadow-sm transition-colors w-max">
                                Unduh Sertifikat Resmi (PDF) <FileDown class="w-5 h-5" />
                            </a>
                        </div>
                    </div>

                    <div v-if="studyProgram.accreditation_certificate_image" class="md:w-1/2 bg-white relative min-h-[350px] flex items-center justify-center p-8 border-l-8 border-primary/20">
                        <img 
                            :src="studyProgram.accreditation_certificate_image" 
                            alt="Sertifikat Akreditasi" 
                            class="w-full h-full max-h-[450px] object-contain hover:scale-105 transition-transform duration-500 drop-shadow-md"
                        >
                    </div>

                </div>
            </div>
        </section>

        <section v-if="studyProgram.website_link" class="bg-white py-20 pb-28 font-public-sans border-t border-gray-100">
            <div class="container mx-auto px-6 lg:px-8 text-center" data-aos="fade-up">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 text-primary shadow-sm border border-primary/10">
                    <ExternalLink class="w-10 h-10" />
                </div>
                <h2 class="text-3xl md:text-4xl font-bold font-optimus text-gray-900 mb-6">Ingin Tahu Lebih Banyak?</h2>
                <p class="text-gray-600 font-medium text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
                    Kunjungi website resmi Program Studi {{ studyProgram.name }} untuk informasi detail mengenai kurikulum, kegiatan mahasiswa, hingga pendaftaran.
                </p>
                <a :href="studyProgram.website_link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-3 bg-primary text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:bg-opacity-90 hover:shadow-xl transition-all hover:-translate-y-1">
                    Kunjungi Website Resmi <ArrowRight class="w-6 h-6" />
                </a>
            </div>
        </section>

    </PublicLayout>
</template>