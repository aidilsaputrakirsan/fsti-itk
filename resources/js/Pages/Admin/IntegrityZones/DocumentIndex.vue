<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { TrashIcon, DocumentPlusIcon, DocumentIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    documents: any;
}>();

const form = useForm({
    title: '',
    file: null as File | null,
    file_url: '',
});

// FUNGSI HELPER UNTUK MENGATASI ERROR TYPESCRIPT
const handleFileUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.file = target.files?.[0] || null;
};

const submit = () => {
    form.post(route('admin.zi.document.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('title', 'file', 'file_url'),
    });
};

const deleteDoc = (id: number) => {
    if (confirm('Yakin ingin menghapus dokumen ini?')) {
        form.delete(route('admin.zi.document.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Dokumen ZI" />

    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Dokumen Zona Integritas</h1>
            <p class="mt-1 text-sm text-gray-600">Unggah dokumen bukti seperti SK Tim, SK Role Model, atau Rencana Kerja di sini.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm sticky top-6">
                    <h3 class="text-lg font-bold text-[#133E87] mb-4 flex items-center">
                        <DocumentPlusIcon class="w-5 h-5 mr-2" /> Tambah Dokumen Baru
                    </h3>
                    <form @submit.prevent="submit" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
                            <input v-model="form.title" type="text" placeholder="Contoh: SK Role Model ZI 2025" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#4682A9] text-sm" required>
                            <p v-if="form.errors.title" class="text-xs text-red-500 mt-1">{{ form.errors.title }}</p>
                        </div>
                        
                        <div class="p-4 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50/50">
                            <label class="block text-sm font-bold text-[#4682A9] mb-2 flex items-center">
                                <DocumentIcon class="w-4 h-4 mr-2" /> Opsi 1: Upload PDF
                            </label>
                            <input type="file" @change="handleFileUpload" accept=".pdf" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" :disabled="form.file_url !== ''">
                            <p v-if="form.errors.file" class="text-xs text-red-500 mt-1">{{ form.errors.file }}</p>
                        </div>

                        <div class="p-4 border-2 border-dashed border-gray-200 rounded-lg bg-gray-50/50">
                            <label class="block text-sm font-bold text-[#4682A9] mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                Opsi 2: Link Google Drive
                            </label>
                            <input v-model="form.file_url" type="text" placeholder="https://drive.google.com/..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] text-xs" :disabled="form.file !== null">
                            <p v-if="form.errors.file_url" class="text-xs text-red-500 mt-1">{{ form.errors.file_url }}</p>
                        </div>

                        <button type="submit" :disabled="form.processing" class="w-full justify-center inline-flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white hover:bg-[#133E87] transition">
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Dokumen' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Judul Dokumen & Tautan</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="doc in documents.data" :key="doc.id" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ doc.title }}</div>
                                    <a :href="doc.file_url" target="_blank" class="text-xs text-blue-600 hover:underline flex items-center mt-1 w-fit">
                                        <DocumentIcon class="w-3 h-3 mr-1" /> Lihat Dokumen
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button @click="deleteDoc(doc.id)" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors">
                                        <TrashIcon class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="documents.data.length === 0">
                                <td colspan="2" class="px-6 py-8 text-center text-sm text-gray-500 italic">Belum ada dokumen ZI yang ditambahkan.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>