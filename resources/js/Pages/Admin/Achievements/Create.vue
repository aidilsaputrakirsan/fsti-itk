<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const form = useForm({
  student_name: '',
  student_nim: '',    // Dibiarkan kosong agar nullable di backend
  study_program: '',  // Default string kosong agar cocok dengan opsi pertama dropdown
  title: '',
  category: '', 
  level: '', 
  organizer: '',
  year: new Date().getFullYear(),
  image: null as File | null, 
  certificate: null as File | null,
});

const submit = () => {
  form.post(route('admin.achievements.store'));
};
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Tambah Prestasi</h1>
      <p class="mt-1 text-black">Tambah prestasi baru mahasiswa Fakultas Sains dan Teknologi Institut Teknologi Kalimantan</p>
    </div>

   <div class="bg-white shadow-sm p-8 rounded-lg">
    <form @submit.prevent="submit">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
        <div class="space-y-6">
          <div>
            <label for="student_name" class="block text-sm font-semibold text-black">Nama Mahasiswa / Tim *</label>
            <textarea id="student_name" v-model="form.student_name" rows="3" placeholder="Masukkan Nama (Gunakan baris baru untuk lebih dari 1 orang)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            <p v-if="form.errors.student_name" class="mt-2 text-sm text-red-600">{{ form.errors.student_name }}</p>
          </div>

          <div>
            <label for="student_nim" class="block text-sm font-semibold text-black">NIM Mahasiswa (Opsional)</label>
            <textarea id="student_nim" v-model="form.student_nim" rows="3" placeholder="Masukkan NIM (Gunakan baris baru jika banyak)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
            <p v-if="form.errors.student_nim" class="mt-2 text-sm text-red-600">{{ form.errors.student_nim }}</p>
          </div>

            <div>
              <label for="study_program" class="block text-sm font-semibold text-black">Program Studi (Opsional)</label>
              <select id="study_program" v-model="form.study_program" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm">
                <option value="">-- Tidak Ada / Pilih Prodi --</option>
                <option>Teknik Elektro</option>
                <option>Sistem Informasi</option>
                <option>Informatika</option>
                <option>Bisnis Digital</option>
                <option>Magister Manajemen Teknologi</option>
                <option>Fisika</option>
                <option>Matematika</option>
                <option>Statistika</option>
                <option>Ilmu Aktuaria</option>
              </select>
              <p v-if="form.errors.study_program" class="mt-2 text-sm text-red-600">{{ form.errors.study_program }}</p>
            </div>

            <div>
              <label for="title" class="block text-sm font-semibold text-black">Capaian Prestasi *</label>
              <input type="text" id="title" v-model="form.title" placeholder="Masukkan nama prestasi atau lomba yang dicapai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
              <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
            </div>
          </div>

          <div class="space-y-6">
            <div>
              <label for="category" class="block text-sm font-semibold text-black">Kategori *</label>
              <select id="category" v-model="form.category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm">
                <option value="" disabled>Pilih kategori prestasi</option>
                <option>Akademik</option>
                <option>Non-Akademik</option>
              </select>
              <p v-if="form.errors.category" class="mt-2 text-sm text-red-600">{{ form.errors.category }}</p>
            </div>

            <div>
              <label for="level" class="block text-sm font-semibold text-black">Tingkat *</label>
              <select id="level" v-model="form.level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm">
                <option value="" disabled>Pilih tingkat prestasi</option>
                <option>Internasional</option>
                <option>Nasional</option>
                <option>Provinsi</option>
                <option>Kota/Kabupaten</option>
                <option>Universitas</option>
              </select>
              <p v-if="form.errors.level" class="mt-2 text-sm text-red-600">{{ form.errors.level }}</p>
            </div>

            <div>
              <label for="organizer" class="block text-sm font-semibold text-black">Penyelenggara (Opsional)</label>
              <input type="text" id="organizer" v-model="form.organizer" placeholder="Masukkan institusi penyelenggara" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
              <p v-if="form.errors.organizer" class="mt-2 text-sm text-red-600">{{ form.errors.organizer }}</p>
            </div>
            
            <div>
              <label for="year" class="block text-sm font-semibold text-black">Tahun *</label>
              <input type="number" id="year" v-model="form.year" placeholder="Masukkan tahun capaian prestasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
              <p v-if="form.errors.year" class="mt-2 text-sm text-red-600">{{ form.errors.year }}</p>
            </div>
          </div>

          <div class="md:col-span-2">
            <label for="image" class="block text-sm font-semibold text-black">Foto Mahasiswa/Tim *</label>
            <div class="mt-1 relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2">
              <PaperClipIcon class="h-5 w-5 text-gray-400" />
              <span class="ml-3 text-sm" :class="{'text-gray-400': !form.image, 'text-black': form.image}">
                {{ form.image ? form.image.name : 'Unggah foto mahasiswa atau tim (Wajib)' }}
              </span>
              <input type="file" id="image" @input="form.image = ($event.target as HTMLInputElement).files?.[0] || null" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
            </div>
            <p v-if="form.errors.image" class="mt-2 text-sm text-red-600">{{ form.errors.image }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="certificate" class="block text-sm font-semibold text-black">Bukti (Opsional)</label> 
            <div class="mt-1 relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2">
              <PaperClipIcon class="h-5 w-5 text-gray-400" />
              <span class="ml-3 text-sm" :class="{'text-gray-400': !form.certificate, 'text-black': form.certificate}">
                {{ form.certificate ? form.certificate.name : 'Masukkan bukti berupa sertifikat atau gambar' }}
              </span>
              <input type="file" id="certificate" @input="form.certificate = ($event.target as HTMLInputElement).files?.[0] || null" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
            </div>
            <p v-if="form.errors.certificate" class="mt-2 text-sm text-red-600">{{ form.errors.certificate }}</p>
          </div>
        </div>

        <div class="mt-12 flex items-center justify-end gap-4">
            <Link :href="route('admin.achievements.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                <ArrowLeftIcon class="h-5 w-5" />
                Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 disabled:opacity-50">
                <PaperAirplaneIcon class="h-5 w-5" />
                Simpan
            </button>
        </div>
      </form>
    </div>
  </div>
</template>