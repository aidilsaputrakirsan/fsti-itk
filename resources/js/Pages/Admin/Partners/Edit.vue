<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    partner: Object
});

const form = useForm({
    name: props.partner.name,
    activities_text: props.partner.activities ? props.partner.activities.join('\n') : '',
    logo: null,
    _method: 'put', 
});

const submit = () => {
    form.post(route('admin.partners.update', props.partner.id));
};
</script>

<template>
    <div>
        <div class="mb-8 flex items-center gap-4">
            <Link :href="route('admin.partners.index')" class="p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 text-gray-600">
                <ArrowLeftIcon class="w-5 h-5" />
            </Link>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Data Kerjasama</h1>
                <p class="mt-1 text-gray-600">Perbarui informasi dan daftar kegiatan untuk <strong>{{ props.partner.name }}</strong></p>
            </div>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Nama Institusi / Mitra <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required />
                            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1 font-medium">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Ganti Logo (JPG/PNG)</label>
                            <div class="mt-1 relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-3 hover:bg-gray-50 cursor-pointer">
                                <PaperClipIcon class="h-5 w-5 text-gray-400" />
                                <span class="ml-3 text-sm text-gray-600 font-medium">
                                    {{ form.logo ? form.logo.name : 'Biarkan kosong jika tidak ingin mengubah logo' }}
                                </span>
                                <input type="file" @input="form.logo = $event.target.files[0]" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" />
                            </div>
                            <div v-if="form.errors.logo" class="text-red-500 text-sm mt-1 font-medium">{{ form.errors.logo }}</div>

                            <div v-if="props.partner.logo" class="mt-4 p-4 border border-gray-200 rounded-lg bg-slate-50 w-max">
                                <p class="text-xs text-gray-500 mb-2 font-bold uppercase tracking-wider">Logo Saat Ini</p>
                                <img :src="`/images/mitra/${props.partner.logo}`" class="h-20 object-contain mix-blend-multiply" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Daftar Kegiatan</label>
                        <p class="text-xs text-gray-500 mb-2">Pisahkan setiap kegiatan dengan menekan tombol <strong>Enter</strong> (baris baru). Kosongkan jika tidak ada kegiatan aktif.</p>
                        <textarea v-model="form.activities_text" rows="8" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                        <div v-if="form.errors.activities_text" class="text-red-500 text-sm mt-1 font-medium">{{ form.errors.activities_text }}</div>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.partners.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5" />
                        <span v-if="form.processing">Menyimpan...</span>
                        <span v-else>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>