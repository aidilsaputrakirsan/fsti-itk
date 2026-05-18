<script setup>
import { ref, watch, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { 
    MapPinIcon, 
    ChatBubbleLeftRightIcon, 
    ShareIcon, 
    PaperAirplaneIcon,
    CheckCircleIcon
} from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });
const props = defineProps({ contact: Object });

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

const activeTab = ref('lokasi');

const tabs = [
    { id: 'lokasi', name: 'Lokasi & Waktu', icon: MapPinIcon },
    { id: 'komunikasi', name: 'Layanan Komunikasi', icon: ChatBubbleLeftRightIcon },
    { id: 'sosmed', name: 'Media Sosial', icon: ShareIcon },
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
    form.clearErrors();
    let firstErrorTab = null;

    if (!form.address) {
        form.setError('address', 'Alamat lengkap wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'lokasi';
    }
    if (!form.operating_hours) {
        form.setError('operating_hours', 'Jam operasional wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'lokasi';
    }

    if (!form.email) {
        form.setError('email', 'Email resmi fakultas wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        form.setError('email', 'Format email tidak valid.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    }

    const urlPattern = /^https?:\/\/.+/;

    if (!form.academic_wa_number) {
        form.setError('academic_wa_number', 'Teks nomor WA Akademik wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    } else if (form.academic_wa_number.replace(/[^0-9]/g, '').length < 5) {
        form.setError('academic_wa_number', 'Nomor WA Akademik minimal 5 angka.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    }

    if (!form.academic_wa_link) {
        form.setError('academic_wa_link', 'Tautan WA Akademik wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    } else if (!urlPattern.test(form.academic_wa_link)) {
        form.setError('academic_wa_link', 'Tautan harus diawali dengan http:// atau https://');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    }

    if (!form.finance_wa_number) {
        form.setError('finance_wa_number', 'Teks nomor WA Keuangan wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    } else if (form.finance_wa_number.replace(/[^0-9]/g, '').length < 5) {
        form.setError('finance_wa_number', 'Nomor WA Keuangan minimal 5 angka.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    }

    if (!form.finance_wa_link) {
        form.setError('finance_wa_link', 'Tautan WA Keuangan wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    } else if (!urlPattern.test(form.finance_wa_link)) {
        form.setError('finance_wa_link', 'Tautan harus diawali dengan http:// atau https://');
        if (!firstErrorTab) firstErrorTab = 'komunikasi';
    }

    if (!form.instagram_username) {
        form.setError('instagram_username', 'Username Instagram wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'sosmed';
    }
    if (!form.instagram_link) {
        form.setError('instagram_link', 'Tautan Profil Instagram wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'sosmed';
    } else if (!urlPattern.test(form.instagram_link)) {
        form.setError('instagram_link', 'Tautan harus diawali dengan http:// atau https://');
        if (!firstErrorTab) firstErrorTab = 'sosmed';
    }

    if (!form.tiktok_username) {
        form.setError('tiktok_username', 'Username TikTok wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'sosmed';
    }
    if (!form.tiktok_link) {
        form.setError('tiktok_link', 'Tautan Profil TikTok wajib diisi.');
        if (!firstErrorTab) firstErrorTab = 'sosmed';
    } else if (!urlPattern.test(form.tiktok_link)) {
        form.setError('tiktok_link', 'Tautan harus diawali dengan http:// atau https://');
        if (!firstErrorTab) firstErrorTab = 'sosmed';
    }

    if (firstErrorTab) {
        activeTab.value = firstErrorTab;
        return;
    }

    form.transform((data) => ({
        ...data,
        active_tab: activeTab.value
    })).put(route('admin.contacts.update'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            notificationMessage.value = page.props.flash?.success || 'Informasi kontak berhasil diperbarui.';
            showNotification.value = true;
            setTimeout(() => { showNotification.value = false; }, 3000);
        }
    });
};
</script>

<template>
  <Head title="Kelola Kontak Fakultas" />
  <div>
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pengaturan Kontak Publik</h1>
            <p class="mt-2 text-gray-600">Kelola informasi alamat, layanan chat, dan media sosial untuk halaman publik.</p>
        </div>
    </div>

    <div class="mb-6 border-b border-gray-200 bg-white px-4 pt-2 rounded-t-2xl shadow-sm">
        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
            <button 
                v-for="tab in tabs" 
                :key="tab.id" 
                @click="activeTab = tab.id" 
                type="button"
                :class="[
                    activeTab === tab.id
                        ? 'border-primary text-primary'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                    'group inline-flex items-center gap-2 py-4 px-1 border-b-2 font-bold text-sm whitespace-nowrap transition-colors'
                ]"
            >
                <component 
                    :is="tab.icon" 
                    :class="[
                        activeTab === tab.id ? 'text-primary' : 'text-gray-400 group-hover:text-gray-500',
                        'h-5 w-5 transition-colors'
                    ]" 
                />
                {{ tab.name }}
            </button>
        </nav>
    </div>

    <div class="w-full">
        <form @submit.prevent="submit" novalidate class="bg-white shadow-sm border border-gray-100 rounded-b-2xl rounded-tr-2xl flex flex-col min-h-[450px]">
            <div class="p-6 md:p-8 flex-grow">
                
                <div v-show="activeTab === 'lokasi'" class="animate-fade-in">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Lokasi & Jam Operasional</h2>
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <label class="block text-sm font-bold text-gray-800 mb-2">Alamat Lengkap Fakultas <span class="text-red-500">*</span></label>
                            <textarea 
                                v-model="form.address" 
                                rows="3" 
                                class="w-full rounded-xl py-3 transition-all duration-200 shadow-sm"
                                :class="form.errors.address ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                placeholder="Cth: Kampus ITK Gedung B, Lantai 1..."
                            ></textarea>
                            <InputError :message="form.errors.address" />
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <label class="block text-sm font-bold text-gray-800 mb-2">Jam Operasional Pelayanan <span class="text-red-500">*</span></label>
                                <textarea 
                                    v-model="form.operating_hours" 
                                    rows="3"
                                    placeholder="Cth: Senin - Kamis: 07:30 - 16:00 WITA&#10;Jumat: 07:30 - 16:30 WITA" 
                                    class="w-full rounded-xl py-3 transition-all duration-200 shadow-sm"
                                    :class="form.errors.operating_hours ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                ></textarea>
                                <InputError :message="form.errors.operating_hours" />
                            </div>
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                <label class="block text-sm font-bold text-gray-800 mb-2">Tautan Sematan Peta (Google Maps)</label>
                                <input 
                                    type="text" 
                                    v-model="form.google_maps_iframe" 
                                    placeholder="Cth: http://googleusercontent.com/maps..." 
                                    class="w-full rounded-xl py-3 transition-all duration-200 shadow-sm"
                                    :class="form.errors.google_maps_iframe ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                />
                                <InputError :message="form.errors.google_maps_iframe" />
                                <p class="text-xs text-gray-500 mt-2 font-medium">Panduan: Salin URL dari atribut di dalam <code class="bg-blue-50 text-primary px-1.5 py-0.5 rounded">src="..."</code> pada sematan peta.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="activeTab === 'komunikasi'" class="animate-fade-in">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Saluran Komunikasi Mahasiswa</h2>
                    <div class="space-y-8">
                        
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <label class="block text-sm font-bold text-gray-800 mb-2">Email Resmi Fakultas <span class="text-red-500">*</span></label>
                            <input 
                                type="email" 
                                v-model="form.email" 
                                placeholder="Cth: fsti@itk.ac.id" 
                                class="w-full md:w-1/2 rounded-xl py-3 transition-all duration-200 shadow-sm"
                                :class="form.errors.email ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                            />
                            <InputError :message="form.errors.email" />
                            <p class="text-xs text-gray-500 mt-2">Email ini akan digunakan sebagai tombol langsung ("Mailto") pada halaman publik.</p>
                        </div>

                        <hr class="border-gray-200" />
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-5">
                                <h3 class="font-bold text-primary flex items-center gap-2 border-b border-gray-200 pb-3"><ChatBubbleLeftRightIcon class="w-6 h-6"/> Layanan Akademik</h3>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Teks Ditampilkan (Cth: Nomor WA) <span class="text-red-500">*</span></label>
                                    <input 
                                        type="text" 
                                        v-model="form.academic_wa_number" 
                                        @input="form.academic_wa_number = form.academic_wa_number.replace(/[^0-9-]/g, '')"
                                        placeholder="Cth: 0851-7230-2157" 
                                        class="w-full rounded-xl py-2.5 transition-all duration-200 text-sm shadow-sm"
                                        :class="form.errors.academic_wa_number ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                    />
                                    <InputError :message="form.errors.academic_wa_number" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tautan Aksi (URL wa.me) <span class="text-red-500">*</span></label>
                                    <input 
                                        type="url" 
                                        v-model="form.academic_wa_link" 
                                        placeholder="Cth: https://wa.me/62851..." 
                                        class="w-full rounded-xl py-2.5 transition-all duration-200 text-sm shadow-sm"
                                        :class="form.errors.academic_wa_link ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                    />
                                    <InputError :message="form.errors.academic_wa_link" />
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-5">
                                <h3 class="font-bold text-primary flex items-center gap-2 border-b border-gray-200 pb-3"><ChatBubbleLeftRightIcon class="w-6 h-6"/> Layanan Keuangan</h3>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Teks Ditampilkan (Cth: Nomor WA) <span class="text-red-500">*</span></label>
                                    <input 
                                        type="text" 
                                        v-model="form.finance_wa_number" 
                                        @input="form.finance_wa_number = form.finance_wa_number.replace(/[^0-9-]/g, '')"
                                        placeholder="Cth: 0851-7231-2157" 
                                        class="w-full rounded-xl py-2.5 transition-all duration-200 text-sm shadow-sm"
                                        :class="form.errors.finance_wa_number ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                    />
                                    <InputError :message="form.errors.finance_wa_number" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tautan Aksi (URL wa.me) <span class="text-red-500">*</span></label>
                                    <input 
                                        type="url" 
                                        v-model="form.finance_wa_link" 
                                        placeholder="Cth: https://wa.me/62851..." 
                                        class="w-full rounded-xl py-2.5 transition-all duration-200 text-sm shadow-sm"
                                        :class="form.errors.finance_wa_link ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                    />
                                    <InputError :message="form.errors.finance_wa_link" />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div v-show="activeTab === 'sosmed'" class="animate-fade-in">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Tautan Akun Media Sosial</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-5">
                            <div class="flex items-center gap-3 border-b border-gray-200 pb-3">
                                <div class="w-10 h-10 bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-sm">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                </div>
                                <h3 class="font-bold text-gray-800">Instagram</h3>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Username (Ditampilkan) <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    v-model="form.instagram_username" 
                                    placeholder="Cth: @fsti.itk" 
                                    class="w-full rounded-xl py-2.5 transition-all duration-200 text-sm shadow-sm"
                                    :class="form.errors.instagram_username ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                />
                                <InputError :message="form.errors.instagram_username" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Tautan URL Profil <span class="text-red-500">*</span></label>
                                <input 
                                    type="url" 
                                    v-model="form.instagram_link" 
                                    placeholder="Cth: https://instagram.com/..." 
                                    class="w-full rounded-xl py-2.5 transition-all duration-200 text-sm shadow-sm"
                                    :class="form.errors.instagram_link ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                />
                                <InputError :message="form.errors.instagram_link" />
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-5">
                            <div class="flex items-center gap-3 border-b border-gray-200 pb-3">
                                <div class="w-10 h-10 bg-black rounded-xl flex items-center justify-center text-white shadow-sm">
                                    <svg class="w-5 h-5" viewBox="0 0 449.45 515.38" fill="currentColor">
                                        <path d="M382.31 103.3c-27.76-18.1-47.79-47.07-54.04-80.82-1.35-7.29-2.1-14.8-2.1-22.48h-88.6l-.15 355.09c-1.48 39.77-34.21 71.68-74.33 71.68-12.47 0-24.21-3.11-34.55-8.56-23.71-12.47-39.94-37.32-39.94-65.91 0-41.07 33.42-74.49 74.48-74.49 7.67 0 15.02 1.27 21.97 3.44V190.8c-7.2-.99-14.51-1.59-21.97-1.59C73.16 189.21 0 262.36 0 352.3c0 55.17 27.56 104 69.63 133.52 26.48 18.61 58.71 29.56 93.46 29.56 89.93 0 163.08-73.16 163.08-163.08V172.23c34.75 24.94 77.33 39.64 123.28 39.64v-88.61c-24.75 0-47.8-7.35-67.14-19.96z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-800">TikTok</h3>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Username (Ditampilkan) <span class="text-red-500">*</span></label>
                                <input 
                                    type="text" 
                                    v-model="form.tiktok_username" 
                                    placeholder="Cth: @fsti.itk" 
                                    class="w-full rounded-xl py-2.5 border-gray-300 focus:ring-primary focus:border-primary text-sm shadow-sm"
                                    :class="form.errors.tiktok_username ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                />
                                <InputError :message="form.errors.tiktok_username" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Tautan URL Profil <span class="text-red-500">*</span></label>
                                <input 
                                    type="url" 
                                    v-model="form.tiktok_link" 
                                    placeholder="Cth: https://tiktok.com/..." 
                                    class="w-full rounded-xl py-2.5 transition-all duration-200 text-sm shadow-sm"
                                    :class="form.errors.tiktok_link ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'"
                                />
                                <InputError :message="form.errors.tiktok_link" />
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex items-center justify-end shrink-0">
                <button type="submit" :disabled="form.processing" class="flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-primary text-white font-bold hover:bg-opacity-90 disabled:opacity-50 transition shadow-sm w-full sm:w-auto">
                    <PaperAirplaneIcon class="w-5 h-5" /> 
                    <span v-if="form.processing">Menyimpan...</span>
                    <span v-else>Simpan Perubahan</span>
                </button>
            </div>

        </form>
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