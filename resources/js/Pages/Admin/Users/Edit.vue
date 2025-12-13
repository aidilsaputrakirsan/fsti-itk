<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
        is_superadmin: boolean;
    };
}>();

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.users.update', props.user.id), {
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div>
        <div class="mb-8">
            <Link :href="route('admin.users.index')" class="inline-flex items-center gap-2 text-[#4682A9] hover:opacity-80 mb-4">
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-black">Edit Akun Admin</h1>
            <p class="mt-1 text-black">Perbarui informasi akun atau reset password</p>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg max-w-3xl">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Nama Lengkap *</label>
                    <input 
                        v-model="form.name" 
                        type="text" 
                        required 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-black mb-2">Email *</label>
                    <input 
                        v-model="form.email" 
                        type="email" 
                        required 
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                    />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>

                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password (Optional)</h3>
                    <p class="text-sm text-gray-500 mb-4">Isi form di bawah ini HANYA jika ingin mengganti password akun ini.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-black mb-2">Password Baru</label>
                            <input 
                                v-model="form.password" 
                                type="password" 
                                minlength="8"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                placeholder="Biarkan kosong jika tetap"
                            />
                            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-black mb-2">Konfirmasi Password Baru</label>
                            <input 
                                v-model="form.password_confirmation" 
                                type="password" 
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                placeholder="Ulangi password baru"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t">
                    <Link :href="route('admin.users.index')" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">
                        Batal
                    </Link>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-6 py-2 rounded-lg bg-[#4682A9] text-white font-semibold hover:bg-opacity-90 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Perbarui Akun' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
