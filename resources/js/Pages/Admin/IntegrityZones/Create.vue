<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const form = useForm({
    title: '',
    category: 'Kebijakan ZI',
    content: '',
    document: null as File | null,
    image: null as File | null,
    published_at: new Date().toISOString().split('T')[0],
});

const submit = () => {
    form.post(route('admin.integrity-zones.store'), {
        forceFormData: true,
    });
};

const categories = ['Kebijakan ZI', 'Berita ZI', 'Pengumuman', 'Sosialisasi'];
</script>

<template>
    <div>
        <div class="mb-8">
            <Link :href="route('admin.integrity-zones.index')" class="inline-flex items-center gap-2 text-[#4682A9] hover:opacity-80 mb-4">
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-black">Tambah Zona Integritas</h1>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Judul *</label>
                    <input v-model="form.title" type="text" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Kategori *</label>
                    <select v-model="form.category" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                    </select>
                    <p v-if="form.errors.category" class="mt-1 text-sm text-red-600">{{ form.errors.category }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Konten *</label>
                    <textarea v-model="form.content" rows="8" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                    <p v-if="form.errors.content" class="mt-1 text-sm text-red-600">{{ form.errors.content }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Upload Dokumen (PDF/DOC)</label>
                    <input @input="form.document = ($event.target as HTMLInputElement).files![0]" type="file" accept=".pdf,.doc,.docx" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    <p class="mt-1 text-sm text-gray-500">Maksimal 10MB</p>
                    <p v-if="form.errors.document" class="mt-1 text-sm text-red-600">{{ form.errors.document }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Upload Gambar</label>
                    <input @input="form.image = ($event.target as HTMLInputElement).files![0]" type="file" accept="image/*" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    <p class="mt-1 text-sm text-gray-500">Maksimal 5MB</p>
                    <p v-if="form.errors.image" class="mt-1 text-sm text-red-600">{{ form.errors.image }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Tanggal Publish *</label>
                    <input v-model="form.published_at" type="date" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="form.errors.published_at" class="mt-1 text-sm text-red-600">{{ form.errors.published_at }}</p>
                </div>
                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <Link :href="route('admin.integrity-zones.index')" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
