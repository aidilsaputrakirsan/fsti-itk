<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ChevronDown, Search, X, Menu, Globe } from 'lucide-vue-next';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';

const page = usePage();

const trans = (key: string): string => {
    const translations = (page.props as any).translations as Record<string, string> | undefined;
    return translations?.[key] || key;
};

interface StudyProgramGlobal {
    name: string;
    degree: string;
    slug: string;
    department: string;
}

interface NavLink {
    name: string;
    href: string;
    external?: boolean;
    sublinks?: NavLink[];
    megaMenu?: boolean;
    columns?: {
        title: string;
        links: { name: string; href: string }[];
    }[];
}

const globalProdi = computed<StudyProgramGlobal[]>(() => {
    return ((page.props as any).globalProdi as StudyProgramGlobal[]) || [];
});

const uniqueDepartments = computed(() => {
    const deps = globalProdi.value.map(p => p.department);
    return [...new Set(deps)].filter(Boolean);
});

const navigationMenu = computed<NavLink[]>(() => [
    { name: trans('Beranda'), href: route('home') },
    {
        name: trans('Profil'),
        href: '#',
        sublinks: [
            { name: trans('Tentang FSTI'), href: route('profil.tentang') },            
            {
                name: trans('Struktur Organisasi'),
                href: '#',
                sublinks: [
                    { name: trans('Bagan Organisasi'), href: route('bagan-organisasi') },
                    { name: trans('Pimpinan Fakultas'), href: route('profil.pimpinan-fakultas') },
                    { name: trans('Pimpinan Jurusan'), href: route('profil.pimpinan-jurusan') },
                    { name: trans('Pimpinan Prodi'), href: route('profil.pimpinan-prodi') },
                    { name: trans('Pimpinan Laboratorium'), href: route('profil.pimpinan-laboratorium') },
                ],
            },
            {
                name: trans('Civitas Akademika'),
                href: '#',
                sublinks: [
                    { name: trans('Dosen'), href: route('profil.dosen') },
                    { name: trans('Tenaga Kependidikan'), href: route('profil.tenaga-kependidikan') },
                ],
            },
            { name: trans('Kerjasama'), href: route('profil.kerjasama') },
            { name: trans('Kontak'), href: route('kontak') },
        ],
    },
    {
        name: trans('Program Studi'),
        href: '#',
        megaMenu: true,
        columns: uniqueDepartments.value.map(dep => ({
            title: `Jurusan ${dep}`,
            links: globalProdi.value
                .filter(p => p.department === dep)
                .map(p => ({
                    name: `Program Studi ${p.degree} ${p.name}`,
                    href: route('public.prodi.show', p.slug)
                }))
        }))
    },
    {
        name: trans('Kemahasiswaan'),
        href: '#',
        sublinks: [
            { name: trans('Prestasi Mahasiswa'), href: route('prestasi.index') },
            { name: 'Portal Layanan Mahasiswa', href: route('layanan.index') }, 
            { name: 'Kegiatan Mahasiswa', href: route('kegiatan.index') }, 
            { name: 'Informasi Beasiswa', href: route('layanan.index') }, 
            { name: 'Penerimaan Mahasiswa Baru (PMB)', href: route('layanan.index') }, 
        ],
    },
    {
        name: trans('Alumni'),
        href: '#',
        sublinks: [
            { name: trans('Data Alumni'), href: route('alumni.index') },
            { name: 'Tracer Study', href: route('alumni.index') }, 
        ],
    },
    {
        name: trans('Informasi'),
        href: '#',
        sublinks: [
            { name: trans('Agenda'), href: route('agenda.index') }, // <-- TELAH DIPERBAIKI
            { name: trans('Berita'), href: route('berita.index') },
            { name: 'Pengumuman', href: route('berita.index') },
            { name: 'Prosedur Publikasi', href: route('berita.index') },
        ],
    },
    { name: 'PPID', href: route('public.ppid.index') },    
    {
        name: trans('Zona Integritas'),
        href: '#',
        sublinks: [
            { name: trans('Informasi Zona Integritas'), href: route('zona-integritas.index') },
            { name: trans('Survei Kepuasan'), href: route('survei.index') },
        ],
    },
    {
        name: trans('Riset'),
        href: '#',
        sublinks: [
            { name: trans('Penelitian'), href: route('zona-integritas.index') },
            { name: trans('Pengabdian kepada Masyarakat'), href: route('survei.index') },
        ],
    },    
]);

const activeDropdown = ref<string | null>(null);
const isScrolled = ref(false);
const isSearchOpen = ref(false);
const searchQuery = ref('');
const isMobileMenuOpen = ref(false);

const showDropdown = (menuName: string) => activeDropdown.value = menuName;
const hideDropdown = () => activeDropdown.value = null;

const handleScroll = () => {
    isScrolled.value = window.scrollY > 10;
};

const openSearch = () => isSearchOpen.value = true;
const closeSearch = () => isSearchOpen.value = false;
const submitSearch = () => {
    if (searchQuery.value.trim()) {
        closeSearch();
        router.get(route('berita.index', { search: searchQuery.value }), {}, {
            preserveState: true,
            onSuccess: () => {
                searchQuery.value = '';
            }
        });
    }
};

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <header 
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 ease-in-out bg-white/50 backdrop-blur-lg"
        :class="{ 'shadow-md': isScrolled }"
    >
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <Link href="/" class="flex items-center space-x-2">
                        <img class="h-10 w-auto" src="/images/logofsti.png" alt="Logo FSTI">
                    </Link>
                </div>

                <nav class="hidden md:flex items-center space-x-8">
                    <div
                        v-for="item in navigationMenu"
                        :key="item.name"
                        class="relative"
                        @mouseenter="showDropdown(item.name)"
                        @mouseleave="hideDropdown()"
                    >
                        <component
                            :is="item.sublinks || item.megaMenu ? 'button' : Link"
                            :href="item.href"
                            class="inline-flex items-center px-1 pt-1 text-sm font-bold transition-colors duration-200"
                            :class="'text-[#00509D] hover:text-gray-200'"
                        >
                            {{ item.name }}
                            <ChevronDown v-if="item.sublinks || item.megaMenu" class="ml-1 h-4 w-4" />
                        </component>
                        
                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                            <div v-if="activeDropdown === item.name && item.sublinks" class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <template v-for="sublink in item.sublinks" :key="sublink.name">
                                        <div v-if="'sublinks' in sublink && sublink.sublinks" class="relative group">
                                            <button class="w-full text-left flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#133E87]">
                                                {{ sublink.name }}
                                                <ChevronDown class="h-4 w-4 transform -rotate-90" />
                                            </button>
                                            <div class="absolute left-full top-0 mt-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                                                <div class="py-1">
                                                    <Link v-for="subsublink in sublink.sublinks" :key="subsublink.name" :href="subsublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ subsublink.name }}</Link>
                                                </div>
                                            </div>
                                        </div>
                                        <a v-else-if="'external' in sublink && sublink.external" :href="sublink.href" target="_blank" rel="noopener noreferrer" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ sublink.name }}</a>
                                        <Link v-else :href="sublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ sublink.name }}</Link>
                                    </template>
                                </div>
                            </div>
                        </transition>

                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                             <div v-if="activeDropdown === item.name && item.megaMenu" class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-screen max-w-4xl px-4 sm:px-0">
                                 <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                     <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8 grid-cols-2">
                                         <div v-for="column in item.columns" :key="column.title">
                                             <h3 class="text-sm font-bold tracking-wide text-gray-500 uppercase">{{ column.title }}</h3>
                                             <ul role="list" class="mt-4 space-y-4">
                                                 <li v-for="link in column.links" :key="link.name" class="text-base">
                                                     <Link :href="link.href" class="text-gray-900 hover:text-blue-800 transition-colors duration-200">{{ link.name }}</Link>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                        </transition>
                    </div>
                </nav>

                <div class="hidden md:flex items-center space-x-4">
                    <LanguageSwitcher />
                    <button @click="openSearch" class="p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors text-white hover:bg-white/20">
                        <Search class="h-5 w-5" />
                    </button>
                </div>

                <div class="md:hidden">
                    <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="p-2 rounded-md transition-colors text-white">
                        <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" />
                        <X v-else class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>
        
        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 -translate-y-4" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-4">
             <div v-if="isMobileMenuOpen" class="md:hidden bg-white/95 backdrop-blur-lg shadow-xl py-4">
                 <p class="text-center text-gray-700">Menu mobile belum diimplementasikan.</p>
            </div>
        </transition>
    </header>

    <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-if="isSearchOpen" class="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm flex items-start justify-center pt-20" @click.self="closeSearch">
            <div class="bg-white rounded-lg shadow-2xl w-full max-w-xl">
                 <form @submit.prevent="submitSearch" class="flex items-center border-b border-gray-200">
                    <input v-model="searchQuery" type="text" placeholder="Ketik pencarian dan tekan Enter..." class="w-full py-4 px-6 text-lg border-none focus:ring-0">
                    <button type="submit" class="p-4 text-gray-500 hover:text-blue-600">
                        <Search class="h-6 w-6" />
                    </button>
                 </form>
                 <div class="p-6 text-sm text-gray-500">
                    Cari berita, pengumuman, atau informasi lainnya di situs FSTI.
                 </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.group:hover .group-hover\:block {
    display: block;
}
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
</style>