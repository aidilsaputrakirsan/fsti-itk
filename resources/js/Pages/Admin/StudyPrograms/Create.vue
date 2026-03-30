<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const form = useForm({
  name: '',
  degree: 'S1',
  description: '',
  vision: '',
  mission: '',
  goals: '',
  graduate_profiles: '',
  accreditation_text: '',
  accreditation_pdf_link: '',
  website_link: '',
  accreditation_certificate_image: null as File | null,
});

const submit = () => {
  form.post(route('admin.study-programs.store'));
};
</script>

<template>
  <div>
    <Head title="Tambah Program Studi" />
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Tambah Program Studi</h1>
      <p class="mt-1 text-black">Tambah data program studi baru di Fakultas Sains dan Teknologi Informasi</p>
    </div>

    <div class="bg-white shadow-sm p-8 rounded-lg">
      <form @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
          
          <div class="space-y-6">
            <div>
              <label for="name" class="block text-sm font-semibold text-black">Nama Program Studi *</label>
              <input type="text" id="name" v-model="form.name" placeholder="Contoh: Matematika" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
              <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <div>
              <label for="degree" class="block text-sm font-semibold text-black">Jenjang *</label>
              <select id="degree" v-model="form.degree" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required>
                <option value="S1">S1 (Sarjana)</option>
                <option value="S2">S2 (Magister)</option>
              </select>
              <p v-if="form.errors.degree" class="mt-2 text-sm text-red-600">{{ form.errors.degree }}</p>
            </div>

            <div>
              <label for="description" class="block text-sm font-semibold text-black">Profil Ringkas (Deskripsi)</label>
              <textarea id="description" v-model="form.description" rows="4" placeholder="Masukkan deskripsi singkat tentang prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>

            <div>
              <label for="vision" class="block text-sm font-semibold text-black">Visi</label>
              <textarea id="vision" v-model="form.vision" rows="3" placeholder="Masukkan teks visi prodi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>

            <div>
              <label for="goals" class="block text-sm font-semibold text-black">Tujuan (Gunakan 'Enter' untuk poin bernomor)</label>
              <textarea id="goals" v-model="form.goals" rows="6" placeholder="1. Tujuan pertama...&#10;2. Tujuan kedua..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>
          </div>

          <div class="space-y-6">
            <div>
              <label for="mission" class="block text-sm font-semibold text-black">Misi <span class="font-normal text-gray-500">(Gunakan 'Enter' untuk memisah poin)</span></label>
              <textarea id="mission" v-model="form.mission" rows="6" placeholder="1. Misi pertama...&#10;2. Misi kedua..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>

            <div>
              <label for="graduate_profiles" class="block text-sm font-semibold text-black">Profil Lulusan / Karier <span class="font-normal text-gray-500">(Gunakan 'Enter' untuk memisah poin)</span></label>
              <textarea id="graduate_profiles" v-model="form.graduate_profiles" rows="4" placeholder="Data Analyst&#10;Aktuaris&#10;Konsultan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>

            <div>
              <label for="website_link" class="block text-sm font-semibold text-black">Link Website Resmi Prodi (Opsional)</label>
              <input type="url" id="website_link" v-model="form.website_link" placeholder="Contoh: https://math.itk.ac.id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>

            <div>
              <label for="accreditation_text" class="block text-sm font-semibold text-black">Teks Penjelasan Akreditasi</label>
              <textarea id="accreditation_text" v-model="form.accreditation_text" rows="2" placeholder="Telah terakreditasi dengan peringkat Baik." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>

            <div>
              <label for="accreditation_pdf_link" class="block text-sm font-semibold text-black">Link URL File PDF Akreditasi (Opsional)</label>
              <input type="url" id="accreditation_pdf_link" v-model="form.accreditation_pdf_link" placeholder="Contoh: https://ult.itk.ac.id/.../sertifikat.pdf" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            </div>
          </div>

          <div class="md:col-span-2">
            <label for="image" class="block text-sm font-semibold text-black">Unggah Gambar Sertifikat Akreditasi (Opsional)</label>
            <div class="mt-1 relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2">
              <PaperClipIcon class="h-5 w-5 text-gray-400" />
              <span class="ml-3 text-sm" :class="{'text-gray-400': !form.accreditation_certificate_image, 'text-black': form.accreditation_certificate_image}">
                {{ form.accreditation_certificate_image ? form.accreditation_certificate_image.name : 'Pilih file gambar sertifikat (JPG/PNG)' }}
              </span>
              <input type="file" id="image" @input="form.accreditation_certificate_image = ($event.target as HTMLInputElement).files?.[0] || null" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
            </div>
            <p v-if="form.errors.accreditation_certificate_image" class="mt-2 text-sm text-red-600">{{ form.errors.accreditation_certificate_image }}</p>
          </div>
        </div>

        <div class="mt-12 flex items-center justify-end gap-4">
            <Link :href="route('admin.study-programs.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-black shadow-sm hover:bg-gray-50">
                <ArrowLeftIcon class="h-5 w-5" /> Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 disabled:opacity-50">
                <PaperAirplaneIcon class="h-5 w-5" /> Simpan
            </button>
        </div>
      </form>
    </div>
  </div>
</template>