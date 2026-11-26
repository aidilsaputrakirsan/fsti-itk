<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { PaperAirplaneIcon, PaperClipIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

export interface InternshipPartnerFormData {
    name: string;
    business_field: string;
    location: string;
    type: string;
    study_program_ids: number[];
    website: string;
    is_active: boolean;
    logo: File | null;
    remove_logo?: boolean;
    _method?: string;
}

const props = defineProps<{
    form: any;
    studyPrograms: { id: number; name: string; degree: string }[];
    types: Record<string, string>;
    businessFieldSuggestions: string[];
    locationSuggestions: string[];
    currentLogoUrl?: string | null;
    submitLabel?: string;
}>();

const emit = defineEmits<{ (e: 'submit'): void }>();

const fileInput = ref<HTMLInputElement | null>(null);
const previewUrl = ref<string | null>(null);

const shownLogo = computed(() => {
    if (previewUrl.value) return previewUrl.value;
    if (props.form.remove_logo) return null;
    return props.currentLogoUrl ?? null;
});

const inputClass = (field: string) => [
    'block w-full rounded-lg transition-colors py-3',
    props.form.errors[field]
        ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900'
        : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white',
];

const handleLogoChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0] ?? null;
    props.form.logo = file;
    props.form.remove_logo = false;
    previewUrl.value = file ? URL.createObjectURL(file) : null;
};

const clearLogo = () => {
    props.form.logo = null;
    previewUrl.value = null;
    if (fileInput.value) fileInput.value.value = '';
};

const removeExistingLogo = () => {
    clearLogo();
    props.form.remove_logo = true;
};

const toggleProdi = (id: number) => {
    const ids: number[] = props.form.study_program_ids;
    props.form.study_program_ids = ids.includes(id) ? ids.filter((x) => x !== id) : [...ids, id];
};

const submit = () => {
    props.form.clearErrors();
    const required: [string, string][] = [
        ['name', 'Nama mitra wajib diisi.'],
        ['business_field', 'Bidang usaha wajib diisi.'],
        ['location', 'Lokasi wajib diisi.'],
    ];
    let hasError = false;
    for (const [field, message] of required) {
        if (!String(props.form[field] ?? '').trim()) {
            props.form.setError(field, message);
            hasError = true;
        }
    }
    if (props.form.website && !/^https?:\/\/[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,}/.test(props.form.website)) {
        props.form.setError('website', 'Website harus diawali http:// atau https:// beserta domain (cth: .com, .co.id).');
        hasError = true;
    }
    const logo: File | null = props.form.logo;
    if (logo) {
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(logo.type)) {
            props.form.setError('logo', 'Format file harus JPG, PNG, atau WEBP.');
            hasError = true;
        } else if (logo.size > 2 * 1024 * 1024) {
            props.form.setError('logo', 'Ukuran file gambar maksimal 2MB.');
            hasError = true;
        }
    }
    if (!hasError) emit('submit');
};
</script>

<template>
    <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
        <form @submit.prevent="submit" novalidate>
            <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">

                <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Mitra <span class="text-red-600">*</span></label>
                <div>
                    <input v-model="form.name" type="text" placeholder="Contoh: PT Pertamina Hulu Indonesia" :class="inputClass('name')">
                    <InputError :message="form.errors.name" />
                </div>

                <label class="md:pt-3 text-sm font-bold text-gray-800">Bidang Usaha <span class="text-red-600">*</span></label>
                <div>
                    <input v-model="form.business_field" type="text" list="business-field-suggestions" placeholder="Contoh: Minyak & Gas, Teknologi Informasi, Perbankan" :class="inputClass('business_field')">
                    <datalist id="business-field-suggestions">
                        <option v-for="item in businessFieldSuggestions" :key="item" :value="item" />
                    </datalist>
                    <p class="mt-2 text-[11px] text-gray-500 font-medium">Pilih dari saran yang muncul bila sudah ada, supaya filter di halaman publik rapi.</p>
                    <InputError :message="form.errors.business_field" />
                </div>

                <label class="md:pt-3 text-sm font-bold text-gray-800">Lokasi <span class="text-red-600">*</span></label>
                <div>
                    <input v-model="form.location" type="text" list="location-suggestions" placeholder="Contoh: Balikpapan, Kalimantan Timur" :class="inputClass('location')">
                    <datalist id="location-suggestions">
                        <option v-for="item in locationSuggestions" :key="item" :value="item" />
                    </datalist>
                    <InputError :message="form.errors.location" />
                </div>

                <label class="md:pt-3 text-sm font-bold text-gray-800">Jenis <span class="text-red-600">*</span></label>
                <div>
                    <div class="flex flex-wrap gap-3">
                        <label v-for="(label, value) in types" :key="value"
                            class="flex items-center gap-2 cursor-pointer rounded-lg border px-4 py-2.5 text-sm font-semibold transition-colors"
                            :class="form.type === value ? 'border-primary bg-primary/5 text-primary' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                            <input v-model="form.type" type="radio" :value="value" class="text-primary focus:ring-primary">
                            {{ label }}
                        </label>
                    </div>
                    <InputError :message="form.errors.type" />
                </div>

                <label class="md:pt-1 text-sm font-bold text-gray-800">Prodi yang Pernah KP/Magang</label>
                <div>
                    <div class="flex flex-wrap gap-2">
                        <button v-for="prodi in studyPrograms" :key="prodi.id" type="button" @click="toggleProdi(prodi.id)"
                            class="rounded-full border px-3.5 py-1.5 text-xs font-semibold transition-colors"
                            :class="form.study_program_ids.includes(prodi.id) ? 'bg-primary border-primary text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-primary hover:text-primary'">
                            {{ prodi.degree }} {{ prodi.name }}
                        </button>
                    </div>
                    <p class="mt-2 text-[11px] text-gray-500 font-medium">Opsional. Dipakai mahasiswa untuk memfilter mitra sesuai prodinya.</p>
                    <InputError :message="form.errors.study_program_ids" />
                </div>

                <label class="md:pt-3 text-sm font-bold text-gray-800">Website</label>
                <div>
                    <input v-model="form.website" type="url" placeholder="Contoh: https://www.perusahaan.co.id" :class="inputClass('website')">
                    <p class="mt-2 text-[11px] text-gray-500 font-medium">Opsional.</p>
                    <InputError :message="form.errors.website" />
                </div>

                <label class="md:pt-3 text-sm font-bold text-gray-800">Logo</label>
                <div>
                    <p class="text-xs text-gray-500 mb-3 font-medium">Opsional. JPG, PNG, atau WEBP, maksimal 2MB.</p>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div v-if="shownLogo" class="shrink-0 flex flex-col items-center gap-1">
                            <div class="h-20 w-20 rounded-lg border border-gray-200 bg-white p-2 flex items-center justify-center">
                                <img :src="shownLogo" alt="Logo mitra" class="max-h-full max-w-full object-contain">
                            </div>
                            <button v-if="!previewUrl && currentLogoUrl" type="button" @click="removeExistingLogo" class="text-[11px] font-semibold text-red-600 hover:underline">Hapus logo</button>
                        </div>
                        <div class="relative flex items-center w-full rounded-lg border bg-white shadow-sm px-4 py-2.5 hover:bg-gray-50 transition" :class="form.errors.logo ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                            <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-gray-400" />
                            <span class="ml-3 text-sm truncate flex-1 font-medium text-gray-500">
                                {{ form.logo ? form.logo.name : 'Pilih file dari perangkat...' }}
                            </span>
                            <button v-if="form.logo" type="button" @click.prevent="clearLogo" class="ml-2 p-1 text-red-500 hover:bg-red-50 rounded-md relative z-10 flex-shrink-0" title="Batal pilih file">
                                <XMarkIcon class="h-4 w-4" />
                            </button>
                            <input ref="fileInput" type="file" accept="image/png, image/jpeg, image/webp" @change="handleLogoChange" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :class="{ hidden: form.logo }">
                        </div>
                    </div>
                    <InputError :message="form.errors.logo" />
                </div>

                <label class="md:pt-1 text-sm font-bold text-gray-800">Status</label>
                <div>
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input v-model="form.is_active" type="checkbox" class="rounded text-primary focus:ring-primary h-5 w-5">
                        <span class="text-sm font-semibold text-gray-700">Tampilkan di halaman publik</span>
                    </label>
                </div>
            </div>

            <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                <Link :href="route('admin.internship-partners.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                    Batal
                </Link>
                <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                    <PaperAirplaneIcon class="h-5 w-5 stroke-2" />
                    {{ form.processing ? 'Menyimpan...' : (submitLabel ?? 'Simpan Data') }}
                </button>
            </div>
        </form>
    </div>
</template>
