<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, CheckIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    beasiswa: Object,
});

const form = useForm({
    title: props.beasiswa.title,
    provider: props.beasiswa.provider || '',
    link_url: props.beasiswa.link_url || '',
    description: props.beasiswa.description,
});

const submit = () => {
    form.put(route('admin.beasiswa.update', props.beasiswa.id));
};
</script>

<template>
    <Head title="Edit Beasiswa" />

    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-black">Edit Beasiswa</h1>
            <p class="mt-1 text-black">Perbarui informasi data beasiswa FSTI</p>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-[150px_1fr] gap-x-8 gap-y-8">
                    
                    <label class="pt-2 text-sm font-semibold text-black">Nama Beasiswa *</label>
                    <div>
                        <input v-model="form.title" type="text" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Penyelenggara</label>
                    <div>
                        <input v-model="form.provider" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        <p v-if="form.errors.provider" class="mt-2 text-sm text-red-600">{{ form.errors.provider }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Tautan Pendaftaran</label>
                    <div>
                        <input v-model="form.link_url" type="url" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        <p class="mt-1 text-xs text-gray-500">Opsional. Sertakan URL lengkap (http/https) ke portal pendaftaran.</p>
                        <p v-if="form.errors.link_url" class="mt-2 text-sm text-red-600">{{ form.errors.link_url }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Deskripsi *</label>
                    <div>
                        <textarea v-model="form.description" rows="6" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                        <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
                    </div>

                </div>

                <div class="mt-12 flex items-center justify-between">
                    <Link :href="route('admin.beasiswa.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        <ArrowLeftIcon class="h-5 w-5" /> Kembali
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-primary px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-hover disabled:opacity-50">
                        <CheckIcon class="h-5 w-5" /> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>