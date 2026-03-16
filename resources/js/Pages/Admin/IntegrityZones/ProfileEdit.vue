<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, CheckIcon, IdentificationIcon, InformationCircleIcon, PhotoIcon, DocumentTextIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    profile: {
        id: number;
        description: string | null;
        service_declaration_image_path: string | null;
    }
}>();

const form = useForm({
    description: props.profile.description || '',
    service_declaration_image: null as File | null,
});

// Helper untuk TypeScript File Upload
const handleMaklumatUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.service_declaration_image = target.files?.[0] || null;
};

const submit = () => {
    form.post(route('admin.zi.profile.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Kelola Halaman ZI" />
    
    <div>
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <Link href="/admin/dashboard" class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-gray-200 hover:bg-gray-50 transition-colors">
                    <ArrowLeftIcon class="h-5 w-5 text-gray-600" />
                </Link>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kelola Halaman ZI</h1>
                    <p class="mt-1 text-sm text-gray-600">Perbarui konten visual dan narasi pada halaman utama Zona Integritas FSTI.</p>
                </div>
            </div>
        </div>

        <div class="mb-6 bg-blue-50 border-l-4 border-[#4682A9] p-4 rounded-r-lg shadow-sm flex items-start">
            <InformationCircleIcon class="h-6 w-6 text-[#4682A9] mt-0.5 mr-3 flex-shrink-0" />
            <div class="text-sm text-blue-900 leading-relaxed">
                <p class="font-bold mb-1">Pusat Pembaruan Data (Satu Pintu)</p>
                <p>Data yang Anda simpan di bawah ini akan <strong>langsung menimpa dan menggantikan</strong> tampilan di halaman publik web FSTI. Pastikan resolusi dan ukuran gambar sesuai dengan ketentuan agar website tetap cepat diakses.</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden w-full">
            <div class="bg-gray-50/50 px-8 py-5 border-b border-gray-200 flex items-center">
                <IdentificationIcon class="w-5 h-5 text-[#4682A9] mr-2" />
                <h3 class="text-lg font-semibold text-gray-800">Formulir Pembaruan Konten</h3>
            </div>
            
            <form @submit.prevent="submit" class="p-8 space-y-10">
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8">
                    <div class="md:col-span-4">
                        <label class="block text-base font-bold text-gray-900 mb-1 flex items-center">
                            <DocumentTextIcon class="w-5 h-5 mr-2 text-gray-500" />
                            1. Teks Pengantar & Role Model
                        </label>
                        <p class="text-sm text-gray-500 mb-4 leading-relaxed">Tuliskan narasi komitmen ZI dan perkenalkan nama serta jabatan Role Model FSTI saat ini.</p>
                    </div>
                    <div class="md:col-span-8">
                        <textarea 
                            v-model="form.description" 
                            rows="8" 
                            placeholder="Contoh:&#10;Fakultas Sains dan Teknologi Informasi (FSTI) ITK senantiasa berkomitmen penuh dalam mewujudkan Wilayah Bebas dari Korupsi (WBK)...&#10;&#10;Role Model ZI FSTI Periode 2025-2027:&#10;Adi Mahmud Jaya Marindra, S.T., M.Eng., Ph.D (Dekan FSTI)" 
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] text-sm leading-relaxed"
                        ></textarea>
                        <p class="text-[11px] text-gray-500 mt-2 italic">* Teks akan otomatis menyesuaikan paragraf (enter) saat ditampilkan di halaman publik.</p>
                        <p v-if="form.errors.description" class="text-xs text-red-500 mt-1 font-semibold">{{ form.errors.description }}</p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8">
                    <div class="md:col-span-4">
                        <label class="block text-base font-bold text-gray-900 mb-1 flex items-center">
                            <PhotoIcon class="w-5 h-5 mr-2 text-gray-500" />
                            2. Maklumat Pelayanan
                        </label>
                        <p class="text-sm text-gray-500 mb-4 leading-relaxed">Poster atau piagam resmi Maklumat Pelayanan yang telah disahkan/ditandatangani.</p>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-[11px] text-gray-600 space-y-1.5">
                            <p class="font-bold text-gray-700">Aturan File:</p>
                            <p>• <strong>Format:</strong> JPG, PNG, WEBP</p>
                            <p>• <strong>Maks Ukuran:</strong> 5 MB (Kualitas Jelas)</p>
                            <p>• <strong>Rekomendasi:</strong> Dokumen Portrait (Kertas A4)</p>
                        </div>
                    </div>
                    <div class="md:col-span-8">
                        <div class="p-5 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/30">
                            <div v-if="props.profile.service_declaration_image_path" class="mb-4">
                                <span class="inline-block bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded mb-2">Dokumen Saat Ini Terpasang</span>
                                <div class="bg-white p-2 border border-gray-200 rounded-lg inline-block shadow-sm">
                                    <img :src="props.profile.service_declaration_image_path" alt="Maklumat Pelayanan" class="h-64 w-auto object-contain rounded">
                                </div>
                            </div>
                            <div v-else class="mb-4 text-sm text-amber-600 font-medium bg-amber-50 p-3 rounded-lg border border-amber-200">
                                ⚠️ Belum ada Maklumat Pelayanan yang diunggah.
                            </div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti / Unggah Maklumat Baru:</label>
                            <input type="file" @change="handleMaklumatUpload" accept="image/png, image/jpeg, image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-[#CBDCEB] file:text-[#133E87] hover:file:bg-[#a6c1da] transition cursor-pointer" />
                            <p v-if="form.errors.service_declaration_image" class="text-xs text-red-500 mt-2 font-semibold">{{ form.errors.service_declaration_image }}</p>
                        </div>
                    </div>
                </div>
<div class="pt-8 border-t border-gray-200 flex items-center justify-end">
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 rounded-lg bg-[#4682A9] px-8 py-3 text-sm font-bold text-white hover:bg-[#133E87] shadow-md transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <CheckIcon class="w-5 h-5" v-if="!form.processing" />
                        <svg v-else class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        {{ form.processing ? 'Menyimpan Perubahan...' : 'Simpan Pembaruan Halaman' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>