<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, UserPlusIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) {
        form.setError('name', 'Kolom nama wajib diisi.');
        hasError = true;
    } else if (!/^[a-zA-Z\s.,']+$/.test(form.name)) {
        form.setError('name', 'Format salah! Jangan gunakan angka atau simbol khusus.');
        hasError = true;
    }

    if (!form.email) {
        form.setError('email', 'Kolom email wajib diisi.');
        hasError = true;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        form.setError('email', 'Format email tidak valid.');
        hasError = true;
    }

    if (!form.password) {
        form.setError('password', 'Kolom password wajib diisi.');
        hasError = true;
    } else if (form.password.length < 8) {
        form.setError('password', 'Terlalu pendek! Minimal 8 karakter.');
        hasError = true;
    }

    if (!form.password_confirmation) {
        form.setError('password_confirmation', 'Harap konfirmasi password Anda.');
        hasError = true;
    } else if (form.password !== form.password_confirmation) {
        form.setError('password_confirmation', 'Sandi tidak cocok dengan yang di atas!');
        hasError = true;
    }

    if (hasError) return;

    form.post(route('admin.users.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Admin Baru" />
        <div class="mb-6">
            <Link :href="route('admin.users.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-100 hover:text-primary transition-colors shadow-sm w-fit">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" />
                Kembali ke Daftar
            </Link>
        </div>
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Tambah Admin Baru</h1>
            <p class="mt-1 text-gray-600">Buat akun admin baru untuk mengelola website FSTI ITK</p>
        </div>

        <div class="bg-white shadow-lg p-8 rounded-2xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input 
                            v-model="form.name" 
                            type="text" 
                            class="w-full rounded-lg py-3 transition-all duration-200"
                            :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"
                            placeholder="Contoh: Budi Santoso"
                        />
                        <InputError :message="form.errors.name" />
                        <p v-if="!form.errors.name" class="mt-1.5 text-xs text-gray-500">Hanya huruf, titik, dan koma. (Tanpa angka)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Email <span class="text-red-500">*</span></label>
                        <input 
                            v-model="form.email" 
                            type="email" 
                            class="w-full rounded-lg py-3 transition-all duration-200"
                            :class="form.errors.email ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            placeholder="contoh@fsti.itk.ac.id"
                        />
                        <InputError :message="form.errors.email" />
                        <p v-if="!form.errors.email" class="mt-1.5 text-xs text-gray-500">Gunakan email institusi aktif.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Password <span class="text-red-500">*</span></label>
                        <input 
                            v-model="form.password" 
                            type="password" 
                            class="w-full rounded-lg py-3 transition-all duration-200"
                            :class="form.errors.password ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            placeholder="Minimal 8 karakter"
                        />
                        <InputError :message="form.errors.password" />
                        <p v-if="!form.errors.password" class="mt-1.5 text-xs text-gray-500">Minimal 8 karakter untuk keamanan akun.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input 
                            v-model="form.password_confirmation" 
                            type="password" 
                            class="w-full rounded-lg py-3 transition-all duration-200"
                            :class="form.errors.password_confirmation ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            placeholder="Ulangi password"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-8 border-t border-gray-100 mt-10">
                    <Link :href="route('admin.users.index')" class="px-6 py-3 rounded-lg border border-gray-300 bg-white text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="flex items-center gap-2 px-6 py-3 rounded-lg bg-primary text-white font-bold hover:bg-primary-hover transition-colors shadow-md disabled:opacity-50"
                    >
                        <UserPlusIcon class="h-5 w-5" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Admin' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>