<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    studyPrograms: string[];
}>();

interface AlumniFormData {
    nim: string;
    name: string;
    study_program: string;
    entry_year: number | ''; 
    graduation_year: number | ''; 
}

const form = useForm<AlumniFormData>({
    nim: '',
    name: '',
    study_program: '',
    entry_year: new Date().getFullYear() - 4, 
    graduation_year: new Date().getFullYear(),
});

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.nim) {
        form.setError('nim', 'NIM wajib diisi.');
        hasError = true;
    }

    if (!form.name) {
        form.setError('name', 'Nama lengkap wajib diisi.');
        hasError = true;
    }

    if (!form.study_program) {
        form.setError('study_program', 'Program studi wajib dipilih.');
        hasError = true;
    }

    if (!form.entry_year) {
        form.setError('entry_year', 'Tahun masuk wajib diisi.');
        hasError = true;
    }

    if (!form.graduation_year) {
        form.setError('graduation_year', 'Tahun kelulusan wajib diisi.');
        hasError = true;
    }

    if (hasError) return;

    form.post(route('admin.alumni.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Data Alumni" />

        <div class="mb-8">
            <Link :href="route('admin.alumni.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Data Alumni</h1>
            <p class="mt-1 text-gray-600">Masukkan data kelulusan mahasiswa baru FSTI ITK.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nomor Induk Mahasiswa <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.nim" type="text" placeholder="Contoh: 10221015" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.nim ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.nim" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Lengkap <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.name" type="text" placeholder="Masukkan nama lengkap alumni" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.name" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Program Studi <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.study_program" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.study_program ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                            <option value="" disabled>Pilih Program Studi</option>
                            <option v-for="prodi in studyPrograms" :key="prodi" :value="prodi">{{ prodi }}</option>
                        </select>
                        <InputError :message="form.errors.study_program" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Tahun Masuk <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.entry_year" type="number" min="2012" :max="new Date().getFullYear()" placeholder="Contoh: 2020" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.entry_year ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.entry_year" />
                    </div>
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Tahun Kelulusan <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.graduation_year" type="number" min="2000" :max="new Date().getFullYear() + 1" placeholder="Contoh: 2024" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.graduation_year ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.graduation_year" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.alumni.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <PaperAirplaneIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>