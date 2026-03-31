<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { Briefcase, Award, BookOpen, UserCircle, X, ChevronRight, GraduationCap, Link as LinkIcon, BadgeCheck } from 'lucide-vue-next';

defineProps({
    dosen: Array
});

const isModalOpen = ref(false);
const selectedPerson = ref(null);

const openModal = (person) => {
    selectedPerson.value = person;
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => { selectedPerson.value = null; }, 300);
    document.body.style.overflow = 'auto';
};

onMounted(() => { AOS.init({ duration: 800, once: true }); });
</script>

<template>
    <PublicLayout>
        <Head title="Daftar Dosen" />
        <Banner title="DOSEN" subtitle="Fakultas Sains dan Teknologi Informasi" background-image="/images/background-banner.png" />

        <div class="bg-gray-50 py-20 md:py-28 font-public-sans min-h-screen">
            <div class="container mx-auto px-6 max-w-7xl">
                
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4">
                        Tenaga Pendidik <span class="text-primary">(Dosen)</span>
                    </h2>
                    <div class="w-20 h-1.5 bg-primary mx-auto rounded-full mb-6"></div>
                    <p class="text-gray-600 font-medium text-lg">Mengenal lebih dekat para pakar dan akademisi di lingkungan FSTI ITK.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    <div v-for="(person, index) in dosen" :key="person.id" 
                         class="bg-white rounded-3xl shadow-sm border border-primary/10 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col group"
                         data-aos="fade-up" :data-aos-delay="index * 50">
                        
                        <div class="h-80 w-full bg-primary/5 relative overflow-hidden">
                            <img :src="person.display_image" :alt="person.name" 
                                 class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500 mix-blend-multiply">
                        </div>

                        <div class="p-8 flex flex-col flex-grow text-center">
                            <h3 class="font-optimus font-bold text-xl text-gray-900 mb-3 leading-tight">{{ person.name }}</h3>
                            <p class="text-sm font-bold text-primary uppercase tracking-wide mb-6">{{ person.functional_position || 'Dosen ITK' }}</p>
                            
                            <div class="mt-auto pt-6 border-t border-gray-100">
                                <button @click="openModal(person)" class="inline-flex items-center justify-center gap-2 w-full py-3 bg-primary/10 text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition-colors">
                                    Lihat Profil Lengkap
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 sm:p-6 font-public-sans" @click.self="closeModal">
                
                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden flex flex-col transform transition-all" v-if="selectedPerson">
                    
                    <div class="bg-primary p-6 flex items-center justify-between text-white flex-shrink-0">
                        <h3 class="text-xl font-bold font-optimus tracking-wide">Profil Akademik</h3>
                        <button @click="closeModal" class="p-2 bg-white/20 hover:bg-white/40 rounded-full transition-colors"><X class="w-6 h-6" /></button>
                    </div>

                    <div class="p-6 md:p-10 overflow-y-auto">
                        <div class="flex flex-col lg:flex-row gap-10">
                            
                            <div class="lg:w-1/3 flex-shrink-0 text-center">
                                <div class="w-48 h-48 mx-auto rounded-full border-4 border-primary/20 p-2 mb-6 bg-primary/5">
                                    <img :src="selectedPerson.display_image" :alt="selectedPerson.name" class="w-full h-full object-cover rounded-full mix-blend-multiply">
                                </div>
                                <h2 class="text-2xl font-bold font-optimus text-gray-900 leading-tight mb-2">{{ selectedPerson.name }}</h2>
                                <p v-if="selectedPerson.nip" class="text-gray-500 font-medium mb-4">NIP/NIPH. {{ selectedPerson.nip }}</p>
                                
                                <div class="space-y-3 text-left bg-gray-50 p-5 rounded-2xl border border-gray-100 mt-6">
                                    <div v-if="selectedPerson.structural_position" class="flex items-start gap-3">
                                        <Briefcase class="w-5 h-5 text-primary flex-shrink-0" />
                                        <span class="text-sm font-semibold text-gray-700">{{ selectedPerson.structural_position }}</span>
                                    </div>
                                    <div v-if="selectedPerson.functional_position" class="flex items-start gap-3">
                                        <UserCircle class="w-5 h-5 text-primary flex-shrink-0" />
                                        <span class="text-sm font-semibold text-gray-700">{{ selectedPerson.functional_position }}</span>
                                    </div>
                                </div>

                                <div v-if="selectedPerson.academic_profiles && selectedPerson.academic_profiles.length > 0" class="mt-6 flex flex-wrap justify-center gap-2">
                                    <a v-for="(link, i) in selectedPerson.academic_profiles" :key="i" :href="link" target="_blank" rel="noopener noreferrer" class="p-2.5 bg-primary/10 text-primary rounded-xl hover:bg-primary hover:text-white transition-colors">
                                        <LinkIcon class="w-5 h-5" />
                                    </a>
                                </div>
                            </div>

                            <div class="lg:w-2/3 flex flex-col gap-8">
                                
                                <div v-if="selectedPerson.expertise && selectedPerson.expertise.length > 0">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-primary mb-4 border-b border-primary/10 pb-2"><BookOpen class="w-6 h-6" /> Bidang Keahlian</h4>
                                    <div class="flex flex-wrap gap-2">
                                        <span v-for="(expert, i) in selectedPerson.expertise" :key="i" class="px-3 py-1.5 bg-blue-50 text-blue-700 text-sm font-bold rounded-lg border border-blue-100">
                                            {{ expert }}
                                        </span>
                                    </div>
                                </div>

                                <div v-if="selectedPerson.education_history && selectedPerson.education_history.length > 0">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-primary mb-4 border-b border-primary/10 pb-2"><GraduationCap class="w-6 h-6" /> Riwayat Pendidikan</h4>
                                    <ul class="space-y-3">
                                        <li v-for="(edu, i) in selectedPerson.education_history" :key="i" class="flex items-start gap-3 text-gray-700">
                                            <ChevronRight class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" /> {{ edu }}
                                        </li>
                                    </ul>
                                </div>

                                <div v-if="selectedPerson.work_experience && selectedPerson.work_experience.length > 0">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-primary mb-4 border-b border-primary/10 pb-2"><Briefcase class="w-6 h-6" /> Pengalaman & Jabatan</h4>
                                    <ul class="space-y-3">
                                        <li v-for="(work, i) in selectedPerson.work_experience" :key="i" class="flex items-start gap-3 text-gray-700">
                                            <ChevronRight class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" /> {{ work }}
                                        </li>
                                    </ul>
                                </div>

                                <div v-if="selectedPerson.research_history && selectedPerson.research_history.length > 0">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-primary mb-4 border-b border-primary/10 pb-2"><BookOpen class="w-6 h-6" /> Riwayat Riset</h4>
                                    <ul class="space-y-3">
                                        <li v-for="(research, i) in selectedPerson.research_history" :key="i" class="flex items-start gap-3 text-gray-700">
                                            <ChevronRight class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" /> {{ research }}
                                        </li>
                                    </ul>
                                </div>

                                <div v-if="selectedPerson.awards && selectedPerson.awards.length > 0">
                                    <h4 class="flex items-center gap-3 text-lg font-bold text-primary mb-4 border-b border-primary/10 pb-2"><Award class="w-6 h-6" /> Penghargaan</h4>
                                    <ul class="space-y-3 bg-yellow-50 p-5 rounded-2xl border border-yellow-100">
                                        <li v-for="(award, i) in selectedPerson.awards" :key="i" class="flex items-start gap-3 text-gray-700">
                                            <Award class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" /> {{ award }}
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </PublicLayout>
</template>