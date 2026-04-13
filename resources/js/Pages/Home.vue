<script setup lang="ts">
import { onMounted, ref, computed, nextTick } from 'vue';
import { X, Plus, GraduationCap, Trophy, CheckSquare, Building2, BookOpen, UserCheck, Users, ArrowRight, Zap, Beaker, Briefcase, Network } from 'lucide-vue-next'; 
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HomeArticleCard from '@/Components/HomeArticleCard.vue';
import AchievementCard from '@/Components/AchievementCard.vue';
import { Link } from '@inertiajs/vue3';
import type { Post, Achievement } from '@/types';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const props = defineProps<{
  latestPosts: Post[];
  latestAchievements: Achievement[];
  canLogin?: boolean;
  canRegister?: boolean;
  profile?: any; 
  statistics?: { dosen: number; tendik: number; prodi_s1: number; prodi_s2: number; prodi_total: number };
}>();

interface StatItem {
    angka: string | number;
    label: string;
}

const displayStats = computed<StatItem[]>(() => {
    let data = props.profile;
    
    if (typeof data === 'string') {
        try { data = JSON.parse(data); } catch (e) { data = {}; }
    }

    const rawData = data?.statistik?.data;

    if (!rawData || typeof rawData !== 'object' || Object.keys(rawData).length === 0) {
        return [
            { angka: '2260', label: 'Mahasiswa' },
            { angka: props.statistics?.prodi_s1 || '8', label: 'Program Studi S1' },
            { angka: props.statistics?.dosen || '0', label: 'Dosen Tetap' },
            { angka: props.statistics?.tendik || '0', label: 'Tenaga Kependidikan' }
        ];
    }

    const dataArray = Array.isArray(rawData) ? rawData : Object.values(rawData);
    const slicedData = dataArray.slice(0, 4) as StatItem[];

    return slicedData.map(stat => {
        const label = stat.label.toLowerCase();
        if (label.includes('dosen')) return { ...stat, angka: props.statistics?.dosen ?? stat.angka };
        if (label.includes('tendik') || label.includes('kependidikan')) return { ...stat, angka: props.statistics?.tendik ?? stat.angka };
        if (label.includes('s1')) return { ...stat, angka: props.statistics?.prodi_s1 ?? stat.angka };
        if (label.includes('s2') || label.includes('magister')) return { ...stat, angka: props.statistics?.prodi_s2 ?? stat.angka };
        if (label.includes('prodi') || label.includes('program studi')) return { ...stat, angka: props.statistics?.prodi_total ?? stat.angka };
        return stat;
    });
});

const deskripsiFakultas = computed<string>(() => {
    let data = props.profile;
    if (typeof data === 'string') {
        try { data = JSON.parse(data); } catch (e) { data = {}; }
    }
    return data?.statistik?.deskripsi || 'FSTI terus berkembang sebagai pusat pendidikan dan inovasi di bidang sains dan teknologi, dengan berbagai jurusan, program studi, dan civitas akademika yang mendukung perjalanan belajar, kreativitas, dan prestasi mahasiswa kami.';
});

const getStatIcon = (idx: number | string) => {
    const num = Number(idx);
    const safeIndex = isNaN(num) ? 0 : num;
    const icons = [Users, Building2, BookOpen, GraduationCap, Beaker, Zap, Briefcase, Network];
    return icons[safeIndex % icons.length];
};

const countUpAnimation = (el: HTMLElement, target: number, duration: number) => {
    let start = 0;
    const increment = target / (duration / 10);
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            el.innerText = target.toLocaleString('id-ID'); 
            clearInterval(timer);
        } else {
            el.innerText = Math.floor(start).toLocaleString('id-ID');
        }
    }, 10);
};

const heroSectionRef = ref(null);
const heroTitle1Ref = ref(null);
const heroTitle2Ref = ref(null);
const heroButtonRef = ref(null);
const heroCardsRef = ref<HTMLDivElement | null>(null);
const aboutSectionRef = ref<HTMLDivElement | null>(null);
const aboutImageRef = ref(null);
const aboutStatsRef = ref<HTMLDivElement | null>(null);
const newsSectionRef = ref<HTMLDivElement | null>(null);
const achievementSectionRef = ref<HTMLDivElement | null>(null);
const showModal = ref(false);

const openModal = () => { showModal.value = true; };
const closeModal = () => { showModal.value = false; };

const addHoverAnimation = (elements: Element[]) => {
  elements.forEach(el => {
    el.addEventListener('mouseenter', () => { 
        gsap.to(el, { y: -8, scale: 1.01, duration: 0.3, ease: 'power2.out' }); 
    });
    el.addEventListener('mouseleave', () => { 
        gsap.to(el, { y: 0, scale: 1, duration: 0.3, ease: 'power2.out' }); 
    });
  });
};

onMounted(() => {
  const heroTl = gsap.timeline({ defaults: { ease: "power3.out" } });
  heroTl.from([heroTitle1Ref.value, heroTitle2Ref.value], { opacity: 0, y: 40, duration: 1, stagger: 0.2 })
        .from(heroButtonRef.value, { opacity: 0, y: 20, duration: 0.8 }, "-=0.5");

  gsap.to(".hero-image", {
    scale: 1.1,
    scrollTrigger: { trigger: heroSectionRef.value, start: "top top", end: "bottom top", scrub: 1.5 }
  });

  if (heroCardsRef.value) {
    const cards = Array.from(heroCardsRef.value.children);
    gsap.set(cards, { opacity: 0, y: 60 });
    gsap.to(cards, {
      opacity: 1, y: 0, duration: 0.8, stagger: 0.2, ease: "power3.out",
      scrollTrigger: { trigger: heroCardsRef.value, start: "top 90%" }
    });
    addHoverAnimation(cards);
  }

  if (aboutSectionRef.value) {
    const aboutTl = gsap.timeline({ scrollTrigger: { trigger: aboutSectionRef.value, start: "top 70%" } });
    aboutTl.from(".about-title", { opacity: 0, x: -50, duration: 0.8, ease: "power3.out" })
           .from(".about-text", { opacity: 0, x: -50, duration: 0.8, ease: "power3.out" }, "-=0.6")
           .fromTo(".about-stat", 
                { opacity: 0, y: 30, scale: 0.95 }, 
                { opacity: 1, y: 0, scale: 1, duration: 0.6, stagger: 0.15, ease: "back.out(1.4)" }, 
                "-=0.6"
            )
           .from(aboutImageRef.value, { opacity: 0, x: 50, scale: 0.9, duration: 1.2, ease: "power3.out" }, "<");

    nextTick(() => {
        setTimeout(() => {
            if (aboutStatsRef.value) {
                const statCards = Array.from(aboutStatsRef.value.children);
                if(statCards.length > 0) {
                    addHoverAnimation(statCards);
                    aboutStatsRef.value.querySelectorAll('.stat-number').forEach(el => {
                        const targetText = el.getAttribute('data-target') || '0';
                        const target = parseInt(targetText.replace(/\./g, ''));
                        if (!isNaN(target) && target > 0) {
                            countUpAnimation(el as HTMLElement, target, 1500); 
                        }
                    });
                }
            }
        }, 500);
    });
  }

  if (achievementSectionRef.value) {
    const achievementCards = achievementSectionRef.value.querySelectorAll('.grid > *');
    const achievementTl = gsap.timeline({
      scrollTrigger: { trigger: achievementSectionRef.value, start: "top 70%" }
    });
    achievementTl.from(achievementSectionRef.value.querySelector('.achievement-header'), {
      opacity: 0, y: 50, duration: 0.8, ease: "power3.out"
    }).from(achievementCards, {
      opacity: 0, y: 50, duration: 0.7, stagger: 0.2, ease: "power3.out"
    }, "-=0.5");
    addHoverAnimation(Array.from(achievementCards));

    gsap.to(".achievement-background-pattern", {
      yPercent: -15, ease: "none",
      scrollTrigger: { trigger: achievementSectionRef.value, start: "top bottom", end: "bottom top", scrub: true }
    });
  }

  if (newsSectionRef.value) {
    const newsCards = newsSectionRef.value.querySelectorAll('.grid > *');
    const newsTl = gsap.timeline({
      scrollTrigger: { trigger: newsSectionRef.value, start: "top 70%" }
    });
    newsTl.from(newsSectionRef.value.querySelector('.news-header'), {
      opacity: 0, y: 50, duration: 0.8, ease: "power3.out"
    }).from(newsCards, {
      opacity: 0, y: 50, duration: 0.7, stagger: 0.2, ease: "power3.out"
    }, "-=0.5");
    addHoverAnimation(Array.from(newsCards));
  }

  setTimeout(() => { ScrollTrigger.refresh(); }, 500);
});
</script>

<template>
  <PublicLayout>
    <div class="hidden bg-[#2F4DD3]"></div>

<div class="relative bg-white lg:pb-24 font-public-sans">
        <section 
        ref="heroSectionRef"
        class="relative w-full h-[600px] bg-gray-500 overflow-hidden"
        style="clip-path: ellipse(120% 100% at 50% 0%);"
      >
        <img src="/images/gambar-beranda-1.jpeg" alt="Suasana FSTI ITK" class="hero-image absolute inset-0 w-full h-full object-cover object-[center_68%]">
        <div class="absolute inset-0 bg-[#00509D] opacity-70"></div>
<div class="relative container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center -mt-32 lg:-mt-16">          
        <h1 ref="heroTitle1Ref" class="font-optimus uppercase text-3xl sm:text-4xl md:text-5xl lg:text-5xl xl:text-6xl font-reguler text-white text-shadow-custom tracking-wider mt-8 leading-tight px-4 md:px-0 lg:whitespace-nowrap">
  FAKULTAS SAINS DAN TEKNOLOGI INFORMASI
</h1>

<h2 ref="heroTitle2Ref" class="mt-4 font-optimus uppercase text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-reguler text-white text-shadow-custom tracking-wider px-4 md:px-0 lg:whitespace-nowrap">
  INSTITUT TEKNOLOGI KALIMANTAN
</h2>
          
          <div ref="heroButtonRef" class="mt-10">
            <Link :href="route('profiles.about')" class="inline-block bg-white text-black font-public-sans font-bold text-base px-6 py-2 rounded-lg shadow-md hover:bg-gray-100 transition-transform transform hover:scale-105 duration-300 -mt-16">
              Tentang FSTI
            </Link>
          </div>
        </div>
      </section>

<div class="relative lg:absolute lg:bottom-0 lg:left-1/2 lg:-translate-x-1/2 w-full container mx-auto px-4 sm:px-6 lg:px-8 -mt-24 lg:mt-0 z-20 pb-12 lg:pb-0">        <div ref="heroCardsRef" class="flex justify-center items-start gap-8 flex-wrap">
          <Link :href="route('profiles.program-leaders')" class="w-[255px] h-[237px] bg-[#2F4DD3] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl">
            <GraduationCap :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-public-sans">Program Studi</h3>
          </Link>
          <Link :href="route('achievements.index')" class="w-[255px] h-[237px] bg-[#2F4DD3] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl">
            <Trophy :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-public-sans">Prestasi Mahasiswa</h3>
          </Link>
          
          <Link :href="route('internal-services.index')" class="w-[255px] h-[237px] bg-[#2F4DD3] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl">
            <CheckSquare :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-public-sans">Layanan Mahasiswa</h3>
          </Link>

        </div>
      </div>
    </div>

    <section ref="aboutSectionRef" class="bg-white py-20 overflow-hidden font-public-sans">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
          <div class="lg:w-1/2 text-left">
            <h2 class="text-4xl font-bold font-optimus text-[#2F4DD3] about-title">
              Sekilas Tentang FSTI ITK
            </h2>
            
            <p class="mt-6 text-black text-base font-normal leading-relaxed about-text">
              {{ deskripsiFakultas }}
            </p>
            
            <div ref="aboutStatsRef" class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
              <div v-for="(stat, index) in displayStats" :key="index" class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:border-[#2F4DD3]/30 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden group cursor-pointer about-stat">
                  
                  <div class="absolute -top-6 -right-6 w-20 h-20 bg-[#2F4DD3]/10 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                  <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-[#2F4DD3]/10 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                  
                  <div class="relative z-10 flex flex-col items-center">
                      <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-50 rounded-xl text-[#2F4DD3] mb-4 group-hover:bg-[#2F4DD3] group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:rotate-6 shadow-inner">
                          <component :is="getStatIcon(index)" class="w-6 h-6" />
                      </div>
                      <h3 class="text-3xl lg:text-4xl font-black text-gray-900 mb-1 stat-number drop-shadow-sm" :data-target="stat.angka">0</h3>
                      <p class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-widest group-hover:text-[#2F4DD3] transition-colors leading-tight text-center">{{ stat.label }}</p>
                  </div>
              </div>
            </div>

          </div>

          <div ref="aboutImageRef" class="lg:w-1/2 relative">
            <div class="bg-[#2F4DD3] p-2 rounded-xl shadow-xl relative overflow-hidden">
              <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full scale-100 hover:scale-105 transition-transform duration-500">
              <button @click="openModal" class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm rounded-full p-2 shadow hover:bg-white transition">
                <Plus :size="20" class="text-[#2F4DD3]" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50 transition-opacity">
      <div class="relative bg-white rounded-lg shadow-xl p-4 max-w-3xl w-full">
        <button @click="closeModal" class="absolute top-2 right-2 bg-gray-100 rounded-full p-1 hover:bg-gray-200 transition">
          <X :size="20" />
        </button>
        <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full max-h-[80vh] object-contain">
      </div>
    </div>

    <section ref="achievementSectionRef" v-if="latestAchievements.length > 0" class="relative py-20 overflow-hidden bg-white font-public-sans">
      <div class="achievement-background-pattern absolute top-[-50%] left-0 w-full h-[200%] z-0 css-achievement-pattern"></div>
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center mb-12 achievement-header">
          <div>
            <h2 class="text-5xl font-bold font-optimus text-[#2F4DD3]">Prestasi Terbaru</h2>
            <p class="mt-2 text-black text-base font-normal">Capaian membanggakan dari Mahasiswa FSTI ITK</p>
          </div>
          <Link :href="route('achievements.index')" class="inline-flex items-center font-bold font-public-sans text-white bg-[#2F4DD3] border border-transparent rounded-full px-5 py-2 hover:bg-blue-700 transition-colors duration-300 shadow-sm">
            Lihat Semua <ArrowRight class="ml-2 h-4 w-4" />
          </Link>
        </div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-20 mt-4">          <div v-for="(achievement, index) in latestAchievements" :key="achievement.id" class="relative z-20 bg-white rounded-lg h-full shadow-lg flex">
            <AchievementCard :achievement="achievement" class="w-full h-full flex-grow" />
          </div>
        </div>
      </div>
    </section>

    <section ref="newsSectionRef" v-if="latestPosts.length > 0" class="relative py-20 overflow-hidden bg-white font-public-sans">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center mb-12 news-header">
          <div>
            <h2 class="text-5xl font-bold font-optimus text-[#2F4DD3]">Berita Terbaru</h2>
            <p class="mt-2 text-black text-base font-normal">Informasi terkini seputar FSTI</p>
          </div>
          <Link :href="route('posts.index')" class="inline-flex items-center font-bold font-public-sans text-black bg-white border border-gray-300 rounded-full px-5 py-2 hover:bg-gray-100 transition-colors duration-300 shadow-sm">
            Lihat Semua <ArrowRight class="ml-2 h-4 w-4" />
          </Link>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <HomeArticleCard v-for="post in latestPosts" :key="post.id" :post="post" />
        </div>
      </div>
    </section>

  </PublicLayout>
</template>

<style scoped>
.text-stroke-custom { -webkit-text-stroke: 2px #2F4DD3; color: white; }
.text-shadow-custom { text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5); }

.css-achievement-pattern {
  background-color: transparent;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='none' stroke='%232F4DD3' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.10'%3E%3Cg transform='translate(20, 20) scale(1.5)'%3E%3Cpath d='M6 9H4.5a2.5 2.5 0 0 1 0-5H6'/%3E%3Cpath d='M18 9h1.5a2.5 2.5 0 0 0 0-5H18'/%3E%3Cpath d='M4 22h16'/%3E%3Cpath d='M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22'/%3E%3Cpath d='M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22'/%3E%3Cpath d='M18 2H6v7a6 6 0 0 0 12 0V2Z'/%3E%3C/g%3E%3Cg transform='translate(80, 80) scale(1.5)'%3E%3Ccircle cx='12' cy='8' r='7'/%3E%3Cpolyline points='8.21 13.89 7 23 12 20 17 23 15.79 13.88'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  background-size: 120px 120px; 
}
</style>