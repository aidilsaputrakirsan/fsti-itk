<script setup>
import { ref } from 'vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon, XMarkIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const fileInput = ref(null);

const form = useForm({
    name: '',
    activities_text: '',
    logo: null,
});

const handleLogoChange = (event) => {
    const target = event.target;
    if (target.files && target.files[0]) {
        form.logo = target.files[0];
    } else {
        form.logo = null;
    }
};

const clearLogo = () => {
    form.logo = null;
    if (fileInput.value) fileInput.value.value = '';
};

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) {
        form.setError('name', 'Kolom nama institusi wajib diisi.');
        hasError = true;
    }

    if (form.logo) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(form.logo.type)) {
            form.setError('logo', 'Format file harus JPG, PNG, atau WEBP.');
            hasError = true;
        } else if (form.logo.size > 2 * 1024 * 1024) {
            form.setError('logo', 'Ukuran file gambar maksimal 2MB.');
            hasError = true;
        }
    }

    if (hasError) return;
    form.post(route('admin.partners.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Data Kerjasama" />
        <div class="mb-8">
            <Link :href="route('admin.partners.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Data Kerjasama</h1>
            <p class="mt-1 text-gray-600">Masukkan institusi mitra dan bentuk kolaborasi baru.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Institusi / Mitra <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.name" type="text" placeholder="Contoh: PT Telkom Indonesia" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.name" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Upload Logo Instansi</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3 font-medium">Opsional. Direkomendasikan format PNG transparan. Maksimal 2MB.</p>
                        <div class="relative flex items-center w-full rounded-lg border bg-white shadow-sm px-4 py-3 hover:bg-gray-50 transition" :class="form.errors.logo ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                            <PaperClipIcon :class="form.errors.logo ? 'text-red-400' : 'text-gray-400'" class="h-5 w-5 flex-shrink-0" />
                            <span class="ml-3 text-sm truncate flex-1 font-medium" :class="form.errors.logo ? 'text-red-700' : 'text-gray-500'">
                                {{ form.logo ? form.logo.name : 'Pilih file logo dari perangkat...' }}
                            </span>
                            <button v-if="form.logo" type="button" @click.prevent="clearLogo" class="ml-2 p-1 text-red-500 hover:bg-red-50 rounded-md relative z-10 flex-shrink-0" title="Batal Pilih File">
                                <XMarkIcon class="w-5 h-5"/>
                            </button>
                            <input ref="fileInput" type="file" accept="image/png, image/jpeg, image/webp" @change="handleLogoChange" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :class="{'hidden': form.logo}" />
                        </div>
                        <InputError :message="form.errors.logo" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Daftar Kegiatan</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3 font-medium">Pisahkan setiap kegiatan dengan menekan tombol <strong>Enter</strong> (baris baru). Kosongkan jika hanya sebatas MoU.</p>
                        <textarea v-model="form.activities_text" rows="6" placeholder="Pendidikan&#10;Penelitian&#10;Pengabdian kepada Masyarakat"
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.activities_text ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                        ></textarea>
                        <InputError :message="form.errors.activities_text" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.partners.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
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