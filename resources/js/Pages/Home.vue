<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { X, Plus } from 'lucide-vue-next'; // 👉 icon untuk modal & tombol +
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HomeArticleCard from '@/Components/HomeArticleCard.vue';
import AchievementCard from '@/Components/AchievementCard.vue';
import { Link } from '@inertiajs/vue3';
import { GraduationCap, Trophy, CheckSquare, Building2, BookOpen, UserCheck, Users, ArrowRight } from 'lucide-vue-next';
import type { Post, Achievement } from '@/types';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const props = defineProps<{
  latestPosts: Post[];
  latestAchievements: Achievement[];
  canLogin?: boolean;
  canRegister?: boolean;
}>();

// refs animasi
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

// 👉 state modal
const showModal = ref(false);

const openModal = () => {
  showModal.value = true;
};
const closeModal = () => {
  showModal.value = false;
};

// fungsi hover animasi
const addHoverAnimation = (elements: Element[]) => {
  elements.forEach(el => {
    el.addEventListener('mouseenter', () => {
      gsap.to(el, { scale: 1.05, duration: 0.3, ease: 'power2.out' });
    });
    el.addEventListener('mouseleave', () => {
      gsap.to(el, { scale: 1, duration: 0.3, ease: 'power2.out' });
    });
  });
};

onMounted(() => {
  // Animasi Hero
  const heroTl = gsap.timeline({ defaults: { ease: "power3.out" } });
  heroTl.from([heroTitle1Ref.value, heroTitle2Ref.value], { opacity: 0, y: 40, duration: 1, stagger: 0.2 })
        .from(heroButtonRef.value, { opacity: 0, y: 20, duration: 0.8 }, "-=0.5");

  gsap.to(".hero-image", {
    scale: 1.1,
    scrollTrigger: { trigger: heroSectionRef.value, start: "top top", end: "bottom top", scrub: 1.5 }
  });

  const heroCardsElement = heroCardsRef.value;
  if (heroCardsElement) {
    const cards = Array.from(heroCardsElement.children);
    gsap.set(cards, { opacity: 0, y: 60 });
    gsap.to(cards, {
      opacity: 1,
      y: 0,
      duration: 0.8,
      stagger: 0.2,
      ease: "power3.out",
      scrollTrigger: {
        trigger: heroCardsElement,
        start: "top 90%",
      }
    });
    addHoverAnimation(cards);
  }

  if (aboutSectionRef.value) {
    const aboutTl = gsap.timeline({ scrollTrigger: { trigger: aboutSectionRef.value, start: "top 70%" } });
    aboutTl.from(".about-title", { opacity: 0, x: -50, duration: 0.8, ease: "power3.out" })
           .from(".about-text", { opacity: 0, x: -50, duration: 0.8, ease: "power3.out" }, "-=0.6")
           .from(".about-stat", { opacity: 0, y: 30, scale: 0.95, duration: 0.6, stagger: 0.15, ease: "back.out(1.4)" }, "-=0.6")
           .from(aboutImageRef.value, { opacity: 0, x: 50, scale: 0.9, duration: 1.2, ease: "power3.out" }, "<");

    const aboutStatsElement = aboutStatsRef.value;
    if (aboutStatsElement) {
      addHoverAnimation(Array.from(aboutStatsElement.children));
    }
  }

  // Animasi Prestasi (Sekarang Di Atas, dengan animasi pattern)
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

    // Animasi parallax untuk CSS Pattern
    gsap.to(".achievement-background-pattern", {
      yPercent: -15,
      ease: "none",
      scrollTrigger: {
        trigger: achievementSectionRef.value,
        start: "top bottom",
        end: "bottom top",
        scrub: true,
      }
    });
  }

  // Animasi Berita (Sekarang Di Bawah, tanpa pattern)
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

  setTimeout(() => {
    ScrollTrigger.refresh();
  }, 500);
});
</script>

<template>
  <PublicLayout>
    <div class="hidden bg-[#2F4DD3]"></div>

    <div class="relative bg-white pb-24 font-public-sans">
      <section 
        ref="heroSectionRef"
        class="relative w-full h-[600px] bg-gray-500 overflow-hidden"
        style="clip-path: ellipse(120% 100% at 50% 0%);"
      >
        <img src="/images/gambar-beranda-1.jpeg" alt="Suasana FSTI ITK" class="hero-image absolute inset-0 w-full h-full object-cover object-[center_68%]">
        <div class="absolute inset-0 bg-[#00509D] opacity-70"></div>
        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center -mt-16">
          
          <h1 ref="heroTitle1Ref" class="font-optimus uppercase text-2xl sm:text-3xl md:text-5xl lg:text-5xl xl:text-6xl font-reguler text-white text-shadow-custom tracking-wider mt-8 whitespace-nowrap">
            FAKULTAS SAINS DAN TEKNOLOGI INFORMASI
          </h1>
          <h2 ref="heroTitle2Ref" class="mt-4 font-optimus uppercase text-xl sm:text-2xl md:text-4xl lg:text-4xl xl:text-5xl font-reguler text-white text-shadow-custom tracking-wider">
            INSTITUT TEKNOLOGI KALIMANTAN
          </h2>
          
          <div ref="heroButtonRef" class="mt-10">
            <a href="#" class="inline-block bg-white text-black font-public-sans font-bold text-base px-6 py-2 rounded-lg shadow-md hover:bg-gray-100 transition-transform transform hover:scale-105 duration-300 -mt-16">
              Tentang FSTI
            </a>
          </div>
        </div>
      </section>

      <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full container mx-auto px-4 sm:px-6 lg:px-8">
        <div ref="heroCardsRef" class="flex justify-center items-start gap-8 flex-wrap">
          <Link 
            :href="route('profil.pimpinan-prodi')" 
            class="block w-[255px] h-[237px] bg-[#2F4DD3] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl"
          >
            <GraduationCap :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-public-sans">Program Studi</h3>
          </Link>
          <Link 
            :href="route('prestasi.index')" 
            class="block w-[255px] h-[237px] bg-[#2F4DD3] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl"
          >
            <Trophy :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-public-sans">Prestasi Mahasiswa</h3>
          </Link>
          <a 
            href="https://layanan-fsti.myst-tech.com/" 
            target="_blank" 
            rel="noopener noreferrer"
            class="block w-[255px] h-[237px] bg-[#2F4DD3] text-white p-8 rounded-2xl flex flex-col justify-center items-center text-center shadow-xl"
          >
            <CheckSquare :size="80" class="mx-auto" />
            <h3 class="mt-4 text-xl font-bold font-public-sans">Layanan Mahasiswa</h3>
          </a>
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
              FSTI terus berkembang sebagai pusat pendidikan dan inovasi di bidang sains dan teknologi, dengan berbagai jurusan, program studi, dan civitas akademika yang mendukung perjalanan belajar, kreativitas, dan prestasi mahasiswa kami.
            </p>
            <div ref="aboutStatsRef" class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
              <div class="bg-[#2F4DD3] text-white p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <Building2 :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold font-public-sans">2</span>
                <span class="block mt-1 text-sm font-normal">Jurusan</span>
              </div>
              <div class="bg-[#2F4DD3] text-white p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <BookOpen :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold font-public-sans">9</span>
                <span class="block mt-1 text-sm font-normal">Program Studi</span>
              </div>
              <div class="bg-[#2F4DD3] text-white p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <UserCheck :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold font-public-sans">118</span>
                <span class="block mt-1 text-sm font-normal">Dosen</span>
              </div>
              <div class="bg-[#2F4DD3] text-white p-4 rounded-lg shadow-sm text-center about-stat cursor-pointer">
                <Users :size="28" class="mx-auto" />
                <span class="block mt-2 text-3xl font-bold font-public-sans">6</span>
                <span class="block mt-1 text-sm font-normal">Tendik</span>
              </div>
            </div>
          </div>

          <div ref="aboutImageRef" class="lg:w-1/2 relative">
            <div class="bg-[#2F4DD3] p-2 rounded-xl shadow-xl relative">
              <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full">
              <button 
                @click="openModal" 
                class="absolute top-3 right-3 bg-white rounded-full p-2 shadow hover:bg-gray-100 transition"
              >
                <Plus :size="20" class="text-[#2F4DD3]" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div 
      v-if="showModal" 
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50 transition-opacity"
    >
      <div class="relative bg-white rounded-lg shadow-xl p-4 max-w-3xl w-full">
        <button 
          @click="closeModal" 
          class="absolute top-2 right-2 bg-gray-100 rounded-full p-1 hover:bg-gray-200 transition"
        >
          <X :size="20" />
        </button>
        <img src="/images/gambar-beranda-2.jpeg" alt="Pembekalan Wisuda FSTI" class="rounded-lg w-full max-h-[80vh] object-contain">
      </div>
    </div>

    <section 
      ref="achievementSectionRef"
      v-if="latestAchievements.length > 0"
      class="relative py-20 overflow-hidden bg-white font-public-sans"
    >
      <div 
        class="achievement-background-pattern absolute top-[-50%] left-0 w-full h-[200%] z-0 css-achievement-pattern"
      ></div>

      <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center mb-12 achievement-header">
          <div>
            <h2 class="text-5xl font-bold font-optimus text-[#2F4DD3]">Prestasi Terbaru</h2>
            <p class="mt-2 text-black text-base font-normal">Capaian membanggakan dari Mahasiswa FSTI ITK</p>
          </div>
          <Link :href="route('prestasi.index')" class="inline-flex items-center font-bold font-public-sans text-white bg-[#2F4DD3] border border-transparent rounded-full px-5 py-2 hover:bg-blue-700 transition-colors duration-300 shadow-sm">
            Lihat Semua
            <ArrowRight class="ml-2 h-4 w-4" />
          </Link>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 -mt-10 relative z-20">
          <div 
            v-for="(achievement, index) in latestAchievements" 
            :key="achievement.id" 
            class="relative z-20 bg-white rounded-lg h-full shadow-lg flex"
          >
            <AchievementCard 
              :achievement="achievement" 
              class="w-full h-full flex-grow"
            />
          </div>
        </div>
        </div>
    </section>

    <section 
      ref="newsSectionRef"
      v-if="latestPosts.length > 0"
      class="relative py-20 overflow-hidden bg-white font-public-sans"
    >
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between items-center mb-12 news-header">
          <div>
            <h2 class="text-5xl font-bold font-optimus text-[#2F4DD3]">Berita Terbaru</h2>
            <p class="mt-2 text-black text-base font-normal">Informasi terkini seputar FSTI</p>
          </div>
          <Link :href="route('berita.index')" class="inline-flex items-center font-bold font-public-sans text-black bg-white border border-gray-300 rounded-full px-5 py-2 hover:bg-gray-100 transition-colors duration-300 shadow-sm">
            Lihat Semua
            <ArrowRight class="ml-2 h-4 w-4" />
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
.text-stroke-custom {
  -webkit-text-stroke: 2px #2F4DD3;
  color: white;
}
.text-shadow-custom {
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
}

.css-achievement-pattern {
  background-color: transparent;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Cg fill='none' stroke='%232F4DD3' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' opacity='0.10'%3E%3Cg transform='translate(20, 20) scale(1.5)'%3E%3Cpath d='M6 9H4.5a2.5 2.5 0 0 1 0-5H6'/%3E%3Cpath d='M18 9h1.5a2.5 2.5 0 0 0 0-5H18'/%3E%3Cpath d='M4 22h16'/%3E%3Cpath d='M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22'/%3E%3Cpath d='M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22'/%3E%3Cpath d='M18 2H6v7a6 6 0 0 0 12 0V2Z'/%3E%3C/g%3E%3Cg transform='translate(80, 80) scale(1.5)'%3E%3Ccircle cx='12' cy='8' r='7'/%3E%3Cpolyline points='8.21 13.89 7 23 12 20 17 23 15.79 13.88'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  background-size: 120px 120px; 
}
</style>