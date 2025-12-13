<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    page: {
        id: number;
        key: string;
        title: string;
        content: any;
        image_path: string | null;
    };
}>();

// Initialize form based on key
const form = useForm({
    _method: 'PUT',
    content: props.page.key === 'misi' && Array.isArray(props.page.content) 
        ? props.page.content 
        : (props.page.key === 'misi' ? [] : props.page.content), // If misi empty, empty array
    image: null as File | null,
});

const submit = () => {
    form.post(route('admin.static-pages.update', props.page.id), {
        forceFormData: props.page.key === 'bagan-organisasi',
    });
};

// Helper for Misi Repeater
const addMisi = () => {
    if (Array.isArray(form.content)) {
        form.content.push({ title: '', description: '' });
    }
};

const removeMisi = (index: number) => {
    if (Array.isArray(form.content)) {
        form.content.splice(index, 1);
    }
};

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
    }
};
</script>

<template>
    <div>
        <div class="mb-8">
            <Link :href="route('admin.static-pages.index')" class="inline-flex items-center gap-2 text-[#4682A9] hover:opacity-80 mb-4">
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-black">Edit {{ page.title }}</h1>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg max-w-4xl">
            <form @submit.prevent="submit" class="space-y-6">
                
                <!-- CASE 1: VISI (Simple Text) -->
                <div v-if="page.key === 'visi'">
                    <label class="block text-sm font-semibold text-black mb-2">Konten Visi *</label>
                    <textarea 
                        v-model="form.content" 
                        rows="6"
                        required 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Masukkan teks visi..."
                    ></textarea>
                </div>

                <!-- CASE 2: MISI (Repeater) -->
                <div v-if="page.key === 'misi'">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-sm font-semibold text-black">Daftar Misi</label>
                        <button type="button" @click="addMisi" class="text-sm flex items-center gap-1 text-blue-600 hover:underline">
                            <PlusIcon class="w-4 h-4" /> Tambah Poin
                        </button>
                    </div>

                    <div v-for="(item, index) in form.content" :key="index" class="bg-gray-50 p-4 rounded-lg mb-4 border border-gray-200">
                        <div class="flex justify-between mb-2">
                            <span class="text-xs font-bold text-gray-500 uppercase">Poin Misi {{ index + 1 }}</span>
                            <button type="button" @click="removeMisi(index)" class="text-red-500 hover:text-red-700">
                                <TrashIcon class="w-4 h-4" />
                            </button>
                        </div>
                        <div class="mb-3">
                            <input 
                                v-model="item.title" 
                                type="text" 
                                placeholder="Judul Misi (cth: Pendidikan Berkualitas)"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm font-bold"
                            />
                        </div>
                        <div>
                            <textarea 
                                v-model="item.description" 
                                rows="3"
                                placeholder="Deskripsi Misi..."
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm"
                            ></textarea>
                        </div>
                    </div>
                    <div v-if="form.content.length === 0" class="text-center py-8 text-gray-500 italic border-2 border-dashed border-gray-300 rounded-lg">
                        Belum ada poin misi. Klik "Tambah Poin" untuk memulai.
                    </div>
                </div>

                <!-- CASE 3: BAGAN ORGANISASI (Image) -->
                <div v-if="page.key === 'bagan-organisasi'">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-black mb-2">Upload Gambar Bagan Baru</label>
                        <input 
                            type="file" 
                            @change="handleImageUpload"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        />
                         <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    </div>
                    
                    <div v-if="page.image_path && !form.image" class="mt-4">
                        <p class="text-sm font-semibold mb-2">Gambar Saat Ini:</p>
                        <img :src="page.image_path" class="max-w-full h-auto rounded border shadow-sm" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <Link :href="route('admin.static-pages.index')" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">
                        Batal
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-6 py-2 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
