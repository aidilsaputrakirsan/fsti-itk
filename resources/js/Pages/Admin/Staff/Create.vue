<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ArrowLeft, Save, Plus, Trash2, Image as ImageIcon } from 'lucide-vue-next';
import { computed } from 'vue';

// Inisialisasi Form Kosong
const form = useForm({
    name: '',
    nip: '',
    type: 'Dosen', // Default value
    structural_position: '',
    functional_position: '',
    image_url: '',
    is_active: true, // Default aktif
    
    // Array kosong untuk menampung data dinamis JSON
    education_history: [],
    expertise: [],
    competency_certification: [],
    research_history: [],
    community_service_history: [],
    work_experience: [],
    awards: [],
    academic_profiles: [],
});

// Fitur Tambah/Hapus Dinamis untuk Array JSON
const addArrayItem = (field) => { form[field].push(''); };
const removeArrayItem = (field, index) => { form[field].splice(index, 1); };

// Live Preview URL GDrive Admin
const imagePreview = computed(() => {
    const url = form.image_url;
    if (!url) return null;
    
    if (url.includes('drive.google.com')) {
        const match = url.match(/\/d\/([a-zA-Z0-9_-]+)/);
        // Menggunakan endpoint avatar Google untuk mem-bypass blokir tag <img>
        if (match && match[1]) return `https://lh3.googleusercontent.com/d/${match[1]}`;
    }
    return url;
});

const submit = () => {
    form.post(route('admin.staff.store'));
};
</script>

<template>
    <AdminLayout>
        <Head title="Tambah Civitas" />

        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Link :href="route('admin.staff.index')" class="p-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    <ArrowLeft class="w-5 h-5 text-gray-600" />
                </Link>
                <h2 class="text-2xl font-bold text-gray-800">Tambah Civitas Baru</h2>
            </div>
            <button @click="submit" :disabled="form.processing" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50 shadow-sm">
                <Save class="w-5 h-5 mr-2" /> {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
            </button>
        </div>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" required placeholder="Contoh: Dr. Budi Santoso, S.T., M.T." class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">NIP / NIPH / NIDN</label>
                            <input v-model="form.nip" type="text" placeholder="Masukkan Nomor Induk" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Civitas <span class="text-red-500">*</span></label>
                            <select v-model="form.type" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-semibold text-blue-700">
                                <option value="Dosen">Dosen</option>
                                <option value="Tendik">Tenaga Kependidikan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan Struktural (Opsional)</label>
                            <input v-model="form.structural_position" type="text" placeholder="Cth: Dekan, Koordinator Prodi" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jabatan Fungsional (Opsional)</label>
                            <input v-model="form.functional_position" type="text" placeholder="Cth: Dosen Informatika" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Riwayat Pendidikan</h3>
                        <button type="button" @click="addArrayItem('education_history')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center transition-colors">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.education_history" :key="index" class="flex gap-2">
                            <input v-model="form.education_history[index]" type="text" placeholder="Contoh: S1 Teknik Elektro Universitas Brawijaya" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="button" @click="removeArrayItem('education_history', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors"><Trash2 class="w-5 h-5"/></button>
                        </div>
                        <p v-if="form.education_history.length === 0" class="text-sm text-gray-400 italic">Belum ada riwayat pendidikan ditambahkan.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Bidang Keahlian</h3>
                        <button type="button" @click="addArrayItem('expertise')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center transition-colors">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.expertise" :key="index" class="flex gap-2">
                            <input v-model="form.expertise[index]" type="text" placeholder="Contoh: Artificial Intelligence" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="button" @click="removeArrayItem('expertise', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors"><Trash2 class="w-5 h-5"/></button>
                        </div>
                        <p v-if="form.expertise.length === 0" class="text-sm text-gray-400 italic">Belum ada keahlian ditambahkan.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Pengalaman Kerja / Jabatan</h3>
                        <button type="button" @click="addArrayItem('work_experience')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center transition-colors">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.work_experience" :key="index" class="flex gap-2">
                            <textarea v-model="form.work_experience[index]" rows="2" placeholder="Contoh: 2020 - Sekarang : Dosen Teknik Elektro ITK" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            <button type="button" @click="removeArrayItem('work_experience', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 h-max transition-colors"><Trash2 class="w-5 h-5"/></button>
                        </div>
                        <p v-if="form.work_experience.length === 0" class="text-sm text-gray-400 italic">Belum ada pengalaman kerja ditambahkan.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Penghargaan</h3>
                        <button type="button" @click="addArrayItem('awards')" class="text-sm bg-amber-50 text-amber-600 px-3 py-1.5 rounded-md hover:bg-amber-100 font-semibold flex items-center transition-colors">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.awards" :key="index" class="flex gap-2">
                            <input v-model="form.awards[index]" type="text" placeholder="Contoh: Best Paper Award 2023" class="w-full border-amber-200 rounded-lg focus:ring-amber-500 focus:border-amber-500 text-sm bg-amber-50/20">
                            <button type="button" @click="removeArrayItem('awards', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors"><Trash2 class="w-5 h-5"/></button>
                        </div>
                        <p v-if="form.awards.length === 0" class="text-sm text-gray-400 italic">Belum ada penghargaan ditambahkan.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Riwayat Penelitian</h3>
                        <button type="button" @click="addArrayItem('research_history')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center transition-colors">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.research_history" :key="index" class="flex gap-2">
                            <textarea v-model="form.research_history[index]" rows="2" placeholder="Judul Penelitian (Tahun)" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            <button type="button" @click="removeArrayItem('research_history', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 h-max transition-colors"><Trash2 class="w-5 h-5"/></button>
                        </div>
                        <p v-if="form.research_history.length === 0" class="text-sm text-gray-400 italic">Belum ada riwayat penelitian ditambahkan.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-bold text-gray-900">Link Profil Akademik</h3>
                        <button type="button" @click="addArrayItem('academic_profiles')" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md hover:bg-blue-100 font-semibold flex items-center transition-colors">
                            <Plus class="w-4 h-4 mr-1"/> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(item, index) in form.academic_profiles" :key="index" class="flex gap-2">
                            <input v-model="form.academic_profiles[index]" type="url" placeholder="Contoh: https://linkedin.com/in/username" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="button" @click="removeArrayItem('academic_profiles', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors"><Trash2 class="w-5 h-5"/></button>
                        </div>
                        <p v-if="form.academic_profiles.length === 0" class="text-sm text-gray-400 italic">Belum ada link profil ditambahkan.</p>
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
                    <p class="text-xs text-gray-500 mt-3">Matikan toggle ini jika dosen/tendik sedang cuti atau pensiun agar tidak tampil di website publik.</p>
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