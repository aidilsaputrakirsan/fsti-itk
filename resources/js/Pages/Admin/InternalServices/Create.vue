<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const form = useForm({
    name: '',
    description: '',
    link_url: '',
    category: '',
    sort_order: 0,
    is_active: true,
});

const submit = () => {
    form.post(route('admin.internal-services.store'));
};
</script>

<template>
    <div>
        <div class="mb-8">
            <Link :href="route('admin.internal-services.index')" class="inline-flex items-center gap-2 text-[#4682A9] hover:opacity-80 mb-4">
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-black">Tambah Layanan Internal</h1>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Nama Layanan *</label>
                    <input v-model="form.name" type="text" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">URL Link *</label>
                    <input v-model="form.link_url" type="url" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="https://..." />
                    <p v-if="form.errors.link_url" class="mt-1 text-sm text-red-600">{{ form.errors.link_url }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Deskripsi</label>
                    <textarea v-model="form.description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">Kategori</label>
                        <input v-model="form.category" type="text" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Akademik" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">Urutan Tampilan</label>
                        <input v-model.number="form.sort_order" type="number" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                </div>
                <div class="flex items-center">
                    <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    <label for="is_active" class="ml-2 text-sm font-medium text-black">Aktifkan layanan</label>
                </div>
                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <Link :href="route('admin.internal-services.index')" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
