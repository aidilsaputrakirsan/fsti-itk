<script setup lang="ts">
import { computed } from 'vue';
import { Link, useForm, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, PaperAirplaneIcon, DocumentIcon, LinkIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    categories: any[];
}>();

interface PpidFormData {
    kategori_ppid_id: string | number;
    judul_dokumen: string;
    file: File | null;
    file_url: string;
}

const form = useForm<PpidFormData>({
    kategori_ppid_id: '',
    judul_dokumen: '',
    file: null,
    file_url: '',
});

const fileNameDisplay = computed(() => {
    if (form.file instanceof File) {
        return form.file.name;
    }
    return 'Pilih file PDF (Opsional, Maks. 10 MB)';
});

const validateForm = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.kategori_ppid_id) {
        form.setError('kategori_ppid_id', 'Kategori dokumen wajib dipilih.');
        hasError = true;
    }

    if (!form.judul_dokumen) {
        form.setError('judul_dokumen', 'Judul dokumen wajib diisi.');
        hasError = true;
    }

    if (form.file) {
        if (form.file.type !== 'application/pdf') {
            form.setError('file', 'Format file dokumen harus PDF.');
            hasError = true;
        } else if (form.file.size > 10 * 1024 * 1024) {
            form.setError('file', 'Ukuran file dokumen maksimal 10 MB.');
            hasError = true;
        }
    }

    return !hasError;
};

const submit = () => {
    if (!validateForm()) return;
    form.post(route('admin.ppid.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Dokumen PPID" />

        <div class="mb-8">
            <Link :href="route('admin.ppid.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Dokumen PPID</h1>
            <p class="mt-1 text-gray-600">Unggah file PDF atau masukkan tautan dokumen informasi publik.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Kategori Dokumen <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.kategori_ppid_id" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.kategori_ppid_id ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                            <option value="" disabled>-- Pilih Kategori --</option>
                            <option v-for="kat in categories" :key="kat.id" :value="kat.id">
                                [{{ kat.jenis_informasi }}] {{ kat.nama_kategori }}
                            </option>
                        </select>
                        <InputError :message="form.errors.kategori_ppid_id" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Judul Dokumen <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.judul_dokumen" type="text" placeholder="Contoh: Laporan Keuangan FSTI 2025" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.judul_dokumen ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.judul_dokumen" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Unggah File PDF</label>
                    <div class="overflow-hidden">
                        <div class="relative flex items-center w-full rounded-lg border border-gray-300 bg-gray-50 hover:bg-white focus-within:bg-white focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-colors shadow-sm px-4 py-3 cursor-pointer min-w-0" :class="{'opacity-50 cursor-not-allowed': form.file_url !== ''}">
                            <DocumentIcon class="h-5 w-5 text-gray-400 flex-shrink-0" />
                            <span class="ml-3 text-sm truncate block flex-grow overflow-hidden text-ellipsis" :class="{'text-gray-400': !form.file, 'text-gray-900 font-medium': form.file}">
                                {{ fileNameDisplay }}
                            </span>
                            <input
                                type="file"
                                accept=".pdf"
                                @input="form.file = ($event.target as HTMLInputElement).files?.[0] || null"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                :disabled="form.file_url !== ''"
                            />
                        </div>
                        <p class="mt-2 text-[11px] text-gray-500 font-medium">Hanya bisa diisi jika opsi Tautan Eksternal kosong.</p>
                        <InputError :message="form.errors.file" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Tautan Eksternal</label>
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <LinkIcon class="h-5 w-5 text-gray-400" />
                            </div>
                            <input v-model="form.file_url" type="text" placeholder="https://..." 
                                class="block w-full pl-10 rounded-lg transition-colors py-3"
                                :class="[
                                    form.errors.file_url ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white',
                                    form.file !== null ? 'opacity-50 cursor-not-allowed bg-gray-100' : ''
                                ]" 
                                :disabled="form.file !== null"
                            >
                        </div>
                        <div class="mt-3 bg-blue-50 border border-blue-100 rounded-lg p-3 text-xs text-gray-700 leading-relaxed">
                            Gunakan opsi ini jika dokumen terlalu besar untuk diunggah langsung (Maks 10 MB). Unggah file ke Google Drive (pastikan akses terbuka untuk publik), lalu masukkan link-nya ke kolom ini.
                        </div>
                        <InputError :message="form.errors.file_url" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.ppid.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>