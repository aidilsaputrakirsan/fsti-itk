<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

// Menangkap data prodi dari controller
const props = defineProps<{
  prodis: Array<{ id: number; name: string }>;
}>();

const form = useForm({
  nama_dosen: '',
  judul: '',
  study_program_id: '', // Default string kosong agar opsi pertama dropdown aktif
  tahun: new Date().getFullYear(),
});

const submit = () => {
  form.post(route('admin.penelitian.store'));
};
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Tambah Penelitian</h1>
      <p class="mt-1 text-black">Tambah data penelitian dosen Fakultas Sains dan Teknologi Institut Teknologi Kalimantan</p>
    </div>

   <div class="bg-white shadow-sm p-8 rounded-lg">
    <form @submit.prevent="submit">
      <div class="space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div class="md:col-span-2">
              <label for="nama_dosen" class="block text-sm font-semibold text-black">Nama Peneliti / Dosen *</label>
              <input type="text" id="nama_dosen" v-model="form.nama_dosen" placeholder="Masukkan Nama Dosen (Gunakan koma untuk lebih dari 1 orang)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
              <p v-if="form.errors.nama_dosen" class="mt-2 text-sm text-red-600">{{ form.errors.nama_dosen }}</p>
            </div>

            <div class="md:col-span-2">
              <label for="judul" class="block text-sm font-semibold text-black">Judul Penelitian *</label>
              <textarea id="judul" v-model="form.judul" rows="3" placeholder="Masukkan Judul Penelitian" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm"></textarea>
              <p v-if="form.errors.judul" class="mt-2 text-sm text-red-600">{{ form.errors.judul }}</p>
            </div>

            <div>
              <label for="study_program_id" class="block text-sm font-semibold text-black">Program Studi (Opsional)</label>
              <select id="study_program_id" v-model="form.study_program_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm">
                <option value="">-- Semua / Fakultas --</option>
                <option v-for="prodi in prodis" :key="prodi.id" :value="prodi.id">
                  {{ prodi.name }}
                </option>
              </select>
              <p v-if="form.errors.study_program_id" class="mt-2 text-sm text-red-600">{{ form.errors.study_program_id }}</p>
            </div>

            <div>
              <label for="tahun" class="block text-sm font-semibold text-black">Tahun *</label>
              <input type="number" id="tahun" v-model="form.tahun" placeholder="Masukkan tahun penelitian" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" />
              <p v-if="form.errors.tahun" class="mt-2 text-sm text-red-600">{{ form.errors.tahun }}</p>
            </div>
        </div>

      </div>

      <div class="mt-12 flex items-center justify-end gap-4">
          <Link :href="route('admin.penelitian.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
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