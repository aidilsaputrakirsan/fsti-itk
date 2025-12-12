<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    respondent_name: '',
    respondent_email: '',
    respondent_type: '',
    service_category: '',
    rating: 5,
    feedback: ''
});

const isSubmitted = ref(false);

const submit = () => {
    form.post(route('survei.store'), {
        preserveScroll: true,
        onSuccess: () => {
            isSubmitted.value = true;
            form.reset();
        }
    });
};
</script>

<template>
    <PublicLayout>
        <Head title="Survei Kepuasan" />
        <Banner
            title="SURVEI KEPUASAN"
            subtitle="SUARA ANDA MEMBANGUN KAMI"
            background-image="/images/background-banner.png"
        />

        <div class="bg-gray-50 py-12 md:py-24">
            <div class="container mx-auto px-6 lg:px-8 max-w-4xl">
                
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12" data-aos="fade-up">
                    <div v-if="isSubmitted" class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-kulim-park-bold text-[#133E87] mb-4">Terima Kasih!</h3>
                        <p class="text-gray-600 text-lg">Masukan Anda telah kami terima dan akan menjadi evaluasi berharga bagi FSTI ITK.</p>
                        <button @click="isSubmitted = false" class="mt-8 text-[#4682A9] font-inter-semibold hover:underline">Isi survei lagi</button>
                    </div>

                    <div v-else>
                        <h2 class="text-3xl font-kulim-park-bold text-[#133E87] mb-2 text-center">Formulir Kepuasan Layanan</h2>
                        <p class="text-gray-600 text-center mb-8">Mohon isi penilaian Anda terhadap layanan yang kami berikan.</p>

                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-inter-semibold text-gray-700 mb-2">Nama (Opsional)</label>
                                    <input v-model="form.respondent_name" type="text" class="w-full rounded-lg border-gray-300 focus:border-[#133E87] focus:ring focus:ring-[#133E87] focus:ring-opacity-20">
                                </div>
                                <div>
                                    <label class="block font-inter-semibold text-gray-700 mb-2">Email (Opsional)</label>
                                    <input v-model="form.respondent_email" type="email" class="w-full rounded-lg border-gray-300 focus:border-[#133E87] focus:ring focus:ring-[#133E87] focus:ring-opacity-20">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-inter-semibold text-gray-700 mb-2">Anda Adalah <span class="text-red-500">*</span></label>
                                    <select v-model="form.respondent_type" required class="w-full rounded-lg border-gray-300 focus:border-[#133E87] focus:ring focus:ring-[#133E87] focus:ring-opacity-20">
                                        <option value="" disabled>Pilih Kategori</option>
                                        <option value="Mahasiswa">Mahasiswa</option>
                                        <option value="Dosen">Dosen</option>
                                        <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                                        <option value="Alumni">Alumni</option>
                                        <option value="Mitra/Pengguna">Mitra / Pengguna Lulusan</option>
                                        <option value="Masyarakat Umum">Masyarakat Umum</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-inter-semibold text-gray-700 mb-2">Layanan yang Dinilai <span class="text-red-500">*</span></label>
                                    <select v-model="form.service_category" required class="w-full rounded-lg border-gray-300 focus:border-[#133E87] focus:ring focus:ring-[#133E87] focus:ring-opacity-20">
                                        <option value="" disabled>Pilih Layanan</option>
                                        <option value="Layanan Akademik">Layanan Akademik</option>
                                        <option value="Fasilitas & Sarpras">Fasilitas & Sarpras</option>
                                        <option value="Administrasi Umum">Administrasi Umum</option>
                                        <option value="Kemahasiswaan">Kemahasiswaan</option>
                                        <option value="Website & Sistem Informasi">Website & Sistem Informasi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="py-4">
                                <label class="block font-inter-semibold text-gray-700 mb-4">Kepuasan Anda (1 - 5) <span class="text-red-500">*</span></label>
                                <div class="flex justify-between items-center max-w-sm mx-auto">
                                    <label v-for="i in 5" :key="i" class="cursor-pointer text-center group">
                                        <input type="radio" v-model="form.rating" :value="i" class="hidden">
                                        <div 
                                            class="w-12 h-12 flex items-center justify-center rounded-full border-2 transition-all duration-200"
                                            :class="form.rating >= i ? 'bg-[#133E87] border-[#133E87] text-white' : 'border-gray-300 text-gray-400 group-hover:border-[#4682A9]'"
                                        >
                                            <span class="text-xl font-bold">{{ i }}</span>
                                        </div>
                                        <span class="text-xs mt-2 block text-gray-500" v-if="i===1">Buruk</span>
                                        <span class="text-xs mt-2 block text-gray-500" v-if="i===5">Sangat Puas</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block font-inter-semibold text-gray-700 mb-2">Kritik & Saran <span class="text-red-500">*</span></label>
                                <textarea v-model="form.feedback" required rows="4" class="w-full rounded-lg border-gray-300 focus:border-[#133E87] focus:ring focus:ring-[#133E87] focus:ring-opacity-20" placeholder="Tuliskan detail masukan Anda..."></textarea>
                            </div>

                            <div class="mt-8">
                                <button 
                                    type="submit" 
                                    :disabled="form.processing"
                                    class="w-full bg-[#133E87] text-white font-inter-bold py-4 rounded-xl shadow-lg hover:bg-[#0e2a5c] transition-colors disabled:opacity-50"
                                >
                                    {{ form.processing ? 'MENGIRIM...' : 'KIRIM SURVEI' }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Kulim+Park:wght@700&display=swap');

.font-kulim-park-bold { font-family: 'Kulim Park', sans-serif; font-weight: 700; }
.font-inter-semibold { font-family: 'Inter', sans-serif; font-weight: 600; }
.font-inter-bold { font-family: 'Inter', sans-serif; font-weight: 700; }
</style>
