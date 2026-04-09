<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

interface KategoriForm {
    jenis_informasi: string;
    nama_kategori: string;
    urutan: number;
}

const form = useForm<KategoriForm>({
    jenis_informasi: '',
    nama_kategori: '',
    urutan: 0,
});

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.jenis_informasi) {
        form.setError('jenis_informasi', 'Jenis informasi wajib dipilih.');
        hasError = true;
    }

    if (!form.nama_kategori) {
        form.setError('nama_kategori', 'Nama kategori wajib diisi.');
        hasError = true;
    }

    if (hasError) return;

    form.post((route as Function)('admin.kategori-ppid.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Kategori PPID" />

        <div class="mb-8">
            <Link :href="(route as Function)('admin.kategori-ppid.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Kategori PPID</h1>
            <p class="mt-1 text-gray-600">Buat kelompok kategori baru untuk dokumen publik PPID FSTI ITK.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Jenis Informasi <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.jenis_informasi" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.jenis_informasi ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                            <option value="" disabled>-- Pilih Jenis Informasi --</option>
                            <option value="Berkala">Informasi Berkala</option>
                            <option value="Setiap Saat">Informasi Setiap Saat</option>
                            <option value="Serta Merta">Informasi Serta Merta</option>
                            <option value="Dikecualikan">Informasi Dikecualikan</option>
                        </select>
                        <p class="mt-2 text-[11px] text-gray-500 font-medium">Menentukan halaman tempat kategori ini akan ditampilkan.</p>
                        <InputError :message="form.errors.jenis_informasi" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nomor Urut Tampil</label>
                    <div>
                        <input v-model="form.urutan" type="number" placeholder="Contoh: 1" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.urutan ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                        <p class="mt-2 text-[11px] text-gray-500 font-medium">Gunakan angka (1, 2, 3) untuk mengatur urutan posisi dari atas ke bawah.</p>
                        <InputError :message="form.errors.urutan" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Kategori <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.nama_kategori" type="text" placeholder="Contoh: A. Informasi tentang Profil Fakultas..." 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.nama_kategori ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.nama_kategori" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="(route as Function)('admin.kategori-ppid.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
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