<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, PaperAirplaneIcon, DocumentIcon, PhotoIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });
const props = defineProps({ announcement: Object });

const form = useForm({
    title: props.announcement.title,
    description: props.announcement.description || '',
    document: null,
    poster: null,
    _method: 'put', 
});

const submit = () => form.post(route('admin.announcements.update', props.announcement.id));
</script>

<template>
    <div>
        <div class="mb-8 flex items-center gap-4">
            <Link :href="route('admin.announcements.index')" class="p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 text-gray-600"><ArrowLeftIcon class="w-5 h-5" /></Link>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Pengumuman</h1>
                <p class="mt-1 text-gray-600">Perbarui informasi untuk: <strong>{{ props.announcement.title }}</strong></p>
            </div>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit" class="space-y-6">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                            <input v-model="form.title" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Keterangan Singkat</label>
                            <textarea v-model="form.description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="p-6 bg-slate-50 border border-slate-200 rounded-xl relative">
                            <label class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-3"><DocumentIcon class="w-5 h-5 text-red-500"/> Ganti File PDF</label>
                            <input type="file" @input="form.document = $event.target.files[0]" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <div v-if="props.announcement.document_path" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-green-600 bg-green-100 px-3 py-1.5 rounded-md border border-green-200">
                                <CheckCircleIcon class="w-4 h-4"/> PDF Tersedia (Biarkan kosong jika tidak diganti)
                            </div>
                        </div>

                        <div class="p-6 bg-slate-50 border border-slate-200 rounded-xl relative">
                            <label class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-3"><PhotoIcon class="w-5 h-5 text-indigo-500"/> Ganti Poster / Cover</label>
                            <input type="file" @input="form.poster = $event.target.files[0]" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <div v-if="props.announcement.poster_path" class="mt-4">
                                <p class="text-xs text-gray-500 font-bold mb-2 uppercase">Poster Saat Ini:</p>
                                <img :src="`/storage/${props.announcement.poster_path}`" class="h-20 rounded border border-gray-200 shadow-sm object-cover" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.announcements.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5" /> <span v-if="form.processing">Menyimpan...</span> <span v-else>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>