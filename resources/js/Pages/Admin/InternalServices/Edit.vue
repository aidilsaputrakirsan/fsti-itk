<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });
const props = defineProps({ service: Object });

const form = useForm({
    _method: 'patch',
    name: props.service.name,
    link_url: props.service.link_url,
    description: props.service.description,
    sort_order: props.service.sort_order || 1,
});

const submit = () => form.post(route('admin.internal-services.update', props.service.id));
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Edit Layanan</h1>
      <p class="mt-1 text-gray-600">Perbarui informasi tautan portal layanan mahasiswa.</p>
    </div>

    <div class="bg-white shadow-sm p-8 rounded-lg border border-gray-100 w-full">
      <form @submit.prevent="submit" class="space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-black mb-1">Nama Layanan *</label>
                <input type="text" v-model="form.name" class="w-full rounded-md border-gray-300 focus:ring-[#4682A9] focus:border-[#4682A9] shadow-sm">
                <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-black mb-1">URL Tautan *</label>
                <input type="url" v-model="form.link_url" class="w-full rounded-md border-gray-300 focus:ring-[#4682A9] focus:border-[#4682A9] shadow-sm">
                <p v-if="form.errors.link_url" class="text-red-500 text-xs mt-1">{{ form.errors.link_url }}</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-black mb-1">Urutan Tampil *</label>
            <input type="number" min="1" v-model="form.sort_order" class="w-full md:w-1/2 rounded-md border-gray-300 focus:ring-[#4682A9] focus:border-[#4682A9] shadow-sm">
            <p class="text-xs text-gray-500 mt-1">Angka terkecil (1) akan tampil paling atas.</p>
            <p v-if="form.errors.sort_order" class="text-red-500 text-xs mt-1">{{ form.errors.sort_order }}</p>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-black mb-1">Deskripsi Singkat *</label>
            <textarea v-model="form.description" rows="4" class="w-full rounded-md border-gray-300 focus:ring-[#4682A9] focus:border-[#4682A9] shadow-sm"></textarea>
            <p v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</p>
        </div>

        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
            <Link :href="route('admin.internal-services.index')" class="flex items-center gap-2 px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition shadow-sm">
                <ArrowLeftIcon class="w-5 h-5" /> Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50 transition shadow-sm">
                <PaperAirplaneIcon class="w-5 h-5" /> Perbarui Layanan
            </button>
        </div>
      </form>
    </div>
  </div>
</template>