<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

interface KegiatanForm {
    title: string;
    organizer: string;
    start_date: string;
    end_date: string;
    location: string;
    description: string;
}

const form = useForm<KegiatanForm>({
    title: '',
    organizer: '',
    start_date: '',
    end_date: '',
    location: '',
    description: '',
});

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.title) {
        form.setError('title', 'Judul kegiatan wajib diisi.');
        hasError = true;
    }

    if (!form.start_date) {
        form.setError('start_date', 'Tanggal mulai wajib diisi.');
        hasError = true;
    }

    if (form.start_date && form.end_date) {
        if (new Date(form.end_date) < new Date(form.start_date)) {
            form.setError('end_date', 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
            hasError = true;
        }
    }

    if (hasError) return;

    form.post((route as Function)('admin.kegiatan-mahasiswa.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Kegiatan Mahasiswa" />

        <div class="mb-8">
            <Link :href="(route as Function)('admin.kegiatan-mahasiswa.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Kegiatan</h1>
            <p class="mt-1 text-gray-600">Tambahkan data kegiatan mahasiswa baru FSTI ITK.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Judul Kegiatan <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.title" type="text" placeholder="Contoh: Latihan Keterampilan Manajemen Mahasiswa" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.title ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.title" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Penyelenggara</label>
                    <div>
                        <input v-model="form.organizer" type="text" placeholder="Contoh: HIMA Statistika, BEM FSTI" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.organizer ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                        <InputError :message="form.errors.organizer" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Lokasi / Tempat</label>
                    <div>
                        <input v-model="form.location" type="text" placeholder="Contoh: Auditorium Kampus" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.location ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                        <InputError :message="form.errors.location" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Tanggal Pelaksanaan <span class="text-red-600">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Mulai</label>
                            <input v-model="form.start_date" type="date" 
                                class="block w-full rounded-lg transition-colors py-3"
                                :class="form.errors.start_date ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                                required>
                            <InputError :message="form.errors.start_date" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Selesai (Opsional)</label>
                            <input v-model="form.end_date" type="date" 
                                class="block w-full rounded-lg transition-colors py-3"
                                :class="form.errors.end_date ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                            <InputError :message="form.errors.end_date" />
                        </div>
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Deskripsi Singkat</label>
                    <div>
                        <textarea v-model="form.description" rows="4" placeholder="Keterangan singkat mengenai kegiatan..." 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.description ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                        <InputError :message="form.errors.description" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="(route as Function)('admin.kegiatan-mahasiswa.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
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