<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import {
    ChartBarSquareIcon,
    NewspaperIcon,
    UsersIcon,
    ArrowLeftOnRectangleIcon,
    ChevronRightIcon,
    InformationCircleIcon,
    AcademicCapIcon,
    ArchiveBoxIcon,
    ShieldCheckIcon,
    UserGroupIcon, 
    BookOpenIcon,
    GlobeAltIcon,
    BriefcaseIcon, 
    BeakerIcon,
    Bars3Icon, 
    XMarkIcon  
} from '@heroicons/vue/24/outline';
import { ref, onMounted, computed } from 'vue';

const page = usePage();
const openMenu = ref<string | null>(null);
const isMobileMenuOpen = ref(false); 

const currentUrl = computed(() => page.url);
const currentUser = computed(() => page.props.auth.user as any);

const navigation = computed(() => {
    const menus = [
        { name: 'Dashboard', href: '/admin/dashboard', icon: ChartBarSquareIcon, children: null },
        {
            name: 'Profil Fakultas',
            href: null,
            icon: InformationCircleIcon, 
            children: [
                { name: 'Kelola Tentang Fakultas', href: '/admin/tentang-fakultas' },
                { name: 'Kelola Civitas Akademika', href: '/admin/staff' },
                { name: 'Kelola Kerjasama', href: '/admin/partners' },
                { name: 'Kelola Kontak', href: '/admin/contacts' },
            ]
        },
        { name: 'Program Studi', 
        href: null,
        icon: AcademicCapIcon, 
        children: [
              { name: 'Kelola Program Studi', href: '/admin/study-programs' },
              { name: 'Kelola Jurusan', href: '/admin/departments'},
        ]}, 
        { 
            name: 'Kemahasiswaan', 
            href: null,
            icon: UserGroupIcon, 
            children: [
                { name: 'Kelola Daftar Prestasi', href: '/admin/achievements' },
                { name: 'Kelola Portal Layanan', href: '/admin/internal-services' },
                { name: 'Kelola Kegiatan', href: '/admin/kegiatan-mahasiswa' },
                { name: 'Kelola Beasiswa', href: '/admin/beasiswa' },
            ]
        },
        { name: 'Data Alumni', href: '/admin/alumni', icon: BriefcaseIcon, children: null }, 
        { 
            name: 'Informasi', 
            href: null,
            icon: NewspaperIcon, 
            children: [
                { name: 'Kelola Agenda', href: '/admin/agenda-fakultas' },
                { name: 'Kelola Berita', href: '/admin/posts' },
                { name: 'Kelola Kategori Berita', href: '/admin/post-categories' },
                { name: 'Kelola Pengumuman', href: '/admin/announcements' },
            ] 
        },
        {
            name: 'PPID',
            href: null,
            icon: ArchiveBoxIcon, 
            children: [
                { name: 'Kelola Dokumen PPID', href: '/admin/ppid' },
                { name: 'Kelola Kategori PPID', href: '/admin/kategori-ppid' }
            ]
        },
        {
            name: 'Zona Integritas (ZI)',
            href: null,
            icon: ShieldCheckIcon,
            children: [
                { name: 'Kelola Halaman ZI', href: '/admin/zona-integritas/profil' },
                { name: 'Kelola Dokumen ZI', href: '/admin/zona-integritas/dokumen' },
                { name: 'Kelola Survei Kepuasan', href: '/admin/satisfaction-surveys' },
            ]
        },
        {
            name: 'Riset', 
            href: null,
            icon: BeakerIcon, 
            children: [
                { name: 'Kelola Penelitian', href: '/admin/penelitian' },
                { name: 'Kelola Pengabdian kepada Masyarakat', href: '/admin/pengabdian' },
            ] 
        },
    ];

    if (currentUser.value?.is_superadmin) {
        menus.push({ name: 'Kelola Akun Admin', href: '/admin/users', icon: UsersIcon, children: null });
    }

    return menus;
});

const isParentUrlActive = (item: any) => {
    if (!item.children) return false;
    return item.children.some((child: any) => currentUrl.value.startsWith(child.href));
};

const toggleSubMenu = (name: string) => {
    if (openMenu.value === name) {
        openMenu.value = null;
    } else {
        openMenu.value = name;
    }
};

onMounted(() => {
    const currentParent = navigation.value.find((item: any) => isParentUrlActive(item));
    if (currentParent) {
        openMenu.value = currentParent.name;
    }
});
</script>

<template>
    <div class="flex h-screen bg-slate-50 text-black font-public-sans overflow-hidden">
        
        <div 
            v-show="isMobileMenuOpen" 
            class="fixed inset-0 bg-gray-800/50 z-40 md:hidden transition-opacity" 
            @click="isMobileMenuOpen = false"
        ></div>

        <aside :class="[
            'fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-white px-5 pt-6 pb-4 border-r border-gray-200 shadow-xl transition-transform duration-300 ease-in-out md:relative md:translate-x-0',
            isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full'
        ]">
            <div class="flex items-center justify-between px-2 mb-4">
                <img 
                    src="/images/logofsti.webp" 
                    alt="Logo FSTI" 
                    class="w-40 h-auto" 
                    fetchpriority="high" 
                    decoding="sync" 
                />
                <button @click="isMobileMenuOpen = false" class="md:hidden p-1.5 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <XMarkIcon class="h-6 w-6" />
                </button>
            </div>

            <a href="/" target="_blank" rel="noopener noreferrer" 
               class="flex items-center justify-center w-full p-2.5 mb-6 text-sm transition-colors duration-200 rounded-lg bg-primary/10 text-primary font-bold hover:bg-primary hover:text-white">
                <GlobeAltIcon class="h-4 w-4 mr-2" />
                Lihat Halaman Publik
            </a>

            <nav class="flex-1 space-y-3 overflow-y-auto pr-1 pb-4 scrollbar-thin scrollbar-thumb-gray-200">
                <template v-for="item in navigation" :key="item.name">
                    <div>
                        <Link
                            v-if="!item.children"
                            :href="item.href"
                            @click="isMobileMenuOpen = false"
                            :class="[
                                'flex items-center w-full p-3 transition-colors duration-200 rounded-lg group',
                                currentUrl.startsWith(item.href)
                                    ? 'bg-primary text-white shadow-md' 
                                    : 'bg-primary/5 text-gray-700 hover:bg-primary/15 hover:text-primary-hover', 
                            ]"
                        >
                            <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full shadow-sm shrink-0">
                                <component :is="item.icon" :class="['h-5 w-5 transition-colors', currentUrl.startsWith(item.href) ? 'text-primary' : 'text-gray-500 group-hover:text-primary-hover']" />
                            </span>
                            <span class="ml-4 font-semibold">{{ item.name }}</span>
                        </Link>

                        <div v-else>
                            <button
                                @click="toggleSubMenu(item.name)"
                                :class="[
                                    'flex items-center w-full p-3 transition-colors duration-200 text-left rounded-lg group',
                                    openMenu === item.name || isParentUrlActive(item) ? 'bg-primary/15 text-primary-hover' : 'bg-primary/5 text-gray-700',
                                    'hover:bg-primary/15 hover:text-primary-hover',
                                ]"
                            >
                                <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full shadow-sm shrink-0">
                                    <component :is="item.icon" :class="['h-5 w-5 transition-colors', isParentUrlActive(item) || openMenu === item.name ? 'text-primary' : 'text-gray-500 group-hover:text-primary-hover']" />
                                </span>
                                <span class="ml-4 font-semibold flex-1">{{ item.name }}</span>
                                <ChevronRightIcon :class="['h-4 w-4 shrink-0 transition-transform duration-200', openMenu === item.name ? 'rotate-90' : '']" />
                            </button>
                            
                            <div v-show="openMenu === item.name" class="bg-gray-50 rounded-b-lg border-x border-b border-gray-200 overflow-hidden mt-1 shadow-inner">
                                <Link v-for="child in item.children" :key="child.name" :href="child.href"
                                    @click="isMobileMenuOpen = false"
                                    :class="[
                                        'block w-full px-12 py-3 text-sm font-semibold transition-colors duration-200 leading-tight',
                                        currentUrl.startsWith(child.href) 
                                            ? 'bg-primary text-white border-l-4 border-primary-hover' 
                                            : 'text-gray-600 hover:bg-primary/10 hover:text-primary-hover border-l-4 border-transparent'
                                    ]"
                                >
                                    {{ child.name }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </template>
            </nav>
            
            <div class="mt-auto pt-4 border-t border-gray-200">
                <Link 
                    href="/logout" 
                    method="post" 
                    as="button" 
                    class="flex items-center justify-between w-full p-3 transition-colors duration-200 rounded-lg bg-red-50 text-red-700 hover:bg-red-600 hover:text-white border border-red-200 group shadow-sm"
                >
                    <span class="font-bold">Keluar Sistem</span>
                    <span class="flex items-center justify-center w-8 h-8 bg-white rounded-md shadow-sm shrink-0">
                        <ArrowLeftOnRectangleIcon class="h-5 w-5 text-red-600 group-hover:text-red-700" />
                    </span>
                </Link>
            </div>
        </aside>

        <div class="flex flex-1 flex-col overflow-x-hidden relative h-screen">
            
            <header class="md:hidden flex items-center justify-between bg-white px-4 py-3 border-b border-gray-200 sticky top-0 z-30 shadow-sm">
                <img src="/images/logofsti.webp" alt="Logo FSTI" class="h-8 w-auto" />
                <button @click="isMobileMenuOpen = true" class="p-2 rounded-md text-gray-600 hover:text-primary hover:bg-primary/10 transition-colors focus:outline-none">
                    <Bars3Icon class="h-6 w-6" />
                </button>
            </header>

            <main class="flex-1 overflow-y-auto bg-slate-50 p-4 sm:p-6 md:p-8 md:pt-10">
                <slot />
            </main>
        </div>
    </div>
</template>