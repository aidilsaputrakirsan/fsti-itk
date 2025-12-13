<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    tracer: {
        id: number;
        title: string;
        type: 'Survey Link' | 'Report';
        url: string | null;
        file_path: string | null;
        year: number;
        description: string | null;
        is_active: boolean;
    };
}>();

const form = useForm({
    title: props.tracer.title,
    type: props.tracer.type,
    url: props.tracer.url || '',
    file: null as File | null,
    year: props.tracer.year,
    description: props.tracer.description || '',
    is_active: props.tracer.is_active,
});

const submit = () => {
    form.put(route('admin.alumni.update', props.tracer.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <div>
        <div class="mb-8">
            <Link :href="route('admin.alumni.index')" class="inline-flex items-center gap-2 text-[#4682A9] hover:opacity-80 mb-4">
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-black">Edit Data Tracer</h1>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Judul *</label>
                    <input v-model="form.title" type="text" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Tipe *</label>
                    <select v-model="form.type" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="Survey Link">Survey Link</option>
                        <option value="Report">Report</option>
                    </select>
                </div>
                <div v-if="form.type === 'Survey Link'">
                    <label class="block text-sm font-semibold text-black mb-2">URL Link Survei *</label>
                    <input v-model="form.url" type="url" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div v-if="form.type === 'Report'">
                    <label class="block text-sm font-semibold text-black mb-2">Upload File Baru (PDF)</label>
                    <p v-if="tracer.file_path" class="text-sm text-gray-600 mb-2">
                        File saat ini: <span class="font-medium">{{ tracer.file_path.split('/').pop() }}</span>
                    </p>
                    <input @input="form.file = ($event.target as HTMLInputElement).files![0]" type="file" accept=".pdf" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah file. Maksimal 10MB</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Tahun *</label>
                    <input v-model.number="form.year" type="number" required min="2000" :max="new Date().getFullYear() + 1" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Deskripsi</label>
                    <textarea v-model="form.description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-center">
                    <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    <label for="is_active" class="ml-2 text-sm font-medium text-black">Aktifkan</label>
                </div>
                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <Link :href="route('admin.alumni.index')" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">Batal</Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50">
                        {{ form.processing ? 'Menyimpan...' : 'Perbarui' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
