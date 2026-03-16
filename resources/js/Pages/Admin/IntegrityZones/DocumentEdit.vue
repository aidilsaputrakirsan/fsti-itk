<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon, LinkIcon, DocumentCheckIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    document: {
        id: number;
        title: string;
        file_url: string | null;
    }
}>();

// Gunakan URL statis jika itu berasal dari link luar
const currentIsUrl = props.document.file_url && !props.document.file_url.includes('/storage/');

const form = useForm({
    title: props.document.title,
    file: null as File | null,
    file_url: currentIsUrl ? props.document.file_url : '',
});

const handleFileUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    form.file = target.files?.[0] || null;
};

const submit = () => {
    form.post(route('admin.zi.document.update', props.document.id), {
        forceFormData: true
    });
};
</script>

<template>
  <div>
    <Head :title="'Edit Dokumen: ' + document.title" />
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Edit Dokumen ZI</h1>
      <p class="mt-1 text-black">Perbarui judul atau ganti lampiran dokumen</p>
    </div>

    <div class="bg-white shadow-sm p-8 rounded-lg w-full">
      <form @submit.prevent="submit">
        <div class="grid grid-cols-1 gap-y-6">
          
          <div>
            <label for="title" class="block text-sm font-semibold text-black">Judul Dokumen *</label>
            <input type="text" id="title" v-model="form.title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9]" required />
            <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
          </div>

          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center w-full">
            <DocumentCheckIcon class="w-6 h-6 text-blue-600 mr-3" />
            <div>
                <p class="text-sm text-blue-900 font-semibold">Dokumen yang terpasang saat ini</p>
                <a :href="document.file_url || '#'" target="_blank" class="text-xs text-blue-600 hover:underline">Klik di sini untuk melihat/mengunduh dokumen lama</a>
            </div>
          </div>

          <div class="p-6 border border-gray-200 rounded-lg bg-gray-50/50">
              <p class="text-base font-semibold text-black mb-6">Pembaruan Sumber Dokumen <span class="font-normal text-gray-500 text-sm ml-1">(Abaikan jika tidak ingin mengganti file)</span></p>
              
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                  <div>
                    <label for="file" class="block text-sm font-semibold text-black">Ganti dengan Unggah File PDF</label>
                    <div class="mt-2 relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2.5" :class="{'opacity-50 bg-gray-100': form.file_url !== '' && form.file_url !== document.file_url}">
                        <PaperClipIcon class="h-5 w-5 text-gray-400" />
                        <span class="ml-3 text-sm truncate" :class="{'text-gray-400': !form.file, 'text-black font-semibold': form.file}">
                            {{ form.file ? form.file.name : 'Pilih file PDF baru (Maks 10MB)' }}
                        </span>
                        <input type="file" id="file" @change="handleFileUpload" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :disabled="form.file_url !== '' && form.file_url !== document.file_url" />
                    </div>
                    <p v-if="form.errors.file" class="mt-2 text-sm text-red-600">{{ form.errors.file }}</p>
                  </div>

                  <div>
                    <label for="file_url" class="block text-sm font-semibold text-black">Ganti dengan Tautan Eksternal</label>
                    <div class="mt-2 relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <LinkIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <input type="text" id="file_url" v-model="form.file_url" placeholder="https://drive.google.com/..." class="block w-full rounded-md border-gray-300 pl-10 focus:border-[#4682A9] focus:ring-[#4682A9] sm:text-sm py-2.5" :disabled="form.file !== null" :class="{'bg-gray-100 opacity-50': form.file !== null}" />
                    </div>
                    <p v-if="form.errors.file_url" class="mt-2 text-sm text-red-600">{{ form.errors.file_url }}</p>
                  </div>
              </div>
          </div>

        </div>

        <div class="mt-12 flex items-center justify-end gap-4">
            <Link :href="route('admin.zi.document.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                <ArrowLeftIcon class="h-5 w-5" />
                Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 disabled:opacity-50">
                <PaperAirplaneIcon class="h-5 w-5" />
                Perbarui Dokumen
            </button>
        </div>
      </form>
    </div>
  </div>
</template>