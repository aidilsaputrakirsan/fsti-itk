<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    service: {
        id: number;
        name: string;
        description: string;
        link_url: string;
        sort_order: number;
        is_active: boolean;
    };
}>();

interface ServiceFormData {
    _method: string;
    name: string;
    description: string;
    link_url: string;
    sort_order: number;
    is_active: boolean;
}

const form = useForm<ServiceFormData>({
    _method: 'PUT',
    name: props.service.name,
    description: props.service.description,
    link_url: props.service.link_url,
    sort_order: props.service.sort_order,
    is_active: Boolean(props.service.is_active),
});

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) { 
        form.setError('name', 'Nama layanan wajib diisi.'); 
        hasError = true; 
    }
    
    if (!form.description) { 
        form.setError('description', 'Deskripsi layanan wajib diisi.'); 
        hasError = true; 
    }
    
    if (!form.link_url) { 
        form.setError('link_url', 'Tautan URL wajib diisi.'); 
        hasError = true; 
    } else {
        const urlRegex = /^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/;
        if (!urlRegex.test(form.link_url)) {
            form.setError('link_url', 'Format tautan tidak valid (harus lengkap dengan .com, .id, dll dan diawali http:// atau https://).');
            hasError = true;
        }
    }

    if (!form.sort_order || form.sort_order < 1) { 
        form.setError('sort_order', 'Urutan tampil wajib diisi angka minimal 1.'); 
        hasError = true; 
    }

    if (hasError) return;
    
    form.post(route('admin.internal-services.update', props.service.id));
};
</script>

<template>
  <div>
    <Head :title="'Edit Layanan: ' + service.name" />
    <div class="mb-8">
        <Link :href="route('admin.internal-services.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
            <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
        </Link>
        <h1 class="text-3xl font-bold text-gray-900">Edit Layanan Internal</h1>
        <p class="mt-1 text-gray-600">Perbarui informasi dan tautan portal layanan internal fakultas.</p>
    </div>

    <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
      <form @submit.prevent="submit" novalidate>
        <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
          
            <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Layanan <span class="text-red-600">*</span></label>
            <div>
                <input v-model="form.name" type="text" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                    required>
                <InputError :message="form.errors.name" />
            </div>

            <label class="md:pt-3 text-sm font-bold text-gray-800">Deskripsi Singkat <span class="text-red-600">*</span></label>
            <div>
                <textarea v-model="form.description" rows="3" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.description ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                    required></textarea>
                <InputError :message="form.errors.description" />
            </div>

            <label class="md:pt-3 text-sm font-bold text-gray-800">Tautan Akses (URL) <span class="text-red-600">*</span></label>
            <div>
                <input v-model="form.link_url" type="url" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.link_url ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                    required>
                <InputError :message="form.errors.link_url" />
                <p class="mt-1.5 text-xs text-gray-500 font-medium">Tautan harus lengkap dan tidak boleh sama dengan layanan lain yang sudah ada.</p>
            </div>

            <label class="md:pt-3 text-sm font-bold text-gray-800">Pengaturan Tampilan <span class="text-red-600">*</span></label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Urutan Tampil</label>
                    <input v-model="form.sort_order" type="number" min="1"
                        class="block w-full rounded-lg transition-colors py-3"
                        :class="form.errors.sort_order ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                        required>
                    <InputError :message="form.errors.sort_order" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Status Visibilitas</label>
                    <label class="relative inline-flex items-center cursor-pointer mt-2">
                        <input type="checkbox" v-model="form.is_active" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        <span class="ml-3 text-sm font-bold text-gray-700">{{ form.is_active ? 'Aktif (Ditampilkan)' : 'Nonaktif (Disembunyikan)' }}</span>
                    </label>
                </div>
            </div>

        </div>

        <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
            <Link :href="route('admin.internal-services.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                <PencilSquareIcon class="h-5 w-5 stroke-2" />
                {{ form.processing ? 'Menyimpan...' : 'Perbarui Data' }}
            </button>
        </div>
      </form>
    </div>
  </div>
</template>