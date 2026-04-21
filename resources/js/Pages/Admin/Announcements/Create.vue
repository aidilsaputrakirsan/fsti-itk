<script setup lang="ts">
import { computed } from 'vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, PaperAirplaneIcon, DocumentIcon, PhotoIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

interface AnnouncementForm {
    title: string;
    description: string;
    document: File | null;
    poster: File | null;
}

const form = useForm<AnnouncementForm>({
    title: '',
    description: '',
    document: null,
    poster: null,
});

const documentNameDisplay = computed(() => {
    if (form.document instanceof File) {
        return form.document.name;
    }
    return 'Pilih file PDF (Opsional, Maks. 5 MB)';
});

const posterNameDisplay = computed(() => {
    if (form.poster instanceof File) {
        return form.poster.name;
    }
    return 'Pilih gambar JPG/PNG (Opsional, Maks. 2 MB)';
});

const validateForm = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.title) {
        form.setError('title', 'Judul pengumuman wajib diisi.');
        hasError = true;
    }

    if (form.document) {
        if (form.document.type !== 'application/pdf') {
            form.setError('document', 'Format file dokumen harus PDF.');
            hasError = true;
        } else if (form.document.size > 5 * 1024 * 1024) {
            form.setError('document', 'Ukuran file dokumen maksimal 5 MB.');
            hasError = true;
        }
    }

    if (form.poster) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!allowedTypes.includes(form.poster.type)) {
            form.setError('poster', 'Format file gambar harus JPG, PNG, atau WEBP.');
            hasError = true;
        } else if (form.poster.size > 2 * 1024 * 1024) {
            form.setError('poster', 'Ukuran file gambar maksimal 2 MB.');
            hasError = true;
        }
    }

    return !hasError;
};

const submit = () => {
    if (!validateForm()) return;
    form.post(route('admin.announcements.store'));
};
</script>

<template>
    <div>
        <Head title="Buat Pengumuman Baru" />

        <div class="mb-8">
            <Link :href="route('admin.announcements.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Buat Pengumuman Baru</h1>
            <p class="mt-1 text-gray-600">Terbitkan surat edaran atau informasi penting untuk mahasiswa FSTI.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Judul Pengumuman <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.title" type="text" placeholder="Contoh: Pengumuman Pelaksanaan UTS" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.title ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.title" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Keterangan Singkat</label>
                    <div>
                        <textarea v-model="form.description" rows="5" placeholder="Beri penjelasan singkat mengenai edaran ini..." 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.description ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                        <InputError :message="form.errors.description" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Lampiran Dokumen</label>
                    <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl relative focus-within:bg-white focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-colors cursor-pointer">
                        <div class="flex items-center gap-3">
                            <DocumentIcon class="h-8 w-8 text-primary opacity-80 flex-shrink-0" />
                            <div class="flex-grow min-w-0">
                                <p class="text-sm font-bold text-gray-800 mb-0.5 truncate">{{ documentNameDisplay }}</p>
                                <p class="text-xs text-gray-500 font-medium truncate">Dokumen asli yang akan diunduh oleh mahasiswa.</p>
                            </div>
                        </div>
                        <input
                            type="file"
                            accept="application/pdf"
                            @input="form.document = ($event.target as HTMLInputElement).files?.[0] || null"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        />
                        <InputError :message="form.errors.document" class="mt-3 relative z-10" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Poster / Cover</label>
                    <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl relative focus-within:bg-white focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-colors cursor-pointer">
                        <div class="flex items-center gap-3">
                            <PhotoIcon class="h-8 w-8 text-primary opacity-80 flex-shrink-0" />
                            <div class="flex-grow min-w-0">
                                <p class="text-sm font-bold text-gray-800 mb-0.5 truncate">{{ posterNameDisplay }}</p>
                                <p class="text-xs text-gray-500 font-medium truncate">Jika tidak diisi, sistem menggunakan cover standar FSTI.</p>
                            </div>
                        </div>
                        <input
                            type="file"
                            accept="image/*"
                            @input="form.poster = ($event.target as HTMLInputElement).files?.[0] || null"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        />
                        <InputError :message="form.errors.poster" class="mt-3 relative z-10" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.announcements.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Mengunggah...' : 'Terbitkan Pengumuman' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>