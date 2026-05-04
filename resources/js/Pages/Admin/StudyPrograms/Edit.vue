<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    studyProgram: any;
    departments: string[];
}>();

const fileInput = ref<HTMLInputElement | null>(null);

const formatArrayToText = (arr: any): string => {
    if (!arr) return '';
    if (Array.isArray(arr)) return arr.join('\n');
    if (typeof arr === 'string') {
        try {
            const parsed = JSON.parse(arr);
            if (Array.isArray(parsed)) return parsed.join('\n');
        } catch {
            return arr;
        }
        return arr;
    }
    return '';
};

interface StudyProgramForm {
    _method: string;
    name: string;
    department: string;
    degree: string;
    description: string;
    vision: string;
    mission: string;
    goals: string;
    graduate_profiles: string;
    accreditation_text: string;
    accreditation_pdf_link: string;
    website_link: string;
    accreditation_certificate_image: File | null;
}

const form = useForm<StudyProgramForm>({
    _method: 'PUT',
    name: props.studyProgram.name || '',
    department: props.studyProgram.department || '',
    degree: props.studyProgram.degree || 'S1',
    description: props.studyProgram.description || '',
    vision: props.studyProgram.vision || '',
    mission: formatArrayToText(props.studyProgram.mission),
    goals: formatArrayToText(props.studyProgram.goals),
    graduate_profiles: formatArrayToText(props.studyProgram.graduate_profiles),
    accreditation_text: props.studyProgram.accreditation_text || '',
    accreditation_pdf_link: props.studyProgram.accreditation_pdf_link || '',
    website_link: props.studyProgram.website_link || '',
    accreditation_certificate_image: null, 
});

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.accreditation_certificate_image = target.files[0];
    } else {
        form.accreditation_certificate_image = null;
    }
};

const clearImage = () => {
    form.accreditation_certificate_image = null;
    if (fileInput.value) fileInput.value.value = '';
};

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) { form.setError('name', 'Nama Program Studi wajib diisi.'); hasError = true; }
    if (!form.degree) { form.setError('degree', 'Jenjang wajib dipilih.'); hasError = true; }
    if (!form.department) { form.setError('department', 'Jurusan wajib dipilih.'); hasError = true; }
    if (!form.description) { form.setError('description', 'Profil ringkas wajib diisi.'); hasError = true; }
    if (!form.vision) { form.setError('vision', 'Visi prodi wajib diisi.'); hasError = true; }
    if (!form.goals) { form.setError('goals', 'Tujuan prodi wajib diisi.'); hasError = true; }
    if (!form.mission) { form.setError('mission', 'Misi prodi wajib diisi.'); hasError = true; }
    if (!form.graduate_profiles) { form.setError('graduate_profiles', 'Profil lulusan wajib diisi.'); hasError = true; }
    if (!form.accreditation_text) { form.setError('accreditation_text', 'Teks akreditasi wajib diisi.'); hasError = true; }

    const urlPattern = /^https?:\/\/.+/;
    if (!form.website_link) {
        form.setError('website_link', 'Tautan website resmi prodi wajib diisi.'); hasError = true;
    } else if (!urlPattern.test(form.website_link)) {
        form.setError('website_link', 'Tautan harus diawali dengan http:// atau https://'); hasError = true;
    }

    if (form.accreditation_pdf_link && !urlPattern.test(form.accreditation_pdf_link)) {
        form.setError('accreditation_pdf_link', 'Tautan harus diawali dengan http:// atau https://'); hasError = true;
    }

    if (form.accreditation_certificate_image) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(form.accreditation_certificate_image.type)) {
            form.setError('accreditation_certificate_image', 'Format file harus JPG, PNG, atau WEBP.');
            hasError = true;
        } else if (form.accreditation_certificate_image.size > 2 * 1024 * 1024) {
            form.setError('accreditation_certificate_image', 'Ukuran file gambar maksimal 2MB.');
            hasError = true;
        }
    }

    if (hasError) return;
    form.post(route('admin.study-programs.update', props.studyProgram.id));
};
</script>

<template>
  <div>
    <Head :title="'Edit Prodi: ' + studyProgram.name" />
    <div class="mb-8">
        <Link :href="route('admin.study-programs.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
            <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
        </Link>
        <h1 class="text-3xl font-bold text-gray-900">Edit Program Studi</h1>
        <p class="mt-1 text-gray-600">Perbarui informasi detail dan akreditasi program studi.</p>
    </div>

    <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
      <form @submit.prevent="submit" novalidate>
<div class="grid grid-cols-1 lg:grid-cols-[220px_1fr] gap-x-8 gap-y-6 lg:gap-y-8">          
            <label class="lg:pt-3 text-sm font-bold text-gray-800">Nama Program Studi <span class="text-red-600">*</span></label>
            <div>
                <input v-model="form.name" type="text" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                    required>
                <InputError :message="form.errors.name" />
            </div>

            <label class="lg:pt-3 text-sm font-bold text-gray-800">Jenjang & Jurusan <span class="text-red-600">*</span></label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jenjang</label>
                    <select v-model="form.degree" class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white py-3" required>
                        <option value="S1">S1 (Sarjana)</option>
                        <option value="S2">S2 (Magister)</option>
                    </select>
                    <InputError :message="form.errors.degree" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jurusan</label>
                    <select v-model="form.department" class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white py-3" required>
                        <option value="" disabled>Pilih Jurusan</option>
                        <option v-for="dept in departments" :key="dept" :value="dept">{{ dept }}</option>
                    </select>
                    <InputError :message="form.errors.department" />
                </div>
            </div>

            <label class="lg:pt-3 text-sm font-bold text-gray-800">Profil Ringkas <span class="text-red-600">*</span></label>
            <div>
                <textarea v-model="form.description" rows="4" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.description ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                    required></textarea>
                <InputError :message="form.errors.description" />
            </div>

            <label class="lg:pt-3 text-sm font-bold text-gray-800">Visi <span class="text-red-600">*</span></label>
            <div>
                <textarea v-model="form.vision" rows="3" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.vision ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                    required></textarea>
                <InputError :message="form.errors.vision" />
            </div>

            <label class="lg:pt-3 text-sm font-bold text-gray-800">Misi <span class="text-red-600">*</span></label>
            <div>
                <p class="text-xs text-gray-500 mb-2 font-medium">Pisahkan setiap poin dengan menekan tombol <strong>Enter</strong>.</p>
                <textarea v-model="form.mission" rows="6" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.mission ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                    required></textarea>
                <InputError :message="form.errors.mission" />
            </div>

            <label class="lg:pt-3 text-sm font-bold text-gray-800">Tujuan <span class="text-red-600">*</span></label>
            <div>
                <p class="text-xs text-gray-500 mb-2 font-medium">Pisahkan setiap poin dengan menekan tombol <strong>Enter</strong>.</p>
                <textarea v-model="form.goals" rows="5" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.goals ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                    required></textarea>
                <InputError :message="form.errors.goals" />
            </div>

            <label class="lg:pt-3 text-sm font-bold text-gray-800">Profil Lulusan / Karier <span class="text-red-600">*</span></label>
            <div>
                <p class="text-xs text-gray-500 mb-2 font-medium">Pisahkan setiap profesi dengan menekan tombol <strong>Enter</strong>.</p>
                <textarea v-model="form.graduate_profiles" rows="4" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.graduate_profiles ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                    required></textarea>
                <InputError :message="form.errors.graduate_profiles" />
            </div>
            
            <label class="lg:pt-3 text-sm font-bold text-gray-800">Teks Akreditasi <span class="text-red-600">*</span></label>
            <div>
                <textarea v-model="form.accreditation_text" rows="2" 
                    class="block w-full rounded-lg transition-colors py-3"
                    :class="form.errors.accreditation_text ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                    required></textarea>
                <InputError :message="form.errors.accreditation_text" />
            </div>

            <label class="lg:pt-3 text-sm font-bold text-gray-800">Tautan & Media Tambahan</label>
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Link Website Resmi Prodi <span class="text-red-500">*</span></label>
                    <input type="url" v-model="form.website_link" 
                        class="block w-full rounded-lg transition-colors py-2.5 shadow-sm"
                        :class="form.errors.website_link ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'">
                    <InputError :message="form.errors.website_link" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Link File PDF Akreditasi (Opsional)</label>
                    <input type="url" v-model="form.accreditation_pdf_link" 
                        class="block w-full rounded-lg transition-colors py-2.5 shadow-sm"
                        :class="form.errors.accreditation_pdf_link ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'">
                    <InputError :message="form.errors.accreditation_pdf_link" />
                </div>
                
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div v-if="studyProgram.accreditation_certificate_image" class="shrink-0 flex flex-col items-center">
                        <p class="text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest text-center">Gambar Saat Ini</p>
                        <div class="h-24 w-auto bg-white rounded border border-gray-200 flex items-center justify-center p-1 shadow-sm">
                            <img :src="studyProgram.accreditation_certificate_image" class="h-full w-full object-contain" />
                        </div>
                    </div>
                    
                    <div class="w-full space-y-3 min-w-0">
                        <label class="block text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest">Ganti Gambar Sertifikat</label>
                        <div class="relative flex items-center w-full rounded-lg border bg-white shadow-sm px-4 py-2 hover:bg-gray-50 transition" :class="form.errors.accreditation_certificate_image ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                            <PaperClipIcon :class="form.errors.accreditation_certificate_image ? 'text-red-400' : 'text-gray-400'" class="h-5 w-5 flex-shrink-0" />
                            <span class="ml-3 text-sm truncate flex-1 font-medium" :class="form.errors.accreditation_certificate_image ? 'text-red-700' : 'text-gray-500'">
                                {{ form.accreditation_certificate_image ? form.accreditation_certificate_image.name : 'Biarkan kosong jika tidak mengubah gambar...' }}
                            </span>
                            <button v-if="form.accreditation_certificate_image" type="button" @click.prevent="clearImage" class="ml-2 p-1 text-red-500 hover:bg-red-50 rounded-md relative z-10 flex-shrink-0" title="Batal Pilih File">
                                <XMarkIcon class="w-5 h-5"/>
                            </button>
                            <input ref="fileInput" type="file" @change="handleImageChange" accept="image/jpeg, image/png, image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :class="{'hidden': form.accreditation_certificate_image}" />
                        </div>
                        <InputError :message="form.errors.accreditation_certificate_image" />
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
            <Link :href="route('admin.study-programs.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                <PaperAirplaneIcon class="h-5 w-5 stroke-2" />
                {{ form.processing ? 'Menyimpan...' : 'Perbarui Data' }}
            </button>
        </div>
      </form>
    </div>
  </div>
</template>