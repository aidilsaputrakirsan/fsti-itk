<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { PencilSquareIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    pages: Array<{
        id: number;
        key: string;
        title: string;
        updated_at: string;
    }>;
}>();
</script>

<template>
    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-black">Kelola Profil Fakultas</h1>
            <p class="mt-1 text-black">Ubah konten Visi, Misi, dan Bagan Organisasi website</p>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <table class="w-full whitespace-nowrap text-left text-sm">
                <thead class="bg-gray-50 text-gray-900 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Judul Halaman</th>
                        <th class="px-6 py-4">Key</th>
                        <th class="px-6 py-4">Terakhir Diupdate</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="page in pages" :key="page.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ page.title }}</td>
                        <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ page.key }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ new Date(page.updated_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <Link
                                    :href="route('admin.static-pages.edit', page.id)"
                                    class="rounded p-2 text-blue-600 hover:bg-blue-50"
                                    title="Edit Halaman"
                                >
                                    <PencilSquareIcon class="h-5 w-5" />
                                </Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
