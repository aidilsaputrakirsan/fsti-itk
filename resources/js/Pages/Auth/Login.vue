<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { Mail, Lock, LogIn, ArrowRight, ShieldCheck, Eye, EyeOff } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false, // Nilai default untuk "Ingat Saya"
});

// State untuk fitur lihat password
const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in Admin - FSTI ITK" />

    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-4 sm:p-6 lg:p-8 font-inter relative overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-indigo-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-emerald-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse" style="animation-delay: 4s;"></div>

        <div class="max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row relative z-10 border border-slate-100">
            
            <div class="md:w-5/12 bg-gradient-to-br from-[#2F4DD3] to-indigo-900 p-10 lg:p-12 text-white flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -bottom-24 -right-24 w-64 h-64 border-[30px] border-white/10 rounded-full"></div>
                <div class="absolute -top-12 -left-12 w-32 h-32 border-[15px] border-white/10 rounded-full"></div>

                <div class="relative z-10">
                    <Link href="/">
                        <img src="/images/logofsti.png" alt="Logo FSTI ITK" class="h-16 w-auto bg-white p-2 rounded-xl shadow-md mb-8 transition-transform hover:scale-105" />
                    </Link>
                    <h1 class="text-3xl lg:text-4xl font-bold font-kulim-park leading-tight mb-4">
                        Panel Admin <br/>
                        <span class="text-blue-200">FSTI ITK</span>
                    </h1>
                    <p class="text-blue-100 text-sm lg:text-base leading-relaxed">
                        Sistem pengelolaan konten dan informasi website Fakultas Sains dan Teknologi Informasi.
                    </p>
                </div>

                <div class="relative z-10 mt-12">
                    <div class="flex items-start gap-3 text-sm text-blue-200 bg-white/10 p-4 rounded-2xl backdrop-blur-sm border border-white/10 shadow-inner">
                        <ShieldCheck class="w-6 h-6 text-emerald-300 flex-shrink-0 mt-0.5" />
                        <p>Hanya staf yang memiliki hak akses yang diizinkan untuk masuk ke panel ini.</p>
                    </div>
                </div>
            </div>

            <div class="md:w-7/12 p-10 lg:p-16 flex flex-col justify-center bg-white">
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900">Login Administrator</h2>
                    <p class="text-sm text-gray-500 mt-2">Masukkan email dan kata sandi Anda untuk masuk.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div v-if="status" class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm font-medium border border-emerald-100 flex items-center gap-2">
                        {{ status }}
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <Mail class="h-5 w-5 text-gray-400" />
                            </div>
                            <input 
                                id="email" 
                                type="email" 
                                v-model="form.email" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-[#2F4DD3] focus:border-[#2F4DD3] transition-all outline-none" 
                                placeholder="Masukkan alamat email Anda yang terdaftar" 
                                required 
                                autofocus 
                                autocomplete="username" 
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <Lock class="h-5 w-5 text-gray-400" />
                            </div>
                            <input 
                                id="password" 
                                :type="showPassword ? 'text' : 'password'" 
                                v-model="form.password" 
                                class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-[#2F4DD3] focus:border-[#2F4DD3] transition-all outline-none" 
                                placeholder="Masukkan kata sandi Anda" 
                                required 
                                autocomplete="current-password" 
                            />
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#2F4DD3] focus:outline-none transition-colors"
                            >
                                <Eye v-if="!showPassword" class="h-5 w-5" />
                                <EyeOff v-else class="h-5 w-5" />
                            </button>
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                   <label class="flex items-center">
    <input 
        type="checkbox" 
        name="remember" 
        v-model="form.remember" 
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
    />
    <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
</label>

                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-bold text-white bg-[#2F4DD3] hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2F4DD3] transition-all disabled:opacity-50 disabled:cursor-not-allowed mt-2" 
                        :disabled="form.processing"
                    >
                        <LogIn v-if="!form.processing" class="w-5 h-5" />
                        <svg v-else class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        {{ form.processing ? 'Sedang Masuk...' : 'Masuk ke Dashboard' }}
                    </button>
                </form>

                <div class="mt-10 text-center text-xs text-gray-400">
                    <p>&copy; {{ new Date().getFullYear() }} Fakultas Sains dan Teknologi Informasi.</p>
                    <Link href="/" class="mt-2 inline-flex items-center gap-1 font-medium hover:text-[#2F4DD3] transition-colors">
                        <ArrowRight class="w-3 h-3" /> Kembali ke Halaman Publik
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>