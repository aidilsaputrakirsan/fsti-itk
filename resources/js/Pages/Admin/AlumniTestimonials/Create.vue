<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    studyPrograms: string[];
}>();

interface TestimonialFormData {
    name: string;
    job: string;
    study_program: string;
    graduation_year: number | string;
    message: string;
    is_active: boolean;
    photo: File | null;
}

const form = useForm<TestimonialFormData>({
    name: '',
    job: '',
    study_program: '',
    graduation_year: new Date().getFullYear(),
    message: '',
    is_active: true,
    photo: null,
});

const handlePhotoUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.photo = target.files?.[0] || null;
};

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) { form.setError('name', 'Nama lengkap wajib diisi.'); hasError = true; }
    if (!form.study_program) { form.setError('study_program', 'Program studi wajib dipilih.'); hasError = true; }
    if (!form.graduation_year) { form.setError('graduation_year', 'Tahun lulus wajib diisi.'); hasError = true; }
    if (!form.message) { form.setError('message', 'Pesan / Kesan wajib diisi.'); hasError = true; }
    
    if (!form.photo) { form.setError('photo', 'Foto profil wajib diunggah.'); hasError = true; }

    if (hasError) return;

    form.post(route('admin.alumni-testimonials.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Testimoni" />

        <div class="mb-8">
            <Link :href="route('admin.alumni-testimonials.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Testimoni</h1>
            <p class="mt-1 text-gray-600">Masukkan data pengalaman dan kesan kelulusan alumni FSTI ITK.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Lengkap <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.name" type="text" placeholder="Masukkan nama lengkap alumni" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.name ? 'border-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.name" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Pekerjaan/Jabatan Saat Ini</label>
                    <div>
                        <input v-model="form.job" type="text" placeholder="Contoh: Dosen Sistem Informasi ITK" 
                            class="block w-full rounded-lg border-gray-300 py-3 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary">
                        <p class="mt-1 text-xs text-gray-500">Boleh dikosongkan. Sistem akan menampilkan 'Alumni' jika kosong.</p>
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Program Studi <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.study_program" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.study_program ? 'border-red-500 bg-red-50' : 'border-gray-300 focus:border-primary bg-gray-50 focus:bg-white'" 
                            required>
                            <option value="" disabled>Pilih Program Studi</option>
                            <option v-for="prodi in studyPrograms" :key="prodi" :value="prodi">{{ prodi }}</option>
                        </select>
                        <InputError :message="form.errors.study_program" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Tahun Kelulusan <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.graduation_year" type="number" min="2000" :max="new Date().getFullYear() + 1" placeholder="Contoh: 2024" 
                            class="block w-full sm:w-1/2 rounded-lg transition-colors py-3"
                            :class="form.errors.graduation_year ? 'border-red-500 bg-red-50' : 'border-gray-300 focus:border-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.graduation_year" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Pesan / Kesan <span class="text-red-600">*</span></label>
                    <div>
                        <textarea v-model="form.message" rows="5" placeholder="Tuliskan pengalaman alumni selama kuliah di FSTI ITK"
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.message ? 'border-red-500 bg-red-50' : 'border-gray-300 focus:border-primary bg-gray-50 focus:bg-white'" 
                            required></textarea>
                        <InputError :message="form.errors.message" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Foto Profile <span class="text-red-600">*</span></label>
                    <div>
                        <input type="file" @change="handlePhotoUpload" accept="image/jpeg, image/png, image/jpg, image/webp" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 border rounded-lg py-2 px-3 transition-colors"
                            :class="form.errors.photo ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50'" required>
                        <p class="mt-1.5 text-xs text-gray-500">Foto wajah alumni wajib diunggah. Format yang didukung: JPG, PNG, WEBP (Maks: 2MB).</p>
                        <InputError :message="form.errors.photo" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Status Visibilitas</label>
                    <div class="flex items-center pt-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" v-model="form.is_active" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-3 text-sm font-medium text-gray-700">Tampilkan Testimoni Ini di Halaman Publik</span>
                        </label>
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.alumni-testimonials.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>