<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, CheckIcon, XMarkIcon, DocumentIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

// Interface untuk menjaga akurasi tipe data dan mencegah error "deep instantiation"
interface Kategori {
    id: number;
    jenis_informasi: string;
    nama_kategori: string;
}

interface DocumentPPID {
    id: number;
    kategori_ppid_id: number;
    judul_dokumen: string;
    file_url: string | null;
}

const props = defineProps<{
    document: DocumentPPID;
    kategoris: Kategori[];
}>();

const form = useForm({
    kategori_ppid_id: props.document.kategori_ppid_id as number | string,
    judul_dokumen: props.document.judul_dokumen as string,
    file: null as File | null,
    file_url: (props.document.file_url || '') as string, 
    _method: 'PUT' as string
});

const submit = () => {
    // Kita gunakan form.post karena Inertia mengirimkan file fisik via POST (dengan bantuan _method PUT)
    form.post(route('admin.ppid.update', props.document.id));
};
</script>

<template>
    <div>
        <div class="mb-8 flex items-center gap-4">
            <Link :href="route('admin.ppid.index')" class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-gray-200 hover:bg-gray-50 transition-colors">
                <ArrowLeftIcon class="h-5 w-5 text-gray-600" />
            </Link>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Dokumen PPID</h1>
                <p class="mt-1 text-sm text-gray-600">Perbarui informasi, ganti file, atau ubah tautan dokumen informasi publik.</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden w-full">
            <div class="bg-gray-50/50 px-8 py-5 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Detail Dokumen</h3>
            </div>
            
            <form @submit.prevent="submit" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Kategori <span class="text-red-500">*</span></label>
                        <select v-model="form.kategori_ppid_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] text-sm" required>
                            <option value="" disabled>-- Pilih Kategori --</option>
                            <option v-for="kat in kategoris" :key="kat.id" :value="kat.id">
                                [{{ kat.jenis_informasi }}] {{ kat.nama_kategori }}
                            </option>
                        </select>
                        <p v-if="form.errors.kategori_ppid_id" class="text-xs text-red-500 mt-1">{{ form.errors.kategori_ppid_id }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                        <input v-model="form.judul_dokumen" type="text" placeholder="Contoh: Laporan Keuangan FSTI 2025" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] text-sm" required>
                        <p v-if="form.errors.judul_dokumen" class="text-xs text-red-500 mt-1">{{ form.errors.judul_dokumen }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                    <div class="p-6 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/30">
                        <label class="block text-sm font-bold text-[#4682A9] mb-3 flex items-center">
                            <DocumentIcon class="w-5 h-5 mr-2" />
                            Opsi 1: Ganti File PDF
                        </label>
                        <input 
                            type="file" 
                            @input="form.file = ($event.target as HTMLInputElement).files?.[0] || null" 
                            accept=".pdf" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition" 
                        />
                        
                        <div v-if="props.document.file_url && props.document.file_url.includes('/storage/')" class="mt-3 p-2.5 bg-blue-50 rounded-lg border border-blue-100 flex items-center justify-between">
                            <div class="flex items-center">
                                <DocumentIcon class="w-4 h-4 text-blue-500 mr-2" />
                                <span class="text-xs text-blue-700 font-medium italic">File PDF sudah tersedia di server</span>
                            </div>
                            <a 
                                v-if="form.file_url"
                                :href="form.file_url" 
                                target="_blank" 
                                class="text-[10px] bg-[#4682A9] text-white px-2 py-1 rounded hover:bg-[#133E87] transition"
                            >
                                Pratinjau File
                            </a>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-2 italic">* Biarkan kosong jika tidak ingin mengganti file lama.</p>
                        <p v-if="form.errors.file" class="text-xs text-red-500 mt-1">{{ form.errors.file }}</p>
                    </div>

                    <div class="p-6 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/30">
                        <label class="block text-sm font-bold text-[#4682A9] mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Opsi 2: Tautan Halaman Web FSTI atau Google Drive
                        </label>
                        <input 
                            v-model="form.file_url" 
                            type="text" 
                            placeholder="Contoh: https://fsti.itk.ac.id/profil/dosen" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] text-sm"
                            :disabled="form.file !== null"
                        >
                        
                        <div class="mt-3 text-[11px] sm:text-xs text-gray-600 bg-blue-50 p-3 rounded-lg border border-blue-100 leading-relaxed">
                            <p class="font-bold text-blue-800 mb-1">Cara menggunakan opsi ini:</p>
                            <ul class="list-decimal pl-4 space-y-1">
                                <li><b>Halaman Web FSTI:</b> Buka halaman web FSTI yang ingin ditautkan, <i>copy</i> seluruh link di atas browser, lalu <i>paste</i> ke sini.</li>
                                <li><b>Google Drive:</b> Jika file sangat besar, upload ke Google Drive, atur akses ke "Siapa saja yang memiliki link", lalu <i>paste</i> link ke sini.</li>
                            </ul>
                        </div>
                        <p v-if="form.errors.file_url" class="text-xs text-red-500 mt-1">{{ form.errors.file_url }}</p>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-200 flex items-center justify-end gap-3">
                    <Link :href="route('admin.ppid.index')" class="inline-flex items-center gap-2 rounded-lg bg-white border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <XMarkIcon class="w-4 h-4" />
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#133E87] shadow-sm transition-colors disabled:opacity-50">
                        <CheckIcon class="w-4 h-4" v-if="!form.processing" />
                        <svg v-else class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>