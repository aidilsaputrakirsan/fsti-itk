<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    document: {
        id: number;
        title: string;
        category: string;
        description: string | null;
        file_path: string | null;
        is_active: boolean;
    };
}>();

const form = useForm({
    title: props.document.title,
    category: props.document.category,
    description: props.document.description || '',
    file: null as File | null,
    is_active: props.document.is_active,
});

const submit = () => {
    form.put(route('admin.ppid.update', props.document.id), {
        forceFormData: true,
    });
};

const categories = [
    'Informasi Berkala',
    'Informasi Serta Merta',
    'Informasi Setiap Saat',
    'Informasi Dikecualikan',
    'Regulasi',
    'Formulir'
];
</script>

<template>
    <div>
        <div class="mb-8">
            <Link :href="route('admin.ppid.index')" class="inline-flex items-center gap-2 text-[#4682A9] hover:opacity-80 mb-4">
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-black">Edit Dokumen PPID</h1>
            <p class="mt-1 text-black">Perbarui dokumen PPID</p>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Judul Dokumen *</label>
                    <input 
                        v-model="form.title" 
                        type="text" 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    />
                    <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Kategori *</label>
                    <select 
                        v-model="form.category" 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                    </select>
                    <p v-if="form.errors.category" class="mt-1 text-sm text-red-600">{{ form.errors.category }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Deskripsi</label>
                    <textarea 
                        v-model="form.description" 
                        rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    ></textarea>
                    <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Upload File Baru (PDF/DOC)</label>
                    <p v-if="document.file_path" class="text-sm text-gray-600 mb-2">
                        File saat ini: <span class="font-medium">{{ document.file_path.split('/').pop() }}</span>
                    </p>
                    <input 
                        @input="form.file = ($event.target as HTMLInputElement).files![0]" 
                        type="file" 
                        accept=".pdf,.doc,.docx"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    />
                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah file. Maksimal 10MB</p>
                    <p v-if="form.errors.file" class="mt-1 text-sm text-red-600">{{ form.errors.file }}</p>
                </div>

                <div class="flex items-center">
                    <input 
                        v-model="form.is_active" 
                        type="checkbox" 
                        id="is_active"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    />
                    <label for="is_active" class="ml-2 text-sm font-medium text-black">Aktifkan dokumen</label>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <Link :href="route('admin.ppid.index')" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">
                        Batal
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-6 py-2 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Perbarui' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
