<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, PaperAirplaneIcon, DocumentIcon, PhotoIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const form = useForm({
    title: '',
    description: '',
    document: null,
    poster: null,
});

const submit = () => form.post(route('admin.announcements.store'));
</script>

<template>
    <div>
        <div class="mb-8 flex items-center gap-4">
            <Link :href="route('admin.announcements.index')" class="p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 text-gray-600">
                <ArrowLeftIcon class="w-5 h-5" />
            </Link>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Buat Pengumuman Baru</h1>
                <p class="mt-1 text-gray-600">Terbitkan surat edaran atau informasi penting untuk mahasiswa</p>
            </div>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit" class="space-y-6">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                            <input v-model="form.title" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" placeholder="Contoh: Pengumuman Pelaksanaan UTS" required />
                            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Keterangan Singkat (Opsional)</label>
                            <textarea v-model="form.description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" placeholder="Beri penjelasan singkat mengenai edaran ini..."></textarea>
                            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="p-6 bg-slate-50 border border-slate-200 rounded-xl">
                            <label class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-3"><DocumentIcon class="w-5 h-5 text-red-500"/> Lampiran Surat / PDF (Max 5MB)</label>
                            <p class="text-xs text-slate-500 mb-3">Dokumen asli yang akan diunduh oleh mahasiswa.</p>
                            <input type="file" @input="form.document = $event.target.files[0]" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <div v-if="form.errors.document" class="text-red-500 text-sm mt-2">{{ form.errors.document }}</div>
                        </div>

                        <div class="p-6 bg-slate-50 border border-slate-200 rounded-xl">
                            <label class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-3"><PhotoIcon class="w-5 h-5 text-indigo-500"/> Poster / Cover JPG (Opsional)</label>
                            <p class="text-xs text-slate-500 mb-3">Jika tidak diisi, sistem akan menggunakan desain cover standar FSTI.</p>
                            <input type="file" @input="form.poster = $event.target.files[0]" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <div v-if="form.errors.poster" class="text-red-500 text-sm mt-2">{{ form.errors.poster }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.announcements.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5" /> <span v-if="form.processing">Mengunggah...</span> <span v-else>Terbitkan Pengumuman</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>