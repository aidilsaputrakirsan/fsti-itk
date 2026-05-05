<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { FileWarning, User } from 'lucide-vue-next';
import { computed, onMounted } from 'vue';

const props = defineProps({
    baganImage: String,
    fakultas: Array,
    jurusan: Array,
    prodi: Array,
    lab: Array
});

const departments = computed(() => {
    const jurusans = [...new Set(props.prodi.map(p => p.jurusan))];
    jurusans.sort((a, b) => {
        if (a && a.includes('Sains')) return -1;
        return 1;
    });
    return jurusans.map(jurusan => ({
        jurusan: ['Koordinator Program Studi', 'Jurusan ' + (jurusan || 'Lainnya')],
        pimpinan: props.prodi.filter(p => p.jurusan === jurusan)
    }));
});

onMounted(() => {
    if (window.location.hash) {
        setTimeout(() => {
            const el = document.querySelector(window.location.hash);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }
});
</script>

<template>
    <PublicLayout>
        <Head title="Struktur Organisasi" />
        <Banner
            title="STRUKTUR ORGANISASI"
            subtitle="Fakultas Sains dan Teknologi Informasi"
            background-image="/images/background-banner.webp"
        />

        <div class="bg-white font-public-sans overflow-x-hidden">
            
            <section id="bagan" class="py-16 md:py-24 scroll-mt-24 border-b border-gray-100">
                <div class="container mx-auto px-6 md:px-8 max-w-6xl">
                    <div class="text-center mb-12" data-aos="fade-up">
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-gray-900 mb-4">
                            Bagan Organisasi <span class="text-primary">FSTI</span>
                        </h2>
                        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
                    </div>
                    <div class="bg-white border border-primary/10 rounded-3xl shadow-sm overflow-hidden transition-all duration-300 ease-in-out hover:shadow-md" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-3 bg-primary self-stretch"></div>
                            <div class="flex-grow p-6 md:p-10">
                                <div class="flex justify-center bg-primary/5 rounded-2xl p-4 border border-primary/10 min-h-[300px]">
                                    <img v-if="baganImage" :src="baganImage" alt="Bagan Organisasi FSTI ITK" class="w-full h-auto object-contain drop-shadow-sm mix-blend-multiply" />
                                    <div v-else class="flex flex-col items-center justify-center text-center py-10 opacity-60">
                                        <FileWarning class="w-16 h-16 text-primary mb-4" />
                                        <h3 class="text-xl font-bold text-gray-800">Bagan Organisasi Belum Tersedia</h3>
                                        <p class="text-gray-500 mt-2">Admin belum mengunggah gambar bagan struktur organisasi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="fakultas" class="py-16 md:py-24 scroll-mt-24 border-b border-gray-100 bg-gray-50">
                <div class="container mx-auto px-4 sm:px-6 md:max-w-4xl flex flex-col gap-10">
                    <div class="text-center" data-aos="fade-up">
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary-hover">Pimpinan Fakultas</h2>
                        <div class="w-24 h-1.5 bg-primary/50 mx-auto mt-6 rounded-full"></div>
                    </div>
                    <div v-if="fakultas.length === 0" class="text-center text-gray-500 py-10">Belum ada data pimpinan fakultas.</div>
                    
                    <template v-for="(p, index) in fakultas" :key="p.id">
                        <div :data-aos="index % 2 === 0 ? 'fade-right' : 'fade-left'" class="flex flex-col md:flex-row rounded-[2rem] shadow-lg overflow-hidden hover:shadow-xl transition-all duration-500 group bg-white border border-gray-100 max-w-3xl mx-auto w-full" :class="{ 'md:flex-row-reverse': index % 2 !== 0 }">
                            
                            <div class="w-full md:w-1/2 flex-shrink-0 relative overflow-hidden bg-gray-100 border-b md:border-b-0 md:border-r border-gray-200 aspect-[4/5] md:aspect-auto">
                                 <img v-if="p.display_image" :src="p.display_image" :alt="p.name" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 bg-white">
                                 <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 group-hover:scale-105 transition-transform duration-700">
                                    <User class="w-20 h-20 opacity-60 text-gray-400" />
                                </div>
                            </div>
                            
                            <div class="w-full md:w-1/2 flex flex-col justify-center p-8 md:p-10 lg:p-12 text-center md:text-left relative bg-gradient-to-br from-primary to-primary-hover text-white">
                                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                <div class="inline-flex items-center justify-center md:justify-start gap-2 px-4 py-1.5 bg-white/10 text-white font-bold rounded-lg uppercase tracking-wider text-[10px] mb-4 w-max mx-auto md:mx-0 border border-white/20 backdrop-blur-sm z-10 shadow-sm">Pimpinan</div>
                                <h3 class="font-optimus font-bold text-xl md:text-2xl text-white mb-3 leading-tight group-hover:text-blue-100 transition-colors duration-300 z-10 drop-shadow-md">{{ p.name }}</h3>
                                <div class="w-12 h-1 bg-white/40 rounded-full mb-4 opacity-80 mx-auto md:mx-0 z-10"></div>
                                <p class="text-sm md:text-base text-white/95 font-medium leading-relaxed tracking-wide z-10">{{ p.structural_position }}</p>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            <section id="jurusan" class="py-16 md:py-24 scroll-mt-24 border-b border-gray-100">
                <div class="container mx-auto px-4 sm:px-6 md:max-w-4xl flex flex-col gap-10">
                    <div class="text-center" data-aos="fade-up">
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary-hover">Pimpinan Jurusan</h2>
                        <div class="w-24 h-1.5 bg-primary/50 mx-auto mt-6 rounded-full"></div>
                    </div>
                    <div v-if="jurusan.length === 0" class="text-center text-gray-500 py-10">Belum ada data pimpinan jurusan.</div>
                    
                    <template v-for="(p, index) in jurusan" :key="p.id">
                        <div :data-aos="index % 2 === 0 ? 'fade-right' : 'fade-left'" class="flex flex-col md:flex-row rounded-[2rem] shadow-lg overflow-hidden hover:shadow-xl transition-all duration-500 group bg-white border border-gray-100 max-w-3xl mx-auto w-full" :class="{ 'md:flex-row-reverse': index % 2 !== 0 }">
                            
                            <div class="w-full md:w-1/2 flex-shrink-0 relative overflow-hidden bg-gray-100 border-b md:border-b-0 md:border-r border-gray-200 aspect-[4/5] md:aspect-auto">
                                 <img v-if="p.display_image" :src="p.display_image" :alt="p.name" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 bg-white">
                                 <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 group-hover:scale-105 transition-transform duration-700">
                                    <User class="w-20 h-20 opacity-60 text-gray-400" />
                                </div>
                            </div>

                            <div class="w-full md:w-1/2 flex flex-col justify-center p-8 md:p-10 lg:p-12 text-center md:text-left relative bg-gradient-to-br from-primary to-primary-hover text-white">
                                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                <div class="inline-flex items-center justify-center md:justify-start gap-2 px-4 py-1.5 bg-white/10 text-white font-bold rounded-lg uppercase tracking-wider text-[10px] mb-4 w-max mx-auto md:mx-0 border border-white/20 backdrop-blur-sm z-10 shadow-sm">Ketua Jurusan</div>
                                <h3 class="font-optimus font-bold text-xl md:text-2xl text-white mb-3 leading-tight group-hover:text-blue-100 transition-colors duration-300 z-10 drop-shadow-md">{{ p.name }}</h3>
                                <div class="w-12 h-1 bg-white/40 rounded-full mb-4 opacity-80 mx-auto md:mx-0 z-10"></div>
                                <p class="text-sm md:text-base text-white/95 font-medium leading-relaxed tracking-wide z-10">{{ p.structural_position }}</p>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            <section id="prodi" class="py-16 md:py-24 scroll-mt-24 border-b border-gray-100 bg-gray-50">
                <div class="container mx-auto px-4 max-w-7xl">
                    <div v-for="(dept, index) in departments" :key="index" class="mb-20 last:mb-0">
                        <div class="text-center mb-12" data-aos="fade-up">
                            <div class="inline-block px-6 py-2 bg-primary text-white font-bold rounded-full uppercase tracking-widest text-[10px] mb-3 shadow-md shadow-primary/20">{{ dept.jurusan[0] }}</div>
                            <h2 class="text-2xl md:text-3xl font-optimus font-bold text-primary-hover">{{ dept.jurusan[1] }}</h2>
                            <div class="w-20 h-1 bg-primary/50 mx-auto mt-4 rounded-full"></div>
                        </div>
                        
                        <div class="flex flex-wrap justify-center gap-6 md:gap-8">
                            <div v-for="(p, pIndex) in dept.pimpinan" :key="p.id" class="w-full sm:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] max-w-[340px]" data-aos="fade-up" :data-aos-delay="pIndex * 50">
                                <div class="bg-gradient-to-b from-primary to-primary-hover rounded-[2rem] shadow-lg p-6 md:p-8 text-center flex flex-col items-center h-full transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl hover:shadow-primary/30 group border border-primary-hover relative overflow-hidden">
                                    <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                    
                                    <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-full border-[4px] border-white/20 p-1 mb-5 flex-shrink-0 relative overflow-hidden bg-white/10 group-hover:border-white/40 transition-colors duration-500 shadow-inner z-10">
                                        <img v-if="p.display_image" :src="p.display_image" :alt="p.name" class="w-full h-full object-cover rounded-full bg-white">
                                        <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 rounded-full">
                                            <User class="w-20 h-20 opacity-60 text-gray-400" />
                                        </div>
                                    </div>
                                    
                                    <h3 class="font-bold text-lg md:text-xl text-white mb-2 group-hover:text-blue-100 transition-colors duration-300 z-10 leading-snug">{{ p.name }}</h3>
                                    <div class="w-10 h-0.5 bg-white/30 rounded-full my-2 z-10"></div>
                                    <p class="text-xs md:text-sm font-medium text-white/90 leading-relaxed z-10">{{ p.structural_position }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="lab" class="py-16 md:py-24 scroll-mt-24">
                <div class="container mx-auto px-4 max-w-7xl">
                    <div class="text-center mb-12" data-aos="fade-up">
                        <div class="inline-block px-6 py-2 bg-primary text-white font-bold rounded-full uppercase tracking-widest text-[10px] mb-3 shadow-md shadow-primary/20">Struktur Laboratorium</div>
                        <h2 class="text-2xl md:text-3xl font-optimus font-bold text-primary-hover">Kepala Laboratorium FSTI</h2>
                        <div class="w-20 h-1 bg-primary/50 mx-auto mt-4 rounded-full"></div>
                    </div>
                    <div v-if="lab.length === 0" class="text-center text-gray-500 py-10">Belum ada data pimpinan laboratorium.</div>
                    
                    <div class="flex flex-wrap justify-center gap-6 md:gap-8">
                        <div v-for="(p, pIndex) in lab" :key="p.id" class="w-full sm:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] max-w-[340px]" data-aos="fade-up" :data-aos-delay="pIndex * 50">
                            <div class="bg-gradient-to-b from-primary to-primary-hover rounded-[2rem] shadow-lg p-6 md:p-8 text-center flex flex-col items-center h-full transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl hover:shadow-primary/30 group border border-primary-hover relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                
                                <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-full border-[4px] border-white/20 p-1 mb-5 flex-shrink-0 relative overflow-hidden bg-white/10 group-hover:border-white/40 transition-colors duration-500 shadow-inner z-10">
                                    <img v-if="p.display_image" :src="p.display_image" :alt="p.name" class="w-full h-full object-cover rounded-full bg-white">
                                    <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 rounded-full">
                                        <User class="w-20 h-20 opacity-60 text-gray-400" />
                                    </div>
                                </div>
                                
                                <h3 class="font-bold text-lg md:text-xl text-white mb-2 group-hover:text-blue-100 transition-colors duration-300 z-10 leading-tight">{{ p.name }}</h3>
                                <div class="w-10 h-0.5 bg-white/30 rounded-full my-2 z-10"></div>
                                <p class="text-xs md:text-sm font-medium text-white/90 leading-snug z-10">{{ p.structural_position }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </PublicLayout>
</template>

<style scoped>
.scroll-mt-24 {
    scroll-margin-top: 6rem;
}
</style>