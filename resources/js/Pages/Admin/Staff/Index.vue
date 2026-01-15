<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import { MagnifyingGlassIcon, PlusIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';
import debounce from 'lodash/debounce';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    staff: Object;
    filters: Object;
}>();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');

const categories = [
    'Pimpinan Fakultas',
    'Dosen',
    'Tenaga Kependidikan',
    'Pimpinan Jurusan',
    'Pimpinan Prodi',
    'Pimpinan Laboratorium'
];

watch([search, category], debounce(() => {
    router.get(route('admin.staff.index'), {
        search: search.value,
        category: category.value
    }, { preserveState: true, replace: true });
}, 300));

const deleteStaff = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        router.delete(route('admin.staff.destroy', id));
    }
};
</script>

<template>
    <div>
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Civitas Akademika</h1>
                <p class="mt-1 text-black">Manajemen data Dosen, Pimpinan, dan Staf</p>
            </div>
            <Link :href="route('admin.staff.create')" class="inline-flex items-center px-4 py-2 bg-[#4682A9] text-white rounded-lg hover:bg-opacity-90 font-semibold text-sm">
                <PlusIcon class="w-5 h-5 mr-2" />
                Tambah Baru
            </Link>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <MagnifyingGlassIcon class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" />
                    <input 
                        v-model="search" 
                        type="text" 
                        placeholder="Cari Nama atau NIP..." 
                        class="w-full pl-10 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
                <div>
                     <select v-model="category" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori</option>
                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <table class="w-full whitespace-nowrap text-left text-sm">
                <thead class="bg-gray-50 text-gray-900 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Nama & NIP</th>
                        <th class="px-6 py-4">Kategori / Jabatan</th>
                        <th class="px-6 py-4">Prodi / Jurusan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="person in staff.data" :key="person.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img 
                                    :src="person.image_path || 'https://ui-avatars.com/api/?name=' + person.name" 
                                    class="h-10 w-10 rounded-full object-cover mr-3 border"
                                    alt=""
                                >
                                <div>
                                    <div class="font-medium text-gray-900">{{ person.name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ person.nip || '-' }}</div>
                                </div>
                            </div>
                        </td>
                         <td class="px-6 py-4">
                            <div class="text-gray-900 font-semibold">{{ person.category }}</div>
                            <div class="text-xs text-gray-500">{{ person.position || '-' }}</div>
                        </td>
                         <td class="px-6 py-4">
                            <div class="text-gray-900">{{ person.prodi || '-' }}</div>
                            <div class="text-xs text-gray-500">{{ person.jurusan }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span 
                                class="px-2 py-1 text-xs rounded-full font-semibold"
                                :class="person.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                            >
                                {{ person.is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                             <div class="flex items-center justify-center gap-2">
                                <Link
                                    :href="route('admin.staff.edit', person.id)"
                                    class="rounded p-2 text-blue-600 hover:bg-blue-50"
                                    title="Edit"
                                >
                                    <PencilSquareIcon class="h-5 w-5" />
                                </Link>
                                <button
                                    @click="deleteStaff(person.id)"
                                    class="rounded p-2 text-red-600 hover:bg-red-50"
                                    title="Hapus"
                                >
                                    <TrashIcon class="h-5 w-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="staff.data.length === 0">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
         <div v-if="staff.links.length > 3" class="mt-6 flex justify-center">
            <div class="flex gap-1">
                <Component
                    :is="link.url ? Link : 'span'"
                    v-for="(link, key) in staff.links"
                    :key="key"
                    :href="link.url"
                    v-html="link.label"
                    class="px-4 py-2 border rounded-lg text-sm transition-colors duration-200"
                    :class="[
                        link.active ? 'bg-[#4682A9] text-white border-[#4682A9]' : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-300',
                        !link.url ? 'text-gray-400 cursor-not-allowed hover:bg-white' : ''
                    ]"
                />
            </div>
        </div>
    </div>
</template>
