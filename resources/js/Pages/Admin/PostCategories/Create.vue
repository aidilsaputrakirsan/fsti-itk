<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, CheckIcon, XMarkIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('admin.post-categories.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Kategori Berita" />
        
        <div class="mb-8 flex items-center gap-4">
            <Link :href="route('admin.post-categories.index')" class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-gray-200 hover:bg-gray-50 transition-colors">
                <ArrowLeftIcon class="h-5 w-5 text-gray-600" />
            </Link>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Kategori Berita</h1>
                <p class="mt-1 text-sm text-gray-600">Lengkapi formulir di bawah ini untuk menambahkan kategori berita baru.</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden w-full">
            <div class="bg-gray-50/50 px-8 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Kategori</h3>
            </div>
            
            <form @submit.prevent="submit" class="p-8 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input 
                        id="name"
                        v-model="form.name" 
                        type="text" 
                        placeholder="Contoh: Pengabdian Masyarakat" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] text-sm" 
                        required
                    />
                    <p class="text-xs text-gray-500 mt-2">Kategori ini nantinya akan muncul sebagai pilihan saat Admin menulis berita.</p>
                    <p v-if="form.errors.name" class="text-xs text-red-500 mt-1">{{ form.errors.name }}</p>
                </div>

                <div class="pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
                    <Link :href="route('admin.post-categories.index')" class="inline-flex items-center gap-2 rounded-lg bg-white border border-gray-300 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        <XMarkIcon class="w-4 h-4" />
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#133E87] shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <CheckIcon class="w-4 h-4" v-if="!form.processing" />
                        <svg v-else class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Kategori' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>