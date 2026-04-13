<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown, X, Menu } from 'lucide-vue-next';

const page = usePage();

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
    { name: 'Beranda', href: route('home') },
    {
        name: 'Profil',
        href: '#',
        sublinks: [
            { name: 'Tentang FSTI', href: route('profiles.about') },            
            {
                name: 'Struktur Organisasi',
                href: '#',
                sublinks: [
                    { name: 'Bagan Organisasi', href: route('profiles.organizational-chart') },
                    { name: 'Pimpinan Fakultas', href: route('profiles.faculty-leaders') },
                    { name: 'Pimpinan Jurusan', href: route('profiles.department-leaders') },
                    { name: 'Pimpinan Prodi', href: route('profiles.program-leaders') },
                    { name: 'Pimpinan Laboratorium', href: route('profiles.lab-leaders') },
                ],
            },
            {
                name: 'Civitas Akademika',
                href: '#',
                sublinks: [
                    { name: 'Dosen', href: route('profiles.lecturers') },
                    { name: 'Tenaga Kependidikan', href: route('profiles.support-staff') },
                ],
            },
            { name: 'Kerjasama', href: route('partners.index') },
            { name: 'Kontak', href: route('profiles.contact') },
        ],
    },
    {
        name: 'Program Studi',
        href: '#',
        megaMenu: true,
        columns: uniqueDepartments.value.map(dep => ({
            title: `Jurusan ${dep}`,
            links: globalProdi.value
                .filter(p => p.department === dep)
                .map(p => ({
                    name: `Program Studi ${p.degree} ${p.name}`,
                    href: route('study-programs.show', p.slug)
                }))
        }))
    },
    {
        name: 'Kemahasiswaan',
        href: '#',
        sublinks: [
            { name: 'Prestasi Mahasiswa', href: route('achievements.index') },
            { name: 'Portal Layanan Mahasiswa', href: route('internal-services.index') }, 
            { name: 'Kegiatan Mahasiswa', href: route('student-activities.index') }, 
            { name: 'Informasi Beasiswa', href: route('scholarships.index') }, 
            { name: 'Penerimaan Mahasiswa Baru (PMB)', href: route('pmb.index') }, 
        ],
    },
    {
        name: 'Alumni',
        href: '#',
        sublinks: [
            { name: 'Data Alumni', href: route('alumni.index') },
            { name: 'Tracer Study', href: route('tracer-study.index') }, 
        ],
    },
    {
        name: 'Informasi',
        href: '#',
        sublinks: [
            { name: 'Agenda', href: route('agendas.index') },
            { name: 'Berita', href: route('posts.index') },
            { name: 'Pengumuman', href: route('announcements.index') },
        ],
    },
    { name: 'PPID', href: route('ppid-documents.index') },    
    {
        name: 'Zona Integritas',
        href: '#',
        sublinks: [
            { name: 'Informasi Zona Integritas', href: route('integrity-zones.index') },
            { name: 'Survei Kepuasan', href: route('satisfaction-surveys.index') },
        ],
    },
    {
        name: 'Riset',
        href: '#',
        sublinks: [
            { name: 'Penelitian', href: route('research.index') },
            { name: 'Pengabdian kepada Masyarakat', href: route('community-services.index') },
        ],
    },    
]);

const activeDropdown = ref<string | null>(null);
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);
const openMobileMenus = ref<string[]>([]);

const showDropdown = (menuName: string) => activeDropdown.value = menuName;
const hideDropdown = () => activeDropdown.value = null;

const toggleMobileMenu = (menuName: string) => {
    if (openMobileMenus.value.includes(menuName)) {
        openMobileMenus.value = openMobileMenus.value.filter(m => m !== menuName);
    } else {
        openMobileMenus.value.push(menuName);
    }
};

const closeMobileMenu = () => {
    isMobileMenuOpen.value = false;
};

const handleScroll = () => {
    isScrolled.value = window.scrollY > 10;
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
                
                <div class="flex-1 flex justify-start items-center">
                    <Link href="/" class="flex items-center space-x-2" @click="closeMobileMenu">
                        <img class="h-10 w-auto" src="/images/logofsti.png" alt="Logo FSTI">
                    </Link>
                </div>

                <nav class="hidden xl:flex items-center justify-center space-x-8">
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
                            class="inline-flex items-center px-1 pt-1 text-sm font-bold transition-colors duration-200 text-[#00509D] hover:text-[#133E87]"
                        >
                            {{ item.name }}
                            <ChevronDown v-if="item.sublinks || item.megaMenu" class="ml-1 h-4 w-4" />
                        </component>
                        
                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                            <div v-if="activeDropdown === item.name && item.sublinks" class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <template v-for="sublink in item.sublinks" :key="sublink.name">
                                        <div v-if="'sublinks' in sublink && sublink.sublinks" class="relative group">
                                            <button class="w-full text-left flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#133E87] font-medium">
                                                {{ sublink.name }}
                                                <ChevronDown class="h-4 w-4 transform -rotate-90" />
                                            </button>
                                            <div class="absolute left-full top-0 mt-0 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                                                <div class="py-1">
                                                    <Link v-for="subsublink in sublink.sublinks" :key="subsublink.name" :href="subsublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">{{ subsublink.name }}</Link>
                                                </div>
                                            </div>
                                        </div>
                                        <a v-else-if="'external' in sublink && sublink.external" :href="sublink.href" target="_blank" rel="noopener noreferrer" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">{{ sublink.name }}</a>
                                        <Link v-else :href="sublink.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-medium">{{ sublink.name }}</Link>
                                    </template>
                                </div>
                            </div>
                        </transition>

                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                             <div v-if="activeDropdown === item.name && item.megaMenu" class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-screen max-w-4xl px-4 sm:px-0">
                                 <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                     <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8 grid-cols-2">
                                         <div v-for="column in item.columns" :key="column.title">
                                             <h3 class="text-sm font-bold tracking-wide text-[#00509D] uppercase border-b pb-2 mb-3">{{ column.title }}</h3>
                                             <ul role="list" class="space-y-3">
                                                 <li v-for="link in column.links" :key="link.name" class="text-sm font-medium">
                                                     <Link :href="link.href" class="text-gray-700 hover:text-[#133E87] transition-colors duration-200">{{ link.name }}</Link>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                        </transition>
                    </div>
                </nav>

                <div class="flex-1 flex justify-end items-center">
                    <div class="xl:hidden">
                        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="p-2 rounded-md transition-colors text-[#00509D] hover:bg-blue-50">
                            <Menu v-if="!isMobileMenuOpen" class="h-6 w-6 stroke-2" />
                            <X v-else class="h-6 w-6 stroke-2" />
                        </button>
                    </div>
                </div>

            </div>
        </div>
        
        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 -translate-y-4" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-4">
             <div v-if="isMobileMenuOpen" class="xl:hidden bg-white shadow-2xl absolute w-full border-t border-gray-100 max-h-[85vh] overflow-y-auto">
                 <div class="px-4 py-4 space-y-1">
                     <div v-for="item in navigationMenu" :key="item.name">
                         
                         <Link 
                             v-if="!item.sublinks && !item.megaMenu" 
                             :href="item.href" 
                             @click="closeMobileMenu"
                             class="block px-4 py-3.5 rounded-xl text-base font-bold text-[#00509D] hover:bg-blue-50 transition-colors"
                         >
                             {{ item.name }}
                         </Link>

                         <div v-else>
                             <button 
                                 @click="toggleMobileMenu(item.name)" 
                                 class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-base font-bold text-[#00509D] hover:bg-blue-50 transition-colors"
                             >
                                 {{ item.name }}
                                 <ChevronDown class="h-5 w-5 transition-transform duration-200" :class="{ 'rotate-180': openMobileMenus.includes(item.name) }" />
                             </button>
                             
                             <div v-show="openMobileMenus.includes(item.name)" class="pl-4 pr-2 pb-2 pt-1 space-y-1 border-l-2 border-blue-100 ml-6 mt-1 mb-2">
                                 <template v-if="item.sublinks">
                                     <div v-for="sub in item.sublinks" :key="sub.name">
                                         
                                         <div v-if="'sublinks' in sub && sub.sublinks" class="mb-2 mt-1">
                                             <div class="px-4 py-2 text-sm font-bold text-gray-800">{{ sub.name }}</div>
                                             <div class="pl-2 space-y-1">
                                                 <Link 
                                                     v-for="subsub in sub.sublinks" 
                                                     :key="subsub.name" 
                                                     :href="subsub.href" 
                                                     @click="closeMobileMenu"
                                                     class="block px-4 py-2 text-sm font-medium text-gray-600 hover:text-[#00509D] hover:bg-blue-50 rounded-lg transition-colors"
                                                 >
                                                     • {{ subsub.name }}
                                                 </Link>
                                             </div>
                                         </div>
                                         
                                         <a v-else-if="'external' in sub && sub.external" :href="sub.href" target="_blank" rel="noopener noreferrer" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:text-[#00509D] hover:bg-blue-50 rounded-lg transition-colors">
                                            {{ sub.name }}
                                         </a>
                                         
                                         <Link v-else :href="sub.href" @click="closeMobileMenu" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:text-[#00509D] hover:bg-blue-50 rounded-lg transition-colors">
                                            {{ sub.name }}
                                         </Link>
                                     </div>
                                 </template>

                                 <template v-if="item.megaMenu">
                                     <div v-for="col in item.columns" :key="col.title" class="mb-4 mt-2">
                                         <div class="px-4 py-1.5 text-xs font-bold text-[#00509D] uppercase tracking-wider">{{ col.title }}</div>
                                         <div class="space-y-1 mt-1">
                                             <Link 
                                                 v-for="link in col.links" 
                                                 :key="link.name" 
                                                 :href="link.href" 
                                                 @click="closeMobileMenu"
                                                 class="block px-4 py-2 text-sm font-medium text-gray-600 hover:text-[#00509D] hover:bg-blue-50 rounded-lg transition-colors"
                                             >
                                                 • {{ link.name }}
                                             </Link>
                                         </div>
                                     </div>
                                 </template>
                             </div>
                         </div>
                     </div>
                 </div>
            </div>
        </transition>
    </header>
</template>

<style scoped>
.group:hover .group-hover\:block {
    display: block;
}
</style>