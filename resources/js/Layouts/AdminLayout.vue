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
    UserGroupIcon, // Ditambahkan untuk ikon Kemahasiswaan
} from '@heroicons/vue/24/outline';
import { ref, onMounted, computed } from 'vue';

const page = usePage();
const openMenu = ref<string | null>(null);

// Menggunakan computed untuk memantau perubahan URL secara reaktif
const currentUrl = computed(() => page.url);

const navigation = [
    { name: 'Dashboard', href: '/admin/dashboard', icon: ChartBarSquareIcon, children: null },
    { 
        name: 'Berita', 
        href: null,
        icon: NewspaperIcon, 
        children: [
            { name: 'Kelola Berita', href: '/admin/posts' },
            { name: 'Kelola Kategori Berita', href: '/admin/post-categories' },
        ] 
    },
    // --- FIX: Menu Kemahasiswaan (Gabungan Prestasi dan Layanan) ---
    { 
        name: 'Kemahasiswaan', 
        href: null,
        icon: UserGroupIcon,
        children: [
            { name: 'Kelola Daftar Prestasi', href: '/admin/achievements' },
            { name: 'Kelola Portal Layanan Mahasiswa', href: '/admin/internal-services' }
        ]
    },
    // ---------------------------------------------------------------
    {
        name: 'Profil Fakultas',
        href: null,
        icon: AcademicCapIcon,
        children: [
            { name: 'Kelola Halaman', href: '/admin/static-pages' },
            { name: 'Civitas Akademika', href: '/admin/staff' },
        ]
    },
    {
        name: 'PPID',
        href: null,
        icon: ArchiveBoxIcon,
        children: [
            { name: 'Kelola PPID', href: '/admin/ppid' },
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
        name: 'Alumni', // Diubah dari "Informasi & Layanan" karena Layanan sudah dipindah
        href: null,
        icon: InformationCircleIcon,
        children: [
            { name: 'Alumni & Tracer', href: '/admin/alumni' },
        ]
    },
    { name: 'Kelola Akun Admin', href: '/admin/users', icon: UsersIcon, children: null },
];

const isParentUrlActive = (item: any) => {
    if (!item.children) return false;
    // Gunakan currentUrl.value agar reaktif
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
    const currentParent = navigation.find(item => isParentUrlActive(item));
    if (currentParent) {
        openMenu.value = currentParent.name;
    }
});
</script>

<template>
    <div class="flex h-screen bg-[#CBDCEB] text-black">
        <aside class="flex w-72 flex-col flex-shrink-0 bg-white px-5 pt-6 pb-4 border-r border-gray-200 shadow-lg">
            <div class="px-4 mb-8">
                <img src="/images/logofsti.png" alt="Logo FSTI" width="192" height="69" />
            </div>

            <nav class="flex-1 space-y-3 overflow-y-auto">
                <template v-for="item in navigation" :key="item.name">
                    <div>
                        <Link
                            v-if="!item.children"
                            :href="item.href"
                            :class="[
                                'flex items-center w-full p-3 transition-colors duration-200 rounded-lg',
                                currentUrl.startsWith(item.href)
                                    ? 'bg-[#4682A9] text-white shadow-md'
                                    : 'bg-[#CBDCEB] text-black hover:bg-[#a6c1da]', 
                            ]"
                        >
                            <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full">
                                <component :is="item.icon" :class="['h-5 w-5', currentUrl.startsWith(item.href) ? 'text-[#4682A9]' : 'text-black']" />
                            </span>
                            <span class="ml-4 font-semibold">{{ item.name }}</span>
                        </Link>

                        <div v-else>
                            <button
                                @click="toggleSubMenu(item.name)"
                                :class="[
                                    'flex items-center w-full p-3 transition-colors duration-200 text-left rounded-lg',
                                    openMenu === item.name || isParentUrlActive(item) ? 'bg-[#a6c1da]' : 'bg-[#CBDCEB]',
                                    'text-black hover:bg-[#a6c1da]',
                                ]"
                            >
                                <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full">
                                    <component :is="item.icon" :class="['h-5 w-5', isParentUrlActive(item) ? 'text-[#4682A9]' : 'text-black']" />
                                </span>
                                <span class="ml-4 font-semibold flex-1">{{ item.name }}</span>
                                <ChevronRightIcon :class="['h-5 w-5 transition-transform duration-200', openMenu === item.name ? 'rotate-90' : '']" />
                            </button>
                            
                            <div v-show="openMenu === item.name" class="bg-gray-50 rounded-b-lg border-x border-b border-gray-200 overflow-hidden mt-1">
                                <Link v-for="child in item.children" :key="child.name" :href="child.href"
                                    :class="[
                                        'block w-full px-12 py-3 text-sm font-semibold transition-colors duration-200',
                                        currentUrl.startsWith(child.href) 
                                            ? 'bg-[#4682A9] text-white border-l-4 border-[#133E87]' 
                                            : 'text-black hover:bg-gray-200 hover:text-[#4682A9] border-l-4 border-transparent'
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
                    class="flex items-center justify-between w-full p-3 transition-colors duration-200 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 border border-red-200"
                >
                    <span class="font-semibold">Keluar</span>
                    <span class="flex items-center justify-center w-7 h-7 bg-red-600 rounded-md">
                        <ArrowLeftOnRectangleIcon class="h-4 w-4 text-white" />
                    </span>
                </Link>
            </div>
        </aside>

        <div class="flex flex-1 flex-col overflow-x-hidden">
            <main class="flex-1 overflow-auto bg-[#CBDCEB] p-8">
                <slot />
            </main>
        </div>
    </div>
</template>