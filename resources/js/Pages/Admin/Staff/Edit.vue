<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeft, Save, Plus, Trash2, Image as ImageIcon } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    staff: Object
});

const form = useForm({
    name: props.staff.name || '',
    nip: props.staff.nip || '',
    type: props.staff.type || 'Dosen',
    structural_position: props.staff.structural_position || '',
    functional_position: props.staff.functional_position || '',
    image_url: props.staff.image_url || '',
    is_active: props.staff.is_active,
    
    // Pastikan data JSON dikonversi menjadi Array kosong jika null
    education_history: props.staff.education_history || [],
    expertise: props.staff.expertise || [],
    competency_certification: props.staff.competency_certification || [],
    research_history: props.staff.research_history || [],
    community_service_history: props.staff.community_service_history || [],
    work_experience: props.staff.work_experience || [],
    awards: props.staff.awards || [],
    academic_profiles: props.staff.academic_profiles || [],
});

// Fitur Tambah/Hapus Dinamis untuk Array JSON
const addArrayItem = (field) => { form[field].push(''); };
const removeArrayItem = (field, index) => { form[field].splice(index, 1); };

// Live Preview URL GDrive Admin
const imagePreview = computed(() => {
    const url = form.image_url;
    if (!url) return '/images/default-avatar.png';
    if (url.includes('drive.google.com')) {
        const match = url.match(/\/d\/([a-zA-Z0-9_-]+)/);
        if (match && match[1]) return `https://lh3.googleusercontent.com/d/${match[1]}`;
    }
    return url;
});

const submit = () => {
    form.put(route('admin.staff.update', props.staff.id));
};
</script>

<template>
    <AdminLayout>
        <Head title="Edit Civitas" />

        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Link :href="route('admin.staff.index')" class="p-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <ArrowLeft class="w-5 h-5 text-gray-600" />
                </Link>
                <h2 class="text-2xl font-bold text-gray-800">Edit Data: {{ staff.name }}</h2>
            </div>
            <button @click="submit" :disabled="form.processing" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50 shadow-sm">
                <Save class="w-5 h-5 mr-2" /> {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
            </button>
        </div>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">NIP / NIPH / NIDN</label>
                            <input v-model="form.nip" type="text" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Civitas <span class="text-red-500">*</span></label>
                            <select v-model="form.type" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-semibold text-blue-700">
                                <option value="Dosen">Dosen</option>
                                <option value="Tendik">Tenaga Kependidikan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan Struktural (Cth: Dekan, Koordinator)</label>
                            <input v-model="form.structural_position" type="text" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan Fungsional (Cth: Dosen Informatika)</label>
                            <input v-model="form.functional_position" type="text" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Riwayat Pendidikan</h3>
                        <button type="button" @click="addArrayItem('education_history')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.education_history" :key="index" class="flex gap-2">
                            <input v-model="form.education_history[index]" type="text" placeholder="Contoh: S1 Teknik Elektro Universitas Brawijaya" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="button" @click="removeArrayItem('education_history', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100"><Trash2 class="w-5 h-5"/></button>
                        </div>
                        <p v-if="form.education_history.length === 0" class="text-sm text-gray-400 italic">Belum ada riwayat pendidikan ditambahkan.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Bidang Keahlian</h3>
                        <button type="button" @click="addArrayItem('expertise')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.expertise" :key="index" class="flex gap-2">
                            <input v-model="form.expertise[index]" type="text" placeholder="Contoh: Artificial Intelligence" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="button" @click="removeArrayItem('expertise', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100"><Trash2 class="w-5 h-5"/></button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Riwayat Penelitian</h3>
                        <button type="button" @click="addArrayItem('research_history')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.research_history" :key="index" class="flex gap-2">
                            <textarea v-model="form.research_history[index]" rows="2" placeholder="Judul Penelitian (Tahun)" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            <button type="button" @click="removeArrayItem('research_history', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 h-max"><Trash2 class="w-5 h-5"/></button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Link Profil Akademik</h3>
                        <button type="button" @click="addArrayItem('academic_profiles')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.academic_profiles" :key="index" class="flex gap-2">
                            <input v-model="form.academic_profiles[index]" type="url" placeholder="Contoh: Link LinkedIn, Google Scholar, dll" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="button" @click="removeArrayItem('academic_profiles', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100"><Trash2 class="w-5 h-5"/></button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Status Visibilitas</h3>
                    <label class="flex items-center cursor-pointer p-3 border rounded-lg hover:bg-gray-50 transition-colors" :class="form.is_active ? 'border-green-300 bg-green-50/30' : 'border-gray-200'">
                        <div class="relative">
                            <input type="checkbox" v-model="form.is_active" class="sr-only">
                            <div class="block bg-gray-200 w-10 h-6 rounded-full transition-colors" :class="{'bg-green-500': form.is_active}"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform" :class="{'transform translate-x-4': form.is_active}"></div>
                        </div>
                        <div class="ml-3 font-semibold text-sm" :class="form.is_active ? 'text-green-700' : 'text-gray-500'">
                            {{ form.is_active ? 'Aktif (Ditampilkan)' : 'Nonaktif (Disembunyikan)' }}
                        </div>
                    </label>
                    <p class="text-xs text-gray-500 mt-3">Matikan toggle ini jika dosen/tendik sedang cuti atau keluar, tanpa harus menghapus datanya.</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Foto Profil (Google Drive)</h3>
                    
                    <div class="w-48 h-64 mx-auto mb-6 bg-gray-100 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 flex flex-col items-center justify-center relative">
                        <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover relative z-10" alt="Preview Foto">
                        <div v-else class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                            <ImageIcon class="w-10 h-10 mb-2 opacity-50" />
                            <span class="text-xs font-semibold">Belum ada foto</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Link Share Google Drive</label>
                        <textarea v-model="form.image_url" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm font-mono bg-gray-50" placeholder="https://drive.google.com/file/d/...."></textarea>
                        <p class="text-xs text-amber-600 mt-2 bg-amber-50 p-2 rounded-md font-medium">Pastikan setelan link Drive adalah <b>"Siapa saja yang memiliki link (Anyone with the link)"</b>.</p>
                    </div>
                </div>
            </div>

        </form>
    </AdminLayout>
</template>