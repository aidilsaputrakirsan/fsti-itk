<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Plus, Search, Edit, Trash2, CheckCircle, XCircle } from 'lucide-vue-next';
import debounce from 'lodash/debounce';

const props = defineProps({
    staff: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');
const typeFilter = ref(props.filters.type || 'Semua');

watch([search, typeFilter], debounce(([newSearch, newType]) => {
    router.get(route('admin.staff.index'), { 
        search: newSearch, 
        type: newType 
    }, { preserveState: true, replace: true });
}, 300));

const deleteStaff = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data civitas ini?')) {
        router.delete(route('admin.staff.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Kelola Civitas" />

        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Kelola Civitas Akademika</h2>
            <Link :href="route('admin.staff.create')" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <Plus class="w-5 h-5 mr-2" /> Tambah Civitas
            </Link>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row gap-4">
                <div class="relative flex-grow max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Search class="h-5 w-5 text-gray-400" />
                    </div>
                    <input v-model="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Cari nama atau NIP...">
                </div>
                <select v-model="typeFilter" class="border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="Semua">Semua Tipe</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Tendik">Tenaga Kependidikan</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profil</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe & Jabatan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="person in staff.data" :key="person.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-full border border-gray-200 overflow-hidden bg-gray-100">
                                        <img :src="person.display_image" alt="" class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ person.name }}</div>
                                        <div class="text-sm text-gray-500">NIP: {{ person.nip || '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-1" :class="person.type === 'Dosen' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
                                    {{ person.type }}
                                </span>
                                <div class="text-xs text-gray-700 mt-1 line-clamp-1">{{ person.structural_position || person.functional_position || 'Belum ada jabatan' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span v-if="person.is_active" class="inline-flex items-center text-green-600 bg-green-50 px-2 py-1 rounded-md text-xs font-semibold">
                                    <CheckCircle class="w-4 h-4 mr-1" /> Aktif
                                </span>
                                <span v-else class="inline-flex items-center text-red-600 bg-red-50 px-2 py-1 rounded-md text-xs font-semibold">
                                    <XCircle class="w-4 h-4 mr-1" /> Nonaktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <Link :href="route('admin.staff.edit', person.id)" class="text-amber-600 hover:text-amber-900 bg-amber-50 p-2 rounded-lg transition-colors">
                                        <Edit class="w-4 h-4" />
                                    </Link>
                                    <button @click="deleteStaff(person.id)" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition-colors">
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="staff.data.length === 0">
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data civitas ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between" v-if="staff.links && staff.links.length > 3">
                <div class="flex flex-wrap gap-1">
                    <Link v-for="(link, k) in staff.links" :key="k" :href="link.url || '#'" 
                          class="px-3 py-1 text-sm border rounded-md" 
                          :class="{'bg-blue-600 text-white border-blue-600': link.active, 'text-gray-500 border-gray-300 hover:bg-gray-50': !link.active, 'opacity-50 cursor-not-allowed': !link.url}"
                          v-html="link.label">
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>