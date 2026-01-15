<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { computed } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    staff: {
        id: number;
        name: string;
        nip: string;
        email: string;
        category: string;
        position: string;
        prodi: string;
        jurusan: string;
        image_path: string;
        sort_order: number;
        is_active: boolean;
    };
}>();

const form = useForm({
    _method: 'PUT',
    name: props.staff.name,
    nip: props.staff.nip,
    email: props.staff.email,
    category: props.staff.category,
    position: props.staff.position,
    prodi: props.staff.prodi,
    jurusan: props.staff.jurusan,
    sort_order: props.staff.sort_order,
    is_active: Boolean(props.staff.is_active), // Ensure boolean
    image: null as File | null,
});

const categories = [
    'Pimpinan Fakultas',
    'Dosen',
    'Tenaga Kependidikan',
    'Pimpinan Jurusan',
    'Pimpinan Prodi',
    'Pimpinan Laboratorium'
];

const submit = () => {
    form.post(route('admin.staff.update', props.staff.id), {
        forceFormData: true,
    });
};

const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
    }
};

const showProdiJurusan = computed(() => ['Dosen', 'Pimpinan Prodi', 'Pimpinan Jurusan', 'Pimpinan Laboratorium'].includes(form.category));
const showJabatan = computed(() => form.category && form.category !== 'Dosen' && form.category !== 'Tenaga Kependidikan'); 
</script>

<template>
    <div>
        <div class="mb-8">
            <Link :href="route('admin.staff.index')" class="inline-flex items-center gap-2 text-[#4682A9] hover:opacity-80 mb-4">
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-black">Edit Civitas</h1>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg max-w-4xl">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Data Dasar -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">Kategori *</label>
                        <select v-model="form.category" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="" disabled>Pilih Kategori</option>
                            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                        </select>
                         <p v-if="form.errors.category" class="text-red-500 text-xs mt-1">{{ form.errors.category }}</p>
                    </div>
                     <div>
                        <label class="block text-sm font-semibold text-black mb-2">Nama Lengkap (dengan Gelar) *</label>
                        <input v-model="form.name" type="text" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">NIP / NIDN</label>
                        <input v-model="form.nip" type="text" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">Email</label>
                        <input v-model="form.email" type="email" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Conditional Fields -->
                <div v-if="showJabatan">
                     <label class="block text-sm font-semibold text-black mb-2">Jabatan Struktural (Cth: Dekan, Wakil Dekan)</label>
                    <input v-model="form.position" type="text" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div v-if="showProdiJurusan" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                        <label class="block text-sm font-semibold text-black mb-2">Program Studi</label>
                        <input v-model="form.prodi" type="text" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                     <div>
                        <label class="block text-sm font-semibold text-black mb-2">Jurusan</label>
                        <input v-model="form.jurusan" type="text" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Upload Foto -->
                <div>
                     <label class="block text-sm font-semibold text-black mb-2">Foto Profil (Biarkan kosong jika tidak berubah)</label>
                    <input 
                        type="file" 
                        @change="handleImageUpload"
                        accept="image/*"
                         class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                     <p v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</p>
                    <div v-if="staff.image_path" class="mt-2">
                        <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                        <img :src="staff.image_path" class="w-20 h-20 rounded object-cover border" />
                    </div>
                </div>
                
                 <!-- Checkbox Is Active -->
                <div class="flex items-center">
                    <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif (Tampilkan di Website)</label>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <Link :href="route('admin.staff.index')" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">
                        Batal
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-6 py-2 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
