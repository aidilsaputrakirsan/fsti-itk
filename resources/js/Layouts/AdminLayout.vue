<script setup lang="ts">
import { Link, usePage, router } from '@inertiajs/vue3';
import {
    ChartBarSquareIcon,
    NewspaperIcon,
    TrophyIcon,
    UsersIcon,
    ArrowLeftOnRectangleIcon,
    ChevronRightIcon,
    InformationCircleIcon,
    AcademicCapIcon,
    ArchiveBoxIcon,
} from '@heroicons/vue/24/outline';
import { ref, onMounted } from 'vue';

const page = usePage();
const isProfileOpen = ref(false);

const openMenu = ref<string | null>(null);

const navigation = ref([
    { name: 'Dashboard', href: '/admin/dashboard', icon: ChartBarSquareIcon, children: null },
    { 
        name: 'Berita', 
        href: null,
        icon: NewspaperIcon, 
        children: [
            { name: 'Kelola Berita', href: '/admin/posts' }
        ] 
    },
    { 
        name: 'Prestasi', 
        href: null,
        icon: TrophyIcon,
        children: [
            { name: 'Kelola Daftar Prestasi', href: '/admin/achievements' }
        ]
    },
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
        name: 'Informasi & Layanan',
        href: null,
        icon: InformationCircleIcon,
        children: [
            { name: 'Zona Integritas', href: '/admin/integrity-zones' },
            { name: 'Alumni & Tracer', href: '/admin/alumni' },
            { name: 'Survei Kepuasan', href: '/admin/satisfaction-surveys' },
            { name: 'Layanan Internal', href: '/admin/internal-services' },
        ]
    },
    { name: 'Kelola Akun Admin', href: '/admin/users', icon: UsersIcon, children: null },
]);

const isParentUrlActive = (item: any) => {
    if (!item.children) return false;
    return item.children.some((child: any) => page.url.startsWith(child.href));
};

const toggleSubMenu = (name: string) => {
    if (openMenu.value === name) {
        openMenu.value = null;
        router.visit('/admin/dashboard');
    } else {
        openMenu.value = name;
    }
};

onMounted(() => {
    const currentParent = navigation.value.find(item => isParentUrlActive(item));
    if (currentParent) {
        openMenu.value = currentParent.name;
    }
});
</script>

<template>
    <div class="flex h-screen bg-[#CBDCEB] text-black">
        <aside class="flex w-72 flex-col flex-shrink-0 bg-white px-5 pt-6 pb-4 border-r border-gray-200 shadow-lg">
            <div class="px-4 mb-8">
                <img src="/images/logofsti.png" alt="Logo FSTI Prestasi" width="192" height="69" />
            </div>

            <nav class="flex-1 space-y-3 overflow-y-auto">
                <template v-for="item in navigation" :key="item.name">
                    <div>
                        <Link
                            v-if="!item.children"
                            :href="item.href"
                            :class="[
                                'flex items-center w-full p-3 transition-colors duration-200 rounded-lg',
                                page.url.startsWith(item.href)
                                    ? 'bg-[#4682A9] text-white shadow-md'
                                    : 'bg-[#CBDCEB] text-black hover:bg-[#a6c1da]', 
                            ]"
                        >
                            <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full">
                                <component :is="item.icon" :class="['h-5 w-5', page.url.startsWith(item.href) ? 'text-[#4682A9]' : 'text-black']" />
                            </span>
                            <span class="ml-4 font-semibold">{{ item.name }}</span>
                            <ChevronRightIcon class="h-5 w-5 ml-auto opacity-0" />
                        </Link>

                        <button
                            v-else
                            @click="toggleSubMenu(item.name)"
                            :class="[
                                'flex items-center w-full p-3 transition-colors duration-200 text-left',
                                openMenu === item.name ? 'rounded-t-lg bg-[#a6c1da]' : 'rounded-lg bg-[#CBDCEB]',
                                'text-black hover:bg-[#a6c1da]',
                            ]"
                        >
                            <span class="flex items-center justify-center h-8 w-8 bg-white rounded-full">
                                <component :is="item.icon" :class="['h-5 w-5', isParentUrlActive(item) ? 'text-[#4682A9]' : 'text-black']" />
                            </span>
                            <span class="ml-4 font-semibold">{{ item.name }}</span>
                            <ChevronRightIcon :class="['h-5 w-5 ml-auto transition-transform duration-200', openMenu === item.name ? 'rotate-90' : '']" />
                        </button>
                        
                        <div v-if="item.children && openMenu === item.name" class="bg-gray-50 rounded-b-lg border-x border-b border-gray-200 overflow-hidden">
                            <Link v-for="child in item.children" :key="child.name" :href="child.href"
                                :class="[
                                    'block w-full px-12 py-3 text-sm font-semibold transition-colors duration-200',
                                    page.url.startsWith(child.href) 
                                        ? 'bg-[#4682A9] text-white border-l-4 border-[#133E87]' 
                                        : 'text-black hover:bg-gray-200 hover:text-[#4682A9] border-l-4 border-transparent'
                                ]"
                            >
                                {{ child.name }}
                            </Link>
                        </div>
                    </div>
                </template>
            </nav>
            
            <div class="mt-auto pt-4 border-t border-gray-200">
                <Link 
                    href="/logout" 
                    method="post" 
                    as="button" 
                    class="flex w-full items-center justify-between rounded-lg p-3 bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 transition-colors duration-200"
                >
                    <span class="font-semibold">Keluar</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-md bg-red-600">
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