<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { useForm, Head, Link, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    ArrowLeftIcon, 
    CheckIcon, 
    IdentificationIcon, 
    InformationCircleIcon, 
    PhotoIcon, 
    DocumentTextIcon, 
    CheckCircleIcon,
    ExclamationTriangleIcon,
    GlobeAltIcon
} from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    profile: {
        id?: number | null;
        description: string | null;
        service_declaration_image_path: string | null;
        external_website_url: string | null;
    } | null
}>();

interface ProfileFormData {
    description: string;
    service_declaration_image: File | null;
    external_website_url: string;
}

const form = useForm<ProfileFormData>({
    description: props.profile?.description || '',
    service_declaration_image: null,
    external_website_url: props.profile?.external_website_url || '',
});

const fileNameDisplay = computed(() => {
    if (form.service_declaration_image instanceof File) {
        return form.service_declaration_image.name;
    }
    return 'Pilih gambar Maklumat (Opsional, Maks. 5 MB)';
});

const handleMaklumatUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.service_declaration_image = target.files?.[0] || null;
};

const submit = () => {
    if (form.external_website_url) {
        form.external_website_url = form.external_website_url.trim();
    }

    form.post(route('admin.zi.profile.update'), {
        preserveScroll: true,
        forceFormData: true,
    });
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => { showNotification.value = false; }, 3000);
    }
}, { immediate: true });
</script>

<template>
    <div>
        <Head title="Kelola Halaman ZI" />
        
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <Link :href="route('admin.dashboard')" class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-gray-200 hover:bg-gray-50 transition-colors flex-shrink-0">
                    <ArrowLeftIcon class="h-5 w-5 text-gray-600 stroke-2" />
                </Link>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kelola Halaman ZI</h1>
                    <p class="mt-1 text-sm text-gray-600">Perbarui konten visual dan narasi pada halaman utama Zona Integritas FSTI ITK.</p>
                </div>
            </div>
        </div>

        <div class="mb-6 bg-blue-50 border-l-4 border-primary p-5 rounded-r-xl shadow-sm flex items-start">
            <InformationCircleIcon class="h-6 w-6 text-primary mt-0.5 mr-3 flex-shrink-0" />
            <div class="text-sm text-blue-900 leading-relaxed">
                <p class="font-bold mb-1">Pusat Pembaruan Data (Satu Pintu)</p>
                <p>Data yang Anda simpan di bawah ini akan <strong>langsung menimpa dan menggantikan</strong> tampilan di halaman publik web FSTI. Pastikan resolusi dan ukuran gambar sesuai dengan ketentuan agar website tetap cepat diakses.</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-xl border-t-4 border-primary overflow-hidden w-full">
            <div class="bg-gray-50/50 px-6 sm:px-8 py-5 border-b border-gray-200 flex items-center">
                <IdentificationIcon class="w-6 h-6 text-primary mr-2" />
                <h3 class="text-lg font-bold text-gray-800">Formulir Pembaruan Konten</h3>
            </div>
            
            <form @submit.prevent="submit" novalidate class="p-6 sm:p-8 space-y-10">
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8">
                    <div class="md:col-span-4">
                        <label class="text-base font-bold text-gray-900 mb-1 flex items-center">
                            <DocumentTextIcon class="w-5 h-5 mr-2 text-gray-500" />
                            1. Teks Pengantar
                        </label>
                        <p class="text-sm text-gray-500 mb-4 leading-relaxed">Tuliskan narasi komitmen ZI institusi Anda.</p>
                    </div>
                    <div class="md:col-span-8">
                        <textarea 
                            v-model="form.description" 
                            rows="8" 
                            placeholder="Contoh: Fakultas Sains dan Teknologi Informasi (FSTI) ITK senantiasa berkomitmen penuh dalam mewujudkan Wilayah Bebas dari Korupsi (WBK)..." 
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white text-sm leading-relaxed transition-colors py-3"
                        ></textarea>
                        <p class="text-[11px] text-gray-500 mt-2 font-medium">Teks akan otomatis menyesuaikan paragraf (enter) saat ditampilkan di halaman publik.</p>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>
                </div>

                <hr class="border-gray-100">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8">
                    <div class="md:col-span-4">
                        <label class="text-base font-bold text-gray-900 mb-1 flex items-center">
                            <PhotoIcon class="w-5 h-5 mr-2 text-gray-500" />
                            2. Maklumat Pelayanan
                        </label>
                        <p class="text-sm text-gray-500 mb-4 leading-relaxed">Poster atau piagam resmi Maklumat Pelayanan yang telah disahkan.</p>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-[11px] text-gray-600 space-y-2">
                            <p class="font-bold text-gray-800 text-xs">Aturan File:</p>
                            <p class="font-medium">• Format: JPG, PNG, WEBP</p>
                            <p class="font-medium">• Maksimal Ukuran: 5 MB</p>
                        </div>
                    </div>
                    <div class="md:col-span-8">
                        <div class="p-5 sm:p-6 border border-gray-200 rounded-xl bg-gray-50/50">
                            <div v-if="props.profile?.service_declaration_image_path" class="mb-5">
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 text-[10px] font-bold px-3 py-1.5 rounded-full mb-3 border border-green-200">
                                    <CheckCircleIcon class="w-4 h-4 stroke-2" /> Dokumen Saat Ini Terpasang
                                </span>
                                <div class="bg-white p-3 border border-gray-200 rounded-xl inline-block shadow-sm w-full sm:w-auto">
                                    <img :src="props.profile.service_declaration_image_path" alt="Maklumat Pelayanan" class="h-auto sm:h-64 w-full sm:w-auto object-contain rounded-lg">
                                </div>
                            </div>
                            <div v-else class="mb-5 text-sm text-gray-600 font-medium bg-white p-4 rounded-xl border border-gray-200 flex items-center gap-3 shadow-sm">
                                <ExclamationTriangleIcon class="h-6 w-6 text-gray-400 flex-shrink-0" />
                                Belum ada Maklumat Pelayanan yang diunggah.
                            </div>

                            <label class="block text-sm font-bold text-gray-800 mb-3">Ganti / Unggah Maklumat Baru:</label>
                            <div class="relative flex items-center w-full rounded-lg border border-gray-300 bg-white hover:bg-gray-50 focus-within:bg-white focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-colors shadow-sm px-4 py-3 cursor-pointer">
                                <PhotoIcon class="h-5 w-5 text-gray-400 flex-shrink-0" />
                                <span class="ml-3 text-sm truncate" :class="{'text-gray-400': !form.service_declaration_image, 'text-gray-900 font-medium': form.service_declaration_image}">
                                    {{ fileNameDisplay }}
                                </span>
                                <input
                                    type="file"
                                    accept="image/png, image/jpeg, image/webp"
                                    @change="handleMaklumatUpload"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                />
                            </div>
                            <InputError :message="form.errors.service_declaration_image" class="mt-3" />
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8">
                    <div class="md:col-span-4">
                        <label class="text-base font-bold text-gray-900 mb-1 flex items-center">
                            <GlobeAltIcon class="w-5 h-5 mr-2 text-gray-500" />
                            3. Tautan Website ZI
                        </label>
                        <p class="text-sm text-gray-500 mb-4 leading-relaxed">Tautan ke portal Zona Integritas terpisah (opsional).</p>
                    </div>
                    <div class="md:col-span-8">
                        <input 
                            type="text" 
                            v-model="form.external_website_url" 
                            placeholder="Contoh: https://zi-fsti.itk.ac.id" 
                            class="w-full rounded-xl transition-all duration-200 py-3"
                            :class="form.errors.external_website_url ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 shadow-sm focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                        />
                        <p class="text-[11px] text-gray-500 mt-2 font-medium">Gunakan URL lengkap dengan awalan http:// atau https://</p>
                        <InputError :message="form.errors.external_website_url" class="mt-2" />
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-200 flex items-center justify-end">
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <CheckIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Pembaruan Halaman' }}
                    </button>
                </div>
            </form>
        </div>
        
        <div v-if="showNotification" class="fixed top-5 right-5 sm:top-8 sm:right-8 z-50">
            <div class="flex items-center gap-3 rounded-xl bg-green-600 px-5 py-4 text-white shadow-xl">
                <CheckCircleIcon class="h-6 w-6" />
                <p class="font-bold text-sm tracking-wide">{{ notificationMessage }}</p>
            </div>
        </div>

    </div>
</template>