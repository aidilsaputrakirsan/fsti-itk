<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });
const props = defineProps<{ pengabdian: any; prodis: Array<{ id: number; name: string }>; }>();

const form = useForm({ nama_dosen: props.pengabdian.nama_dosen, judul: props.pengabdian.judul, study_program_id: props.pengabdian.study_program_id || '', tahun: props.pengabdian.tahun });
const submit = () => { form.put(route('admin.pengabdian.update', props.pengabdian.id)); };
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Edit Pengabdian Masyarakat</h1>
      <p class="mt-1 text-black">Edit data pengabdian masyarakat dosen Fakultas Sains dan Teknologi ITK</p>
    </div>
   <div class="bg-white shadow-sm p-8 rounded-lg">
    <form @submit.prevent="submit">
      <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-black">Nama Dosen Pelaksana *</label>
              <input type="text" v-model="form.nama_dosen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#4682A9]" />
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-black">Judul Pengabdian *</label>
              <textarea v-model="form.judul" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#4682A9]"></textarea>
            </div>
            <div>
              <label class="block text-sm font-semibold text-black">Program Studi (Opsional)</label>
              <select v-model="form.study_program_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#4682A9]">
                <option value="">-- Semua / Fakultas --</option>
                <option v-for="prodi in prodis" :key="prodi.id" :value="prodi.id">{{ prodi.name }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-black">Tahun *</label>
              <input type="number" v-model="form.tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#4682A9]" />
            </div>
        </div>
      </div>
      <div class="mt-12 flex items-center justify-end gap-4">
          <Link :href="route('admin.pengabdian.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"><ArrowLeftIcon class="h-5 w-5" /> Batal</Link>
          <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2 text-sm font-semibold text-white hover:bg-opacity-90 disabled:opacity-50"><PaperAirplaneIcon class="h-5 w-5" /> Simpan Perubahan</button>
      </div>
    </form>
   </div>
  </div>
</template>