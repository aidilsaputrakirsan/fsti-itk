<script setup lang="ts">
import { onMounted, ref, computed, nextTick, onUnmounted } from 'vue';
import { X, GraduationCap, Trophy, CheckSquare, Building2, Users, ArrowRight, BookOpen, Briefcase, Sparkles, LayoutGrid, Globe, Compass } from 'lucide-vue-next'; 
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
            { angka: '2260', label: 'Mahasiswa Aktif' },
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
    const icons = [Users, BookOpen, Building2, Briefcase];
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

const heroImages = [
    '/images/gambar-beranda-1.webp',
    '/images/gambar-beranda-2.webp',
    '/images/gambar-beranda-3.webp',
    '/images/gambar-beranda-4.webp',
    '/images/gambar-beranda-5.webp'
];
const currentHeroIndex = ref(0);
let sliderInterval: ReturnType<typeof setInterval>;

const startHeroSlider = () => {
    sliderInterval = setInterval(() => {
        currentHeroIndex.value = (currentHeroIndex.value + 1) % heroImages.length;
    }, 4500); 
};

const heroSectionRef = ref(null);
const heroTitle1Ref = ref(null);
const heroTitle2Ref = ref(null);
const heroButtonRef = ref(null);
const heroCardsRef = ref<HTMLDivElement | null>(null);
const aboutSectionRef = ref<HTMLDivElement | null>(null);
const aboutStatsRef = ref<HTMLDivElement | null>(null);
const achievementSectionRef = ref<HTMLDivElement | null>(null);
const newsSectionRef = ref<HTMLDivElement | null>(null);

const addHoverAnimation = (elements: Element[]) => {
  elements.forEach(el => {
    el.addEventListener('mouseenter', () => { 
        gsap.to(el, { y: -4, scale: 1.02, duration: 0.3, ease: 'power2.out' }); 
    });
    el.addEventListener('mouseleave', () => { 
        gsap.to(el, { y: 0, scale: 1, duration: 0.3, ease: 'power2.out' }); 
    });
  });
};

onMounted(() => {
  startHeroSlider(); 

  
  const heroTl = gsap.timeline({ defaults: { ease: "power3.out" } });
  heroTl.from([heroTitle1Ref.value, heroTitle2Ref.value], { opacity: 0, x: -30, duration: 1.2, stagger: 0.2 })
        .from(heroButtonRef.value, { opacity: 0, y: 20, duration: 0.8 }, "-=0.5");

  if (heroCardsRef.value && heroSectionRef.value) {
    gsap.fromTo(heroCardsRef.value, 
      { autoAlpha: 0, y: 60 },
      { 
        autoAlpha: 1, 
        y: 0, 
        duration: 0.8, 
        ease: "power3.out",
        scrollTrigger: { 
          trigger: heroSectionRef.value, 
          start: "top -50",
          toggleActions: "play none none reverse" 
        }
      }
    );
  }

 if (aboutSectionRef.value) {
    ScrollTrigger.create({
        trigger: aboutStatsRef.value,
        start: "top 85%", 
        onEnter: () => {
            if (aboutStatsRef.value) {
                aboutStatsRef.value.querySelectorAll('.stat-number').forEach(el => {
                    const targetText = el.getAttribute('data-target') || '0';
                    const target = parseInt(targetText.replace(/\./g, ''));
                    if (!isNaN(target) && target > 0 && (el as HTMLElement).innerText === "0") {
                        countUpAnimation(el as HTMLElement, target, 1500); 
                    }
                });
            }
        }
    });

    const aboutTl = gsap.timeline({ 
        scrollTrigger: { 
            trigger: aboutSectionRef.value, 
            start: "top 75%"
        } 
    });

    aboutTl.from(".about-title", { opacity: 0, y: 30, duration: 0.8 })
           .from(".about-text", { opacity: 0, y: 30, duration: 0.8 }, "-=0.6")
           .from(".about-divider", { scaleY: 0, transformOrigin: "top", duration: 0.8 }, "-=0.6")
           .fromTo(".about-stat", 
                { opacity: 0, x: 30 }, 
                { opacity: 1, x: 0, duration: 0.6, stagger: 0.15, ease: "power3.out" }, 
                "-=0.4"
            );

    if (aboutStatsRef.value) {
        const statCards = Array.from(aboutStatsRef.value.children);
        if(statCards.length > 0) {
            addHoverAnimation(statCards);
        }
    }
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

    gsap.to(".news-batik-parallax", {
      yPercent: -15, ease: "none",
      scrollTrigger: { trigger: newsSectionRef.value, start: "top bottom", end: "bottom top", scrub: true }
    });
  }

  setTimeout(() => { ScrollTrigger.refresh(); }, 500);
});

onUnmounted(() => { clearInterval(sliderInterval); });
</script>

<template>
  <PublicLayout>
    <div class="font-public-sans text-black-800 bg-white selection:bg-[#FDC500] selection:text-[#2F4DD3]">
      
      <section ref="heroSectionRef" class="relative w-full h-screen min-h-[650px] flex items-center overflow-hidden bg-[#2F4DD3]">
        
        <div class="absolute inset-0 z-0 w-full h-full">
            <transition-group name="kenburns">
                <img 
                    v-for="(img, idx) in heroImages" 
                    :key="img" 
                    v-show="currentHeroIndex === idx"
                    :src="img" 
                    class="absolute inset-0 w-full h-full object-cover object-center" 
                    alt="Suasana FSTI ITK"
                    width="1920"
                    height="1080"
                >
            </transition-group>
        </div>

        <div class="absolute inset-0 z-10 bg-gradient-to-r from-[#2F4DD3] via-[#2F4DD3]/90 to-transparent"></div>
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-[#2F4DD3] via-[#2F4DD3]/40 to-transparent lg:hidden"></div>

        <div class="absolute inset-0 z-10 opacity-15 mix-blend-overlay w-full lg:w-2/3 pointer-events-none" style="mask-image: linear-gradient(to right, black, transparent);">
          <img src="/images/ornaments/batik.png" class="w-full h-full object-cover" alt="Batik" width="1000" height="1000" onerror="this.style.display='none'">
        </div>

        <div class="container mx-auto px-6 lg:px-12 relative z-20 flex flex-col justify-center h-full">
          <div class="lg:w-8/12 text-left pt-10">
            <h1 ref="heroTitle1Ref" class="font-optimus uppercase text-4xl sm:text-5xl md:text-6xl lg:text-[70px] font-bold text-white drop-shadow-[0_5px_15px_rgba(0,0,0,0.4)] leading-[1.1]">
              FAKULTAS SAINS DAN <br>
              <span class="text-[#FDC500] drop-shadow-[0_2px_20px_rgba(253,197,0,0.5)]">TEKNOLOGI INFORMASI</span>
            </h1>
            
            <div class="w-24 h-1.5 bg-[#FDC500] mt-8 mb-6 rounded-full shadow-[0_0_15px_rgba(253,197,0,0.6)]"></div>

            <h2 ref="heroTitle2Ref" class="font-public-sans uppercase text-base sm:text-lg lg:text-2xl font-semibold text-white tracking-[0.2em] drop-shadow-md opacity-95">
              Institut Teknologi Kalimantan
            </h2>
            
            <div ref="heroButtonRef" class="mt-12">
              <Link :href="route('profiles.about')" aria-label="Pelajari lebih lanjut tentang FSTI" class="inline-flex items-center gap-3 bg-[#FDC500] text-[#2F4DD3] font-black text-lg px-10 py-4 rounded-full shadow-[0_10px_30px_rgba(253,197,0,0.3)] hover:bg-white hover:scale-105 transition-all duration-300 group">
                Tentang FSTI <ArrowRight aria-hidden="true" class="w-6 h-6 group-hover:translate-x-2 transition-transform" />
              </Link>
            </div>
          </div>
        </div>
      </section>

      <div class="relative z-30 w-full -mt-16 container mx-auto px-6 lg:px-12">        
        <div ref="heroCardsRef" class="invisible bg-white/95 backdrop-blur-xl border border-white/50 rounded-[2rem] p-6 lg:p-8 shadow-[0_30px_60px_rgba(0,0,0,0.08)] flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12 relative overflow-hidden">
          
          <div class="absolute -left-10 -top-10 w-32 h-32 bg-[#FDC500] rounded-full blur-3xl opacity-20 pointer-events-none"></div>
          
          <div class="lg:w-1/3 text-center lg:text-left z-10">
              <h3 class="text-2xl font-black font-public-sans text-[#2F4DD3] leading-tight">Jelajahi Lebih Cepat</h3>
              <p class="text-sm text-black-500 mt-2 font-medium">Temukan informasi penting FSTI dengan akses yang lebih praktis.</p>
          </div>

          <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-3 gap-4 w-full z-10">
            <Link :href="route('profiles.structure') + '#prodi'" aria-label="Lihat Program Studi" class="flex items-center gap-4 bg-gray-50 hover:bg-[#2F4DD3] p-4 rounded-2xl border border-transparent transition-all duration-300 group shadow-sm hover:shadow-md hover:-translate-y-1">
              <div class="w-12 h-12 bg-white text-[#2F4DD3] group-hover:text-[#FDC500] rounded-xl flex items-center justify-center shrink-0 shadow-sm transition-colors">
                  <GraduationCap aria-hidden="true" class="w-6 h-6" />
              </div>
              <div>
                  <h4 class="font-bold text-[#2F4DD3] group-hover:text-white text-sm lg:text-base transition-colors">Program Studi</h4>
                  <p class="text-xs text-black-400 group-hover:text-white/70 transition-colors">Daftar Program Studi</p>
              </div>
            </Link>

            <Link :href="route('achievements.index')" aria-label="Lihat Prestasi Mahasiswa" class="flex items-center gap-4 bg-gray-50 hover:bg-[#2F4DD3] p-4 rounded-2xl border border-transparent transition-all duration-300 group shadow-sm hover:shadow-md hover:-translate-y-1">
              <div class="w-12 h-12 bg-white text-[#2F4DD3] group-hover:text-[#FDC500] rounded-xl flex items-center justify-center shrink-0 shadow-sm transition-colors">
                  <Trophy aria-hidden="true" class="w-6 h-6" />
              </div>
              <div>
                  <h4 class="font-bold text-[#2F4DD3] group-hover:text-white text-sm lg:text-base transition-colors">Prestasi</h4>
                  <p class="text-xs text-black-400 group-hover:text-white/70 transition-colors">Capaian Prestasi Mahasiswa</p>
              </div>
            </Link>
            
            <Link :href="route('internal-services.index')" aria-label="Portal Layanan" class="flex items-center gap-4 bg-gray-50 hover:bg-[#2F4DD3] p-4 rounded-2xl border border-transparent transition-all duration-300 group shadow-sm hover:shadow-md hover:-translate-y-1">
              <div class="w-12 h-12 bg-white text-[#2F4DD3] group-hover:text-[#FDC500] rounded-xl flex items-center justify-center shrink-0 shadow-sm transition-colors">
                  <CheckSquare aria-hidden="true" class="w-6 h-6" />
              </div>
              <div>
                  <h4 class="font-bold text-[#2F4DD3] group-hover:text-white text-sm lg:text-base transition-colors">Layanan</h4>
                  <p class="text-xs text-black-400 group-hover:text-white/70 transition-colors">Portal Layanan Mahasiswa</p>
              </div>
            </Link>
          </div>
        </div>
      </div>

      <section ref="aboutSectionRef" class="pt-24 pb-20 relative bg-white overflow-hidden">
        
        <LayoutGrid aria-hidden="true" class="absolute -right-20 top-20 w-[600px] h-[600px] text-[#2F4DD3] opacity-[0.02] transform rotate-12 pointer-events-none" />
        <div class="absolute -left-32 bottom-0 w-[400px] h-[400px] bg-[#FDC500]/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
          <img src="/images/ornaments/batik.png" width="1000" height="1000" alt="" class="w-full h-full object-cover">
        </div>

        <div class="container mx-auto px-6 lg:px-12 relative z-10">
          <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            
            <div class="lg:w-5/12 flex flex-col justify-center text-center lg:text-left">
              <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-optimus text-[#2F4DD3] about-title leading-tight">
                Sekilas Tentang <br class="hidden lg:block"> FSTI ITK
              </h2>
              <p class="mt-6 text-black-600 text-base lg:text-lg leading-relaxed about-text font-normal text-justify lg:text-left">
                {{ deskripsiFakultas }}
              </p>
            </div>

            <div class="hidden lg:flex h-64 items-center">
                <div class="w-1 h-full bg-gradient-to-b from-transparent via-[#FDC500]/50 to-transparent rounded-full about-divider"></div>
            </div>

            <div class="lg:w-6/12 flex items-center w-full relative z-20">
              <div ref="aboutStatsRef" class="grid grid-cols-2 gap-6 w-full">
                <div v-for="(stat, index) in displayStats" :key="index" class="bg-white/80 backdrop-blur-sm border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:border-[#FDC500] hover:bg-white transition-all duration-300 about-stat text-center group">
                    <div class="w-14 h-14 bg-gray-50 text-[#2F4DD3] rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-[#FDC500] group-hover:text-[#2F4DD3] transition-colors shadow-inner">
                        <component :is="getStatIcon(index)" aria-hidden="true" class="w-7 h-7" />
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-black text-[#2F4DD3] stat-number" :data-target="stat.angka">0</h3>
                    <p class="text-xs sm:text-sm font-bold text-black-500 uppercase tracking-wider mt-1.5">{{ stat.label }}</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>

      <section ref="achievementSectionRef" v-if="latestAchievements.length > 0" class="relative py-20 overflow-hidden bg-gradient-to-b from-[#FDC500]/10 via-white to-[#2F4DD3]/5 font-public-sans">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left mb-12 achievement-header gap-6 md:gap-0">
            <div>
              <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-optimus text-[#2F4DD3]">Prestasi Terbaru</h2>
              <p class="mt-2 text-black text-sm sm:text-base font-normal">Capaian membanggakan dari Mahasiswa FSTI ITK</p>
            </div>
            <Link :href="route('achievements.index')" class="inline-flex items-center font-bold font-public-sans text-[#2F4DD3] bg-white border border-gray-200 rounded-full px-6 py-3 hover:bg-[#FDC500] hover:text-[#2F4DD3] hover:border-[#FDC500] transition-colors duration-300 shadow-sm hover:shadow-md">
              Lihat Semua <ArrowRight class="ml-2 h-4 w-4" />
            </Link>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-20 mt-4">          
            <div v-for="(achievement, index) in latestAchievements" :key="achievement.id" class="relative z-20 bg-white rounded-lg h-full shadow-lg flex">
              <AchievementCard :achievement="achievement" class="w-full h-full flex-grow" />
            </div>
          </div>
        </div>
      </section>

      <section ref="newsSectionRef" v-if="latestPosts.length > 0" class="relative py-20 overflow-hidden bg-white font-public-sans">
        
        <div class="news-batik-parallax absolute top-[-20%] left-0 w-full h-[150%] z-0 opacity-[0.03] pointer-events-none">
          <img src="/images/ornaments/ornament-3.png" class="w-full h-full object-cover" alt="" onerror="this.style.display='none'">
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left mb-12 news-header gap-6 md:gap-0">
            <div>
              <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-optimus text-[#2F4DD3]">Berita Terbaru</h2>
              <p class="mt-2 text-black text-sm sm:text-base font-normal">Informasi terkini seputar FSTI</p>
            </div>
            <Link :href="route('posts.index')" class="inline-flex items-center font-bold font-public-sans text-black bg-white border border-gray-300 rounded-full px-5 py-2 hover:bg-[#FDC500] hover:text-[#2F4DD3] hover:border-[#FDC500]  transition-colors duration-300 shadow-sm">
              Lihat Semua <ArrowRight class="ml-2 h-4 w-4" />
            </Link>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <HomeArticleCard v-for="post in latestPosts" :key="post.id" :post="post" />
          </div>
        </div>
      </section>

    </div>
  </PublicLayout>
</template>

<style scoped>
.kenburns-enter-active,
.kenburns-leave-active {
  transition: all 2.5s ease-in-out;
}
.kenburns-enter-from {
  opacity: 0;
  transform: scale(1.05);
}
.kenburns-leave-to {
  opacity: 0;
  transform: scale(1.1);
}
.kenburns-enter-to, .kenburns-leave-from {
  opacity: 1;
  transform: scale(1);
}

.css-achievement-pattern {
  background-color: transparent;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='none' stroke='%232F4DD3' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.10'%3E%3Cg transform='translate(20, 20) scale(1.5)'%3E%3Cpath d='M6 9H4.5a2.5 2.5 0 0 1 0-5H6'/%3E%3Cpath d='M18 9h1.5a2.5 2.5 0 0 0 0-5H18'/%3E%3Cpath d='M4 22h16'/%3E%3Cpath d='M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22'/%3E%3Cpath d='M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22'/%3E%3Cpath d='M18 2H6v7a6 6 0 0 0 12 0V2Z'/%3E%3C/g%3E%3Cg transform='translate(80, 80) scale(1.5)'%3E%3Ccircle cx='12' cy='8' r='7'/%3E%3Cpolyline points='8.21 13.89 7 23 12 20 17 23 15.79 13.88'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  background-size: 120px 120px; 
}
</style>