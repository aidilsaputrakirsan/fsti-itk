<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    alumni: Object
});

const prodis = [
    'Matematika', 'Ilmu Aktuaria', 'Statistika', 'Fisika', 
    'Informatika', 'Sistem Informasi', 'Bisnis Digital', 'Teknik Elektro'
];

const form = useForm({
    nim: props.alumni.nim,
    name: props.alumni.name,
    study_program: props.alumni.study_program,
    graduation_year: props.alumni.graduation_year,
});

const submit = () => {
    form.put(route('admin.alumni.update', props.alumni.id));
};
</script>

<template>
    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-black">Edit Data Alumni</h1>
            <p class="mt-1 text-black">Perbarui informasi kelulusan untuk mahasiswa <strong>{{ props.alumni.name }}</strong></p>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="nim" class="block text-sm font-semibold text-black">Nomor Induk Mahasiswa (NIM) *</label>
                            <input type="text" id="nim" v-model="form.nim" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
                            <p v-if="form.errors.nim" class="mt-2 text-sm text-red-600">{{ form.errors.nim }}</p>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-semibold text-black">Nama Lengkap *</label>
                            <input type="text" id="name" v-model="form.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
                            <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="study_program" class="block text-sm font-semibold text-black">Program Studi *</label>
                            <select id="study_program" v-model="form.study_program" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required>
                                <option value="" disabled>Pilih Program Studi</option>
                                <option v-for="prodi in prodis" :key="prodi" :value="prodi">{{ prodi }}</option>
                            </select>
                            <p v-if="form.errors.study_program" class="mt-2 text-sm text-red-600">{{ form.errors.study_program }}</p>
                        </div>

                        <div>
                            <label for="graduation_year" class="block text-sm font-semibold text-black">Tahun Kelulusan *</label>
                            <input type="number" id="graduation_year" v-model="form.graduation_year" min="2000" :max="new Date().getFullYear() + 1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4682A9] focus:ring-[#4682A9] focus:ring-opacity-50 sm:text-sm" required />
                            <p v-if="form.errors.graduation_year" class="mt-2 text-sm text-red-600">{{ form.errors.graduation_year }}</p>
                        </div>
                    </div>

                </div>

                <div class="mt-12 flex items-center justify-end gap-4">
                    <Link :href="route('admin.alumni.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        <ArrowLeftIcon class="h-5 w-5" />
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5" />
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>