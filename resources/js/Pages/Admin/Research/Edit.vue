<script setup lang="ts">
import { Link, useForm, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeftIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    research: any;
    studyPrograms: Array<{ id: number; name: string }>;
}>();

interface PenelitianFormData {
    _method: string;
    nama_dosen: string;
    judul: string;
    study_program_id: string | number;
    tahun: number;
}

const form = useForm<PenelitianFormData>({
    _method: 'PUT',
    nama_dosen: props.research.nama_dosen || '',
    judul: props.research.judul || '',
    study_program_id: props.research.study_program_id || '',
    tahun: props.research.tahun || new Date().getFullYear(),
});

const validateForm = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.nama_dosen) {
        form.setError('nama_dosen', 'Nama peneliti/dosen wajib diisi.');
        hasError = true;
    }

    if (!form.judul) {
        form.setError('judul', 'Judul penelitian wajib diisi.');
        hasError = true;
    }

    if (!form.study_program_id) {
        form.setError('study_program_id', 'Program Studi wajib dipilih.');
        hasError = true;
    }

    if (!form.tahun) {
        form.setError('tahun', 'Tahun wajib diisi.');
        hasError = true;
    }

    return !hasError;
};

const submit = () => {
    if (!validateForm()) return;
    form.post(route('admin.penelitian.update', props.research.id));
};
</script>

<template>
    <div>
        <Head :title="'Edit Penelitian: ' + (research.nama_dosen || '')" />

        <div class="mb-8">
            <Link :href="route('admin.penelitian.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Edit Data Penelitian</h1>
            <p class="mt-1 text-gray-600">Perbarui rekam jejak riset dosen Fakultas Sains dan Teknologi ITK.</p>
        </div>

        <div v-if="research.id" class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Peneliti / Dosen <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.nama_dosen" type="text" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.nama_dosen ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.nama_dosen" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Judul Penelitian <span class="text-red-600">*</span></label>
                    <div>
                        <textarea v-model="form.judul" rows="4" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.judul ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required></textarea>
                        <InputError :message="form.errors.judul" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Program Studi <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.study_program_id" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.study_program_id ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                            <option value="" disabled>-- Pilih Program Studi --</option>
                            <option v-for="prodi in studyPrograms" :key="prodi.id" :value="prodi.id">
                                {{ prodi.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.study_program_id" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Tahun Pelaksanaan <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.tahun" type="number" min="2000" :max="new Date().getFullYear() + 5" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.tahun ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.tahun" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.penelitian.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <PencilSquareIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Menyimpan...' : 'Perbarui Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>