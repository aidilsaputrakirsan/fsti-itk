<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    studyProgram: any;
}>();

const formatArrayToText = (arr: any): string => Array.isArray(arr) ? arr.join('\n') : '';

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
    goals: props.studyProgram.goals || '',
    graduate_profiles: formatArrayToText(props.studyProgram.graduate_profiles),
    accreditation_text: props.studyProgram.accreditation_text || '',
    accreditation_pdf_link: props.studyProgram.accreditation_pdf_link || '',
    website_link: props.studyProgram.website_link || '',
    accreditation_certificate_image: null, 
});

const submit = () => {
    form.post(route('admin.study-programs.update', props.studyProgram.id));
};
</script>

<template>
  <div>
    <Head :title="'Edit Prodi: ' + studyProgram.name" />
    <div class="mb-8 flex items-center gap-4">
      <Link :href="route('admin.study-programs.index')" class="text-gray-500 hover:text-[#4682A9] transition bg-white p-2 rounded-full shadow-sm">
          <ArrowLeftIcon class="w-5 h-5" />
      </Link>
      <div>
        <h1 class="text-3xl font-bold text-black">Edit Program Studi</h1>
        <p class="mt-1 text-black">Perbarui detail Program Studi {{ studyProgram.degree }} {{ studyProgram.name }}</p>
      </div>
    </div>

    <div class="bg-white shadow-sm p-8 rounded-lg">
      <form @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
          
          <div class="space-y-6">
            <div>
              <label class="block text-sm font-semibold text-black">Nama Program Studi *</label>
              <input type="text" v-model="form.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-semibold text-black">Jenjang *</label>
                  <select v-model="form.degree" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required>
                    <option value="S1">S1 (Sarjana)</option>
                    <option value="S2">S2 (Magister)</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-semibold text-black">Jurusan *</label>
                  <select v-model="form.department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required>
                    <option value="Sains dan Analitika Data">Sains dan Analitika Data</option>
                    <option value="Teknik Elektro, Informatika, dan Bisnis">Teknik Elektro, Informatika, dan Bisnis</option>
                  </select>
                </div>
            </div>

            <div>
              <label class="block text-sm font-semibold text-black">Profil Ringkas (Deskripsi) *</label>
              <textarea v-model="form.description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
            </div>

            <div>
              <label class="block text-sm font-semibold text-black">Visi *</label>
              <textarea v-model="form.vision" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
            </div>

            <div>
              <label class="block text-sm font-semibold text-black">Tujuan * <span class="font-normal text-gray-500">(Pisahkan dengan 'Enter')</span></label>
              <textarea v-model="form.goals" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
            </div>
          </div>

          <div class="space-y-6">
            <div>
              <label class="block text-sm font-semibold text-black">Misi * <span class="font-normal text-gray-500">(Pisahkan dengan 'Enter')</span></label>
              <textarea v-model="form.mission" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
            </div>

            <div>
              <label class="block text-sm font-semibold text-black">Profil Lulusan / Karier * <span class="font-normal text-gray-500">(Pisahkan dengan 'Enter')</span></label>
              <textarea v-model="form.graduate_profiles" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
            </div>

            <div>
              <label class="block text-sm font-semibold text-black">Teks Penjelasan Akreditasi *</label>
              <textarea v-model="form.accreditation_text" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
            </div>

            <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl space-y-4">
                <h4 class="text-sm font-bold text-gray-700">Tautan & Media (Opsional)</h4>
                
                <div>
                  <label class="block text-sm font-semibold text-gray-600">Link Website Resmi Prodi</label>
                  <input type="url" v-model="form.website_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-600">Link File PDF Akreditasi</label>
                  <input type="url" v-model="form.accreditation_pdf_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-600">Ganti Gambar Sertifikat Akreditasi</label>
                  
                  <div class="mt-2 mb-3" v-if="studyProgram.accreditation_certificate_image">
                      <img :src="studyProgram.accreditation_certificate_image" class="h-32 w-auto rounded-lg border border-gray-300 p-1 bg-white shadow-sm">
                  </div>

                  <div class="relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2 hover:bg-gray-100 transition">
                    <PaperClipIcon class="h-5 w-5 text-gray-400" />
                    <span class="ml-3 text-sm" :class="{'text-gray-400': !form.accreditation_certificate_image, 'text-black': form.accreditation_certificate_image}">
                      {{ form.accreditation_certificate_image ? form.accreditation_certificate_image.name : 'Pilih file gambar baru' }}
                    </span>
                    <input type="file" @input="form.accreditation_certificate_image = ($event.target as HTMLInputElement).files?.[0] || null" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                  </div>
                  <p v-if="form.errors.accreditation_certificate_image" class="mt-2 text-sm text-red-600">{{ form.errors.accreditation_certificate_image }}</p>
                </div>
            </div>
          </div>
        </div>

        <div class="mt-10 flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
            <Link :href="route('admin.study-programs.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-opacity-90 disabled:opacity-50 transition">
                <PaperAirplaneIcon class="h-5 w-5" /> Perbarui
            </button>
        </div>
      </form>
    </div>
  </div>
</template>