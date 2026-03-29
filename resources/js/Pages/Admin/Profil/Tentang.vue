<script setup>
import { ref, watch, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { 
    ChartBarIcon, DocumentTextIcon, FlagIcon, 
    PaperAirplaneIcon, CheckCircleIcon
} from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });
const props = defineProps({ tentang: Object });

// Sistem Notifikasi Toast
const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => page.props.flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message;
        showNotification.value = true;
        setTimeout(() => showNotification.value = false, 3000);
    }
}, { immediate: true });

const activeTab = ref('statistik');
const tabs = [
    { id: 'statistik', name: 'Statistik Data', icon: ChartBarIcon, desc: 'Ubah angka mahasiswa, dosen, dll.' },
    { id: 'tugas', name: 'Tugas & Fungsi', icon: DocumentTextIcon, desc: 'Edit uraian tugas pokok dan fungsi.' },
    { id: 'visi', name: 'Visi & Misi', icon: FlagIcon, desc: 'Ubah redaksi visi dan 8 misi utama.' },
];

// Form super bersih, tanpa variabel hukum
const form = useForm({
    content: props.tentang?.content || {
        statistik: { deskripsi: '', data: [] },
        tugas_fungsi: { tugas: '', fungsi: [] },
        visi_misi: { visi: '', misi_tagline: '', misi: [] }
    }
});

const submit = () => {
    form.put(route('admin.tentang.update'), {
        preserveScroll: true, 
        preserveState: false,
        onSuccess: () => {
            notificationMessage.value = page.props.flash?.success || 'Berhasil disimpan!';
            showNotification.value = true;
            setTimeout(() => showNotification.value = false, 3000);
        }
    });
};
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Kelola Tentang Fakultas</h1>
      <p class="mt-2 text-gray-600">Perbarui redaksi data statistik, fungsi, dan visi misi yang tampil pada halaman publik.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <div class="w-full lg:w-1/4 shrink-0">
            <nav class="flex flex-col space-y-2">
                <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id" type="button"
                    :class="[activeTab === tab.id ? 'bg-white border-primary shadow-sm ring-1 ring-gray-100' : 'border-transparent hover:bg-gray-50', 'border-l-4 flex items-start gap-4 text-left p-4 rounded-r-xl transition-all w-full']">
                    <div :class="[activeTab === tab.id ? 'bg-blue-50 text-primary' : 'bg-gray-100 text-gray-500', 'p-2 rounded-lg']">
                        <component :is="tab.icon" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 :class="[activeTab === tab.id ? 'text-primary' : 'text-gray-800', 'font-bold text-base']">{{ tab.name }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ tab.desc }}</p>
                    </div>
                </button>
            </nav>
        </div>

        <div class="w-full lg:w-3/4">
            <form @submit.prevent="submit" class="bg-white shadow-sm border border-gray-100 rounded-2xl flex flex-col min-h-[500px]">
                <div class="p-8 flex-grow">
                    
                    <div v-show="activeTab === 'statistik'">
                        <h2 class="text-2xl font-bold mb-6">Statistik Fakultas</h2>
                        <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="block text-sm font-bold mb-2">Deskripsi Singkat Halaman</label>
                            <input type="text" v-model="form.content.statistik.deskripsi" class="w-full rounded-xl border-gray-300 focus:ring-primary focus:border-primary shadow-sm">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div v-for="(stat, index) in form.content.statistik.data" :key="index" class="bg-white p-4 border border-gray-200 rounded-xl shadow-sm">
                                <label class="text-xs font-bold text-primary mb-2 block uppercase tracking-wider">Kotak Data {{ index + 1 }}</label>
                                <div class="flex gap-3">
                                    <div class="w-1/3">
                                        <input type="text" v-model="stat.angka" class="w-full text-lg font-bold rounded-lg border-gray-300" placeholder="Angka">
                                    </div>
                                    <div class="w-full">
                                        <input type="text" v-model="stat.label" class="w-full rounded-lg border-gray-300" placeholder="Label">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'tugas'">
                        <h2 class="text-2xl font-bold mb-6">Tugas & Fungsi</h2>
                        <div class="space-y-6">
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <label class="block text-sm font-bold mb-2">Tugas Fakultas (Paragraf)</label>
                                <textarea v-model="form.content.tugas_fungsi.tugas" rows="4" class="w-full rounded-xl border-gray-300 focus:ring-primary shadow-sm"></textarea>
                            </div>

                            <hr class="border-gray-100">

                            <div class="space-y-4">
                                <h3 class="font-bold text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-200">Daftar Fungsi Fakultas</h3>
                                <div v-for="(func, index) in form.content.tugas_fungsi.fungsi" :key="index" class="bg-white p-4 border border-gray-200 rounded-xl shadow-sm flex gap-4 items-start">
                                    <div class="shrink-0 w-8 h-8 flex items-center justify-center bg-blue-50 text-primary font-bold rounded-lg">{{ index + 1 }}</div>
                                    <div class="w-full space-y-3">
                                        <input type="text" v-model="func.judul" placeholder="Judul Fungsi" class="w-full font-bold rounded-lg border-gray-300">
                                        <textarea v-model="func.deskripsi" rows="2" placeholder="Deskripsi lengkap..." class="w-full text-sm rounded-lg border-gray-300"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-show="activeTab === 'visi'">
                        <h2 class="text-2xl font-bold mb-6">Visi & Misi (PRESTASI)</h2>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold mb-2">Teks Visi Fakultas</label>
                                <textarea v-model="form.content.visi_misi.visi" rows="4" class="w-full rounded-xl border-gray-300 font-medium text-lg leading-relaxed shadow-sm"></textarea>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <div class="mb-4">
                                    <label class="block text-sm font-bold">Misi Tagline / Akronim</label>
                                    <input type="text" v-model="form.content.visi_misi.misi_tagline" class="mt-1 text-sm rounded-lg border-gray-300 w-64">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="(m, index) in form.content.visi_misi.misi" :key="index" class="flex gap-3 bg-white p-3 border border-gray-200 rounded-xl shadow-sm">
                                        <input type="text" v-model="m.huruf" class="w-16 font-bold text-center rounded-lg border-gray-300 uppercase bg-blue-50 text-primary">
                                        <input type="text" v-model="m.teks" class="w-full rounded-lg border-gray-300 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex items-center justify-end shrink-0">
                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 px-8 py-3 rounded-xl bg-primary text-white font-bold hover:bg-opacity-90 transition shadow-sm w-full sm:w-auto">
                        <PaperAirplaneIcon class="w-5 h-5" /> <span>Simpan Perubahan</span>
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