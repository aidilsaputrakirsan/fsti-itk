<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import type { Achievement } from '@/types'; 

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    achievement: Achievement;
    studyPrograms: Array<any>;
}>();

const imageInput = ref<HTMLInputElement | null>(null);
const certificateInput = ref<HTMLInputElement | null>(null);

const form = useForm({
  _method: 'patch', 
  student_name: props.achievement.student_name,
  student_nim: props.achievement.student_nim || '',
  study_program: props.achievement.study_program || '',
  title: props.achievement.title, 
  category: props.achievement.category,
  level: props.achievement.level,
  organizer: props.achievement.organizer || '',
  year: props.achievement.year,
  image: null as File | null, 
  certificate: null as File | null,
});

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
    } else {
        form.image = null;
    }
};

const handleCertificateChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.certificate = target.files[0];
    } else {
        form.certificate = null;
    }
};

const clearImage = () => {
    form.image = null;
    if (imageInput.value) imageInput.value.value = '';
};

const clearCertificate = () => {
    form.certificate = null;
    if (certificateInput.value) certificateInput.value.value = '';
};

const submit = () => {
  form.clearErrors();
  let hasError = false;

  if (!form.student_name) { form.setError('student_name', 'Nama Mahasiswa wajib diisi.'); hasError = true; }
  if (!form.title) { form.setError('title', 'Capaian Prestasi wajib diisi.'); hasError = true; }
  if (!form.category) { form.setError('category', 'Kategori wajib dipilih.'); hasError = true; }
  if (!form.level) { form.setError('level', 'Tingkat prestasi wajib dipilih.'); hasError = true; }
  if (!form.year) { form.setError('year', 'Tahun wajib diisi.'); hasError = true; }

  if (form.image) {
      const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      if (!allowedTypes.includes(form.image.type)) {
          form.setError('image', 'Format file harus JPG, PNG, atau WEBP.');
          hasError = true;
      } else if (form.image.size > 2 * 1024 * 1024) {
          form.setError('image', 'Ukuran file maksimal 2MB.');
          hasError = true;
      }
  }

  if (form.certificate) {
      const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/webp'];
      if (!allowedTypes.includes(form.certificate.type)) {
          form.setError('certificate', 'Format file harus PDF, JPG, PNG, atau WEBP.');
          hasError = true;
      } else if (form.certificate.size > 2 * 1024 * 1024) {
          form.setError('certificate', 'Ukuran file maksimal 2MB.');
          hasError = true;
      }
  }

  if (hasError) return;
  form.post(route('admin.achievements.update', props.achievement.id));
};
</script>

<template>
  <div>
    <Head :title="'Edit Prestasi: ' + achievement.student_name" />
    <div class="mb-8">
        <Link :href="route('admin.achievements.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
            <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
        </Link>
        <h1 class="text-3xl font-bold text-gray-900">Edit Prestasi</h1>
        <p class="mt-1 text-gray-600">Perbarui informasi detail dan bukti capaian prestasi mahasiswa.</p>
    </div>

    <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
    <form @submit.prevent="submit" novalidate>
      <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
        
          <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Mahasiswa / Tim <span class="text-red-600">*</span></label>
          <div>
            <textarea v-model="form.student_name" rows="3" 
                class="block w-full rounded-lg transition-colors py-3"
                :class="form.errors.student_name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                required></textarea>
            <InputError :message="form.errors.student_name" />
          </div>

          <label class="md:pt-3 text-sm font-bold text-gray-800">NIM Mahasiswa</label>
          <div>
            <textarea v-model="form.student_nim" rows="3" 
                class="block w-full rounded-lg transition-colors py-3 border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white"></textarea>
            <InputError :message="form.errors.student_nim" />
          </div>

          <label class="md:pt-3 text-sm font-bold text-gray-800">Program Studi</label>
          <div>
            <select v-model="form.study_program" class="block w-full rounded-lg transition-colors py-3 border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white">
              <option value="">-- Tidak Ada / Pilih Prodi --</option>
              <option v-for="prodi in studyPrograms" :key="prodi.id" :value="prodi.name">
                {{ prodi.degree }} {{ prodi.name }}
              </option>
            </select>
            <InputError :message="form.errors.study_program" />
          </div>

          <label class="md:pt-3 text-sm font-bold text-gray-800">Capaian Prestasi <span class="text-red-600">*</span></label>
          <div>
            <input type="text" v-model="form.title" 
                class="block w-full rounded-lg transition-colors py-3"
                :class="form.errors.title ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                required />
            <InputError :message="form.errors.title" />
          </div>

          <label class="md:pt-3 text-sm font-bold text-gray-800">Kategori & Tingkat <span class="text-red-600">*</span></label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                  <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
                  <select v-model="form.category" class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white py-3" required>
                      <option value="" disabled>Pilih kategori</option>
                      <option>Akademik</option>
                      <option>Non-Akademik</option>
                  </select>
                  <InputError :message="form.errors.category" />
              </div>
              <div>
                  <label class="block text-xs font-semibold text-gray-600 mb-1">Tingkat</label>
                  <select v-model="form.level" class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white py-3" required>
                      <option value="" disabled>Pilih tingkat</option>
                      <option>Internasional</option>
                      <option>Nasional</option>
                      <option>Provinsi</option>
                      <option>Kota/Kabupaten</option>
                      <option>Universitas</option>
                  </select>
                  <InputError :message="form.errors.level" />
              </div>
          </div>

          <label class="md:pt-3 text-sm font-bold text-gray-800">Penyelenggara</label>
          <div>
            <input type="text" v-model="form.organizer" 
                class="block w-full rounded-lg transition-colors py-3 border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white" />
            <InputError :message="form.errors.organizer" />
          </div>
          
          <label class="md:pt-3 text-sm font-bold text-gray-800">Tahun <span class="text-red-600">*</span></label>
          <div>
            <input type="number" v-model="form.year" 
                class="block w-full rounded-lg transition-colors py-3"
                :class="form.errors.year ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                required />
            <InputError :message="form.errors.year" />
          </div>

          <label class="md:pt-3 text-sm font-bold text-gray-800">Berkas Pendukung</label>
          <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 space-y-5">
              
              <div class="flex flex-col lg:flex-row gap-6 items-start border-b border-gray-200 pb-5">
                  <div v-if="achievement.image_url" class="shrink-0 flex flex-col items-center">
                      <p class="text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest text-center">Foto Saat Ini</p>
                      <div class="h-24 w-24 bg-white rounded border border-gray-200 flex items-center justify-center p-1 shadow-sm">
                          <img :src="achievement.image_url" class="h-full w-full object-cover rounded-sm" />
                      </div>
                  </div>
                  <div class="w-full space-y-3 min-w-0">
                      <label class="block text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest">Ganti Foto Mahasiswa / Tim</label>
                      <div class="relative flex items-center w-full rounded-lg border bg-white shadow-sm px-4 py-2.5 hover:bg-gray-50 transition" :class="form.errors.image ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                          <PaperClipIcon :class="form.errors.image ? 'text-red-400' : 'text-gray-400'" class="h-5 w-5 flex-shrink-0" />
                          <span class="ml-3 text-sm truncate flex-1 font-medium" :class="form.errors.image ? 'text-red-700' : 'text-gray-500'">
                              {{ form.image ? form.image.name : 'Biarkan kosong jika tidak mengubah foto...' }}
                          </span>
                          <button v-if="form.image" type="button" @click.prevent="clearImage" class="ml-2 p-1 text-red-500 hover:bg-red-50 rounded-md relative z-10 flex-shrink-0" title="Batal Pilih File">
                              <XMarkIcon class="w-5 h-5"/>
                          </button>
                          <input ref="imageInput" type="file" @change="handleImageChange" accept="image/jpeg, image/png, image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :class="{'hidden': form.image}" />
                      </div>
                      <InputError :message="form.errors.image" />
                  </div>
              </div>

              <div class="flex flex-col lg:flex-row gap-6 items-start">
                  <div v-if="achievement.certificate_url" class="shrink-0 flex flex-col items-center">
                      <p class="text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest text-center">Bukti Saat Ini</p>
                      <a :href="achievement.certificate_url" target="_blank" class="h-10 px-4 bg-white rounded border border-gray-300 flex items-center justify-center shadow-sm text-sm font-bold text-primary hover:bg-gray-50">
                          Lihat Bukti
                      </a>
                  </div>
                  <div class="w-full space-y-3 min-w-0">
                      <label class="block text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest">Ganti Sertifikat / Bukti</label>
                      <div class="relative flex items-center w-full rounded-lg border bg-white shadow-sm px-4 py-2.5 hover:bg-gray-50 transition" :class="form.errors.certificate ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                          <PaperClipIcon :class="form.errors.certificate ? 'text-red-400' : 'text-gray-400'" class="h-5 w-5 flex-shrink-0" />
                          <span class="ml-3 text-sm truncate flex-1 font-medium" :class="form.errors.certificate ? 'text-red-700' : 'text-gray-500'">
                              {{ form.certificate ? form.certificate.name : 'Biarkan kosong jika tidak mengubah bukti...' }}
                          </span>
                          <button v-if="form.certificate" type="button" @click.prevent="clearCertificate" class="ml-2 p-1 text-red-500 hover:bg-red-50 rounded-md relative z-10 flex-shrink-0" title="Batal Pilih File">
                              <XMarkIcon class="w-5 h-5"/>
                          </button>
                          <input ref="certificateInput" type="file" @change="handleCertificateChange" accept="application/pdf, image/jpeg, image/png, image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :class="{'hidden': form.certificate}" />
                      </div>
                      <InputError :message="form.errors.certificate" />
                  </div>
              </div>
          </div>

        </div>

        <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
            <Link :href="route('admin.achievements.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
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