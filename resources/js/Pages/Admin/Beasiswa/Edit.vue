<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    beasiswa?: any;
    data?: any;
}>();

const dataBeasiswa = props.beasiswa || props.data || {};

interface BeasiswaFormData {
    _method: string;
    title: string;
    provider: string;
    link_url: string;
    description: string;
}

const form = useForm<BeasiswaFormData>({
    _method: 'PUT',
    title: dataBeasiswa.title || '',
    provider: dataBeasiswa.provider || '',
    link_url: dataBeasiswa.link_url || '',
    description: dataBeasiswa.description || '',
});

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.title) {
        form.setError('title', 'Nama beasiswa wajib diisi.');
        hasError = true;
    }

    if (!form.description) {
        form.setError('description', 'Deskripsi beasiswa wajib diisi.');
        hasError = true;
    }

    if (form.link_url) {
        const urlPattern = /^https?:\/\/.+/;
        if (!urlPattern.test(form.link_url)) {
            form.setError('link_url', 'Tautan harus diawali dengan http:// atau https://');
            hasError = true;
        }
    }

    if (hasError) return;

    const targetUrl: string = (route as Function)('admin.beasiswa.update', dataBeasiswa.id);
    form.post(targetUrl);
};
</script>

<template>
    <div>
        <Head :title="'Edit Beasiswa: ' + (dataBeasiswa.title || '')" />

        <div class="mb-8">
            <Link :href="(route as Function)('admin.beasiswa.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Edit Beasiswa</h1>
            <p class="mt-1 text-gray-600">Perbarui informasi data beasiswa dan bantuan pendidikan FSTI.</p>
        </div>

        <div v-if="dataBeasiswa.id" class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Beasiswa <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.title" type="text" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.title ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.title" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Penyelenggara</label>
                    <div>
                        <input v-model="form.provider" type="text" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.provider ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                        <InputError :message="form.errors.provider" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Tautan Pendaftaran</label>
                    <div>
                        <input v-model="form.link_url" type="url" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.link_url ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                        <p class="mt-2 text-[11px] text-gray-500 font-medium">Opsional. Sertakan URL lengkap (http/https) ke portal pendaftaran.</p>
                        <InputError :message="form.errors.link_url" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Deskripsi Singkat <span class="text-red-600">*</span></label>
                    <div>
                        <textarea v-model="form.description" rows="6" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.description ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required></textarea>
                        <InputError :message="form.errors.description" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="(route as Function)('admin.beasiswa.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
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