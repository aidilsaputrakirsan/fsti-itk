<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';

defineProps({
    studyPrograms: Array
});

const form = useForm({});

const deleteProdi = (id, name) => {
    if (confirm(`Apakah Anda yakin ingin menghapus Program Studi ${name}?`)) {
        form.delete(route('admin.study-programs.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Kelola Program Studi" />

        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Program Studi</h1>
                <p class="mt-1 text-black">Daftar program studi yang ada di Fakultas Sains dan Teknologi Informasi</p>
            </div>
            <Link :href="route('admin.study-programs.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 transition">
                <PlusIcon class="h-5 w-5" />
                Tambah Prodi
            </Link>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-900">Jenjang</th>
                            <th class="px-6 py-4 font-semibold text-gray-900">Nama Program Studi</th>
                            <th class="px-6 py-4 font-semibold text-gray-900">Sertifikat Akreditasi</th>
                            <th class="px-6 py-4 font-semibold text-gray-900 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="prodi in studyPrograms" :key="prodi.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-[#4682A9] ring-1 ring-inset ring-blue-700/10">
                                    {{ prodi.degree }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ prodi.name }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <span v-if="prodi.accreditation_certificate_image" class="text-green-600 font-medium">✓ Tersedia</span>
                                <span v-else class="text-red-500">✗ Kosong</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <Link :href="route('admin.study-programs.edit', prodi.id)" class="text-[#4682A9] hover:text-blue-900 bg-blue-50 p-2 rounded-md transition" title="Edit">
                                        <PencilSquareIcon class="w-5 h-5" />
                                    </Link>
                                    <button @click="deleteProdi(prodi.id, prodi.name)" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-md transition" title="Hapus">
                                        <TrashIcon class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="studyPrograms.length === 0">
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data program studi.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>