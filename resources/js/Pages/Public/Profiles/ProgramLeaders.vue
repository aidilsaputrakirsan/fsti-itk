<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head } from '@inertiajs/vue3';
import { User } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    leaders: Array
});

const departments = computed(() => {
    const jurusans = [...new Set(props.leaders.map(p => p.jurusan))];
    
    jurusans.sort((a, b) => {
        if (a && a.includes('Sains')) return -1;
        return 1;
    });

    return jurusans.map(jurusan => ({
        jurusan: ['Koordinator Program Studi', 'Jurusan ' + (jurusan || 'Lainnya')],
        pimpinan: props.leaders.filter(p => p.jurusan === jurusan)
    }));
});
</script>

<template>
    <PublicLayout>
        <Head title="Pimpinan Prodi" />
        <Banner
            title="PIMPINAN PRODI"
            subtitle="Koordinator Program Studi FSTI"
            background-image="/images/background-banner.webp"
        />

        <div class="bg-white py-16 md:py-24 overflow-x-hidden font-public-sans">
            <div class="container mx-auto px-4 max-w-7xl">
                
                <div v-for="(dept, index) in departments" :key="index" class="mb-24 last:mb-0">
                    
                    <div class="text-center mb-16" data-aos="fade-up">
                        <div class="inline-block px-6 py-2.5 bg-primary text-white font-bold rounded-full uppercase tracking-widest text-xs mb-4 shadow-lg shadow-primary/20">
                            {{ dept.jurusan[0] }}
                        </div>
                        <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary-hover">
                            {{ dept.jurusan[1] }}
                        </h2>
                        <div class="w-24 h-1.5 bg-primary/50 mx-auto mt-6 rounded-full"></div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-8">
                        <div
                            v-for="(p, pIndex) in dept.pimpinan"
                            :key="p.id"
                            class="w-full sm:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.5rem)] max-w-[380px]"
                            data-aos="fade-up"
                            :data-aos-delay="pIndex * 50"
                        >
                            <div class="bg-gradient-to-b from-primary to-primary-hover rounded-[2.5rem] shadow-xl p-8 md:p-10 text-center flex flex-col items-center h-full transform transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:shadow-primary/30 group border border-primary-hover relative overflow-hidden">
                                
                                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                
                                <div class="w-40 h-40 rounded-full border-[5px] border-white/20 p-1.5 mb-6 flex-shrink-0 relative overflow-hidden bg-white/10 group-hover:border-white/40 transition-colors duration-500 shadow-inner z-10">
                                    <img v-if="p.display_image" :src="p.display_image" :alt="p.name" class="w-full h-full object-cover rounded-full bg-white">
                                    
                                    <div v-else class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 rounded-full">
                                        <User class="w-20 h-20 opacity-60 text-gray-400" />
                                    </div>
                                </div>
                                
                                <h3 class="font-bold text-xl text-white mb-3 group-hover:text-blue-100 transition-colors duration-300 z-10 leading-snug">
                                    {{ p.name }}
                                </h3>
                                
                                <div class="w-12 h-1 bg-white/30 rounded-full my-3 z-10"></div>
                                
                                <p class="text-sm font-medium text-white/90 leading-relaxed z-10">
                                    {{ p.structural_position }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </PublicLayout>
</template>