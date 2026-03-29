<script setup>
import { ref, watch, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { 
    MapPinIcon, 
    ChatBubbleLeftRightIcon, 
    ShareIcon, 
    PaperAirplaneIcon,
    InformationCircleIcon,
    CheckCircleIcon
} from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });
const props = defineProps({ contact: Object });

// --- LOGIK NOTIFIKASI PERSIS SEPERTI MODUL BERITA ---
const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => page.props.flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message;
        showNotification.value = true;
        setTimeout(() => {
            showNotification.value = false;
        }, 3000);
    }
}, { immediate: true });
// ----------------------------------------------------

// Inisialisasi Tab Aktif
const activeTab = ref('lokasi');

const tabs = [
    { id: 'lokasi', name: 'Lokasi & Waktu', icon: MapPinIcon, description: 'Alamat fisik, peta Google Maps, dan jam operasional.' },
    { id: 'komunikasi', name: 'Layanan Komunikasi', icon: ChatBubbleLeftRightIcon, description: 'Email resmi dan tautan chat WhatsApp fakultas.' },
    { id: 'sosmed', name: 'Media Sosial', icon: ShareIcon, description: 'Tautan akun Instagram dan TikTok resmi FSTI.' },
];

const form = useForm({
    address: props.contact?.address || '',
    operating_hours: props.contact?.operating_hours || '',
    google_maps_iframe: props.contact?.google_maps_iframe || '',
    academic_wa_number: props.contact?.academic_wa_number || '',
    academic_wa_link: props.contact?.academic_wa_link || '',
    finance_wa_number: props.contact?.finance_wa_number || '',
    finance_wa_link: props.contact?.finance_wa_link || '',
    email: props.contact?.email || '',
    instagram_username: props.contact?.instagram_username || '',
    instagram_link: props.contact?.instagram_link || '',
    tiktok_username: props.contact?.tiktok_username || '',
    tiktok_link: props.contact?.tiktok_link || '',
});

const submit = () => {
    form.put(route('admin.contacts.update'), {
        preserveScroll: true,
        // Ditambahkan onSuccess manual untuk menjamin Pop-Up selalu muncul meskipun kita tidak pindah halaman
        onSuccess: () => {
            notificationMessage.value = page.props.flash?.success || 'Informasi kontak berhasil diperbarui.';
            showNotification.value = true;
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        }
    });
};
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Pengaturan Kontak Publik</h1>
      <p class="mt-2 text-gray-600">Kelola informasi alamat, layanan chat, dan media sosial yang akan ditampilkan pada halaman publik website FSTI.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        <div class="w-full lg:w-1/3 xl:w-1/4 shrink-0">
            <nav class="flex flex-col space-y-2">
                <button 
                    v-for="tab in tabs" 
                    :key="tab.id"
                    @click="activeTab = tab.id"
                    type="button"
                    :class="[
                        activeTab === tab.id 
                            ? 'bg-white border-primary shadow-sm ring-1 ring-gray-100' 
                            : 'border-transparent hover:bg-gray-50 text-gray-600',
                        'border-l-4 flex items-start gap-4 text-left p-4 rounded-r-xl transition-all duration-200 w-full'
                    ]"
                >
                    <div :class="[activeTab === tab.id ? 'bg-blue-50 text-primary' : 'bg-gray-100 text-gray-500', 'p-2 rounded-lg shrink-0 transition-colors']">
                        <component :is="tab.icon" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 :class="[activeTab === tab.id ? 'text-primary' : 'text-gray-800', 'font-bold text-base']">
                            {{ tab.name }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ tab.description }}</p>
                    </div>
                </button>
            </nav>

            <div class="mt-8 bg-blue-50/50 border border-blue-100 rounded-xl p-4 flex gap-3 text-sm text-gray-600">
                <InformationCircleIcon class="w-6 h-6 text-primary shrink-0" />
                <p>Pemberitahuan: Setiap perubahan yang disimpan di sini akan langsung diperbarui secara <strong>real-time</strong> di situs publik mahasiswa.</p>
            </div>
        </div>

        <div class="w-full lg:w-2/3 xl:w-3/4">
            <form @submit.prevent="submit" class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden relative min-h-[500px] flex flex-col">
                
                <div class="p-8 md:p-10 flex-grow">
                    
                    <div v-show="activeTab === 'lokasi'" class="animate-fade-in">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Lokasi & Jam Operasional</h2>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">Alamat Lengkap Fakultas</label>
                                <textarea v-model="form.address" rows="4" class="w-full rounded-xl border-gray-300 focus:ring-primary focus:border-primary shadow-sm bg-gray-50 focus:bg-white transition-colors" placeholder="Cth: Kampus ITK Gedung B, Lantai 1..."></textarea>
                                <p v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 mb-2">Jam Operasional Pelayanan</label>
                                    <input type="text" v-model="form.operating_hours" placeholder="Cth: Senin - Jumat: 07:30 - 16:30 WITA" class="w-full rounded-xl border-gray-300 focus:ring-primary focus:border-primary shadow-sm bg-gray-50 focus:bg-white transition-colors">
                                    <p v-if="form.errors.operating_hours" class="text-red-500 text-xs mt-1">{{ form.errors.operating_hours }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-800 mb-2">Tautan Sematan Peta (Google Maps)</label>
                                    <input type="text" v-model="form.google_maps_iframe" placeholder="Cth: http://googleusercontent.com/maps..." class="w-full rounded-xl border-gray-300 focus:ring-primary focus:border-primary shadow-sm bg-gray-50 focus:bg-white transition-colors">
                                    <p class="text-xs text-gray-500 mt-2 font-medium leading-relaxed">Panduan: Salin URL dari atribut <code class="bg-blue-50 text-primary px-1.5 py-0.5 rounded">src="..."</code> pada sematan peta.</p>
                                    <p v-if="form.errors.google_maps_iframe" class="text-red-500 text-xs mt-1">{{ form.errors.google_maps_iframe }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'komunikasi'" class="animate-fade-in">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Saluran Komunikasi Mahasiswa</h2>
                        <div class="space-y-8">
                            
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <label class="block text-sm font-bold text-gray-800 mb-2">Email Resmi Fakultas</label>
                                <input type="email" v-model="form.email" placeholder="Cth: fsti@itk.ac.id" class="w-full md:w-1/2 rounded-xl border-gray-300 focus:ring-primary focus:border-primary shadow-sm transition-colors">
                                <p class="text-xs text-gray-500 mt-2">Email ini akan digunakan sebagai tombol langsung ("Mailto") pada halaman publik.</p>
                            </div>

                            <hr class="border-gray-100">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <h3 class="font-bold text-primary flex items-center gap-2"><ChatBubbleLeftRightIcon class="w-5 h-5"/> Layanan Akademik</h3>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Teks Ditampilkan (Cth: Nomor WA)</label>
                                        <input type="text" v-model="form.academic_wa_number" placeholder="Cth: 0851-7230-2157" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tautan Aksi (URL wa.me)</label>
                                        <input type="url" v-model="form.academic_wa_link" placeholder="Cth: https://wa.me/62851..." class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h3 class="font-bold text-primary flex items-center gap-2"><ChatBubbleLeftRightIcon class="w-5 h-5"/> Layanan Keuangan</h3>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Teks Ditampilkan (Cth: Nomor WA)</label>
                                        <input type="text" v-model="form.finance_wa_number" placeholder="Cth: 0851-7231-2157" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Tautan Aksi (URL wa.me)</label>
                                        <input type="url" v-model="form.finance_wa_link" placeholder="Cth: https://wa.me/62851..." class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div v-show="activeTab === 'sosmed'" class="animate-fade-in">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tautan Akun Media Sosial</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-4">
                                <div class="w-10 h-10 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-500 rounded-xl flex items-center justify-center text-white mb-2 shadow-sm">
                                    <ShareIcon class="w-5 h-5" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-1">Username Instagram</label>
                                    <input type="text" v-model="form.instagram_username" placeholder="Cth: @fsti.itk" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-1">Tautan URL Profil</label>
                                    <input type="url" v-model="form.instagram_link" placeholder="Cth: https://instagram.com/..." class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-4">
                                <div class="w-10 h-10 bg-black rounded-xl flex items-center justify-center text-white mb-2 shadow-sm">
                                    <svg class="w-5 h-5" viewBox="0 0 449.45 515.38" fill="currentColor">
                                        <path d="M382.31 103.3c-27.76-18.1-47.79-47.07-54.04-80.82-1.35-7.29-2.1-14.8-2.1-22.48h-88.6l-.15 355.09c-1.48 39.77-34.21 71.68-74.33 71.68-12.47 0-24.21-3.11-34.55-8.56-23.71-12.47-39.94-37.32-39.94-65.91 0-41.07 33.42-74.49 74.48-74.49 7.67 0 15.02 1.27 21.97 3.44V190.8c-7.2-.99-14.51-1.59-21.97-1.59C73.16 189.21 0 262.36 0 352.3c0 55.17 27.56 104 69.63 133.52 26.48 18.61 58.71 29.56 93.46 29.56 89.93 0 163.08-73.16 163.08-163.08V172.23c34.75 24.94 77.33 39.64 123.28 39.64v-88.61c-24.75 0-47.8-7.35-67.14-19.96z"/>
                                    </svg>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-1">Username TikTok</label>
                                    <input type="text" v-model="form.tiktok_username" placeholder="Cth: @fsti.itk" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 mb-1">Tautan URL Profil</label>
                                    <input type="url" v-model="form.tiktok_link" placeholder="Cth: https://tiktok.com/..." class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex items-center justify-between shrink-0">
                    <p class="text-sm text-gray-500 font-medium hidden sm:block">Pastikan semua tautan dapat diakses sebelum menyimpan perubahan.</p>
                    
                    <button type="submit" :disabled="form.processing" class="flex items-center justify-center gap-2 px-8 py-3 rounded-xl bg-primary text-white font-bold hover:bg-opacity-90 disabled:opacity-50 transition shadow-sm w-full sm:w-auto">
                        <PaperAirplaneIcon class="w-5 h-5" /> 
                        <span v-if="form.processing">Menyimpan...</span>
                        <span v-else>Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div v-if="showNotification" class="fixed top-5 right-5 z-50 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg">
            <CheckCircleIcon class="h-8 w-8" />
            <p class="font-semibold">{{ notificationMessage }}</p>
        </div>
    </div>
  </div>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-out forwards;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>