<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { 
    ArrowLeftIcon, 
    DocumentCheckIcon, 
    PaperClipIcon,
    TrashIcon,
    PlusIcon,
    LinkIcon,
    XMarkIcon
} from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    studyPrograms: any[];
    departments: string[]; 
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const isCustomPosition = ref(false);

const predefinedPositions = computed(() => {
    const basePositions = [
        'Dekan Fakultas Sains dan Teknologi Informasi',
        'Wakil Dekan Bidang Akademik dan Kemahasiswaan Fakultas Sains dan Teknologi Informasi',
        'Wakil Dekan Bidang Keuangan dan Umum Fakultas Sains dan Teknologi Informasi',
        'Kepala Subbagian Umum Fakultas Sains dan Teknologi Informasi',
        'Kepala Laboratorium Inovasi Digital',
        'Kepala Laboratorium Sistem Cerdas',
        'Kepala Laboratorium Komputasi dan Data',
        'Kepala Laboratorium Fisika Dasar',
        'Kepala Laboratorium Fisika Lanjut'
    ];

    const kajurPositions = props.departments.map(dep => `Ketua Jurusan ${dep}`);

    const koorProdiPositions = props.studyPrograms.map(prodi => `Koordinator Program Studi ${prodi.name}`);

    return [...basePositions, ...kajurPositions, ...koorProdiPositions];
});

const form = useForm({
    name: '',
    nip: '',
    type: 'Dosen',
    structural_position: '',
    functional_position: '',
    image_url: '',
    image: null as File | null,
    is_active: true,
    
    education_history: [] as string[],
    expertise: [] as string[],
    competency_certification: [] as string[],
    research_history: [] as string[],
    community_service_history: [] as string[],
    work_experience: [] as string[],
    awards: [] as string[],
    academic_profiles: [] as string[],
});

const handleStructuralChange = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    if (target.value === 'lainnya') {
        isCustomPosition.value = true;
        form.structural_position = ''; 
    }
};

const cancelCustomPosition = () => {
    isCustomPosition.value = false;
    form.structural_position = '';
};

watch(() => form.type, (newType) => {
    if (newType === 'Dosen' && !form.functional_position.startsWith('Dosen Program Studi')) {
        form.functional_position = '';
    } else if (newType === 'Tendik' && form.functional_position.startsWith('Dosen Program Studi')) {
        form.functional_position = '';
    }
});

type ArrayFields = 'education_history' | 'expertise' | 'competency_certification' | 'research_history' | 'community_service_history' | 'work_experience' | 'awards' | 'academic_profiles';

const addArrayItem = (field: ArrayFields) => { 
    form[field].push(''); 
};

const removeArrayItem = (field: ArrayFields, index: number | string) => { 
    const idx = typeof index === 'string' ? parseInt(index, 10) : index;
    form[field].splice(idx, 1); 
};

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
        form.image_url = ''; 
    } else {
        form.image = null;
    }
};

const clearImage = () => {
    form.image = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) {
        form.setError('name', 'Kolom nama wajib diisi.');
        hasError = true;
    }

    if (form.type === 'Dosen' && !form.functional_position) {
        form.setError('functional_position', 'Program studi wajib dipilih untuk tipe Dosen.');
        hasError = true;
    }

    if (form.image) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(form.image.type)) {
            form.setError('image', 'Format file harus JPG, PNG, atau WEBP.');
            hasError = true;
        } else if (form.image.size > 2 * 1024 * 1024) {
            form.setError('image', 'Ukuran file maksimal 2MB.');
            hasError = true;
        }
    }

    if (hasError) return;

    const arrayFields: ArrayFields[] = ['education_history', 'expertise', 'competency_certification', 'research_history', 'community_service_history', 'work_experience', 'awards', 'academic_profiles'];
    arrayFields.forEach(field => {
        form[field] = form[field].filter(item => item && item.trim() !== '');
    });

    form.post(route('admin.staff.store'));
};
</script>

<template>
    <div>
        <Head title="Tambah Civitas" />
        <div class="mb-8">
            <Link :href="route('admin.staff.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" />
                Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Civitas</h1>
            <p class="mt-1 text-gray-600">Tambahkan data dosen atau tenaga kependidikan baru.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-2 text-sm font-bold text-gray-800">Nama Lengkap & Gelar <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.name" type="text" placeholder="Contoh: Dr. Budi Santoso, S.T., M.T." 
                            class="block w-full rounded-lg transition-colors"
                            :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.name" />
                        <p v-if="!form.errors.name" class="mt-1.5 text-xs text-gray-500 font-medium">Wajib diisi. Tuliskan nama lengkap beserta gelar akademik.</p>
                    </div>
                    
                    <label class="md:pt-2 text-sm font-bold text-gray-800">Tipe Civitas <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.type" 
                            class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white" required>
                            <option value="Dosen">Dosen</option>
                            <option value="Tendik">Tenaga Kependidikan</option>
                        </select>
                        <p class="mt-1.5 text-xs text-gray-500 font-medium">Wajib dipilih untuk mengelompokkan data di website publik.</p>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">NIP / NIPH / NIDN</label>
                    <div>
                        <input v-model="form.nip" type="text" placeholder="Masukkan Nomor Induk (Hanya Angka)" 
                            class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white">
                        <InputError :message="form.errors.nip" />
                        <p class="mt-1.5 text-xs text-gray-500">Hanya angka. Opsional, namun jika diisi tidak boleh sama dengan civitas lain.</p>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Status Visibilitas</label>
                    <div>
                        <select v-model="form.is_active" class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white">
                            <option :value="true">Aktif (Ditampilkan di Website)</option>
                            <option :value="false">Nonaktif (Disembunyikan)</option>
                        </select>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Jabatan Fungsional <span v-if="form.type==='Dosen'" class="text-red-500">*</span></label>
                    <div>
                        <select v-if="form.type === 'Dosen'" v-model="form.functional_position" 
                            class="block w-full rounded-lg transition-colors"
                            :class="form.errors.functional_position ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                            <option value="" disabled>-- Pilih Program Studi --</option>
                            <option v-for="prodi in studyPrograms" :key="prodi.id" :value="'Dosen Program Studi ' + prodi.name">
                                Dosen Program Studi {{ prodi.name }}
                            </option>
                        </select>

                        <input v-else v-model="form.functional_position" type="text" placeholder="Contoh: Tenaga Kependidikan Akademik" class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white">
                        <InputError :message="form.errors.functional_position" />
                        
                        <p v-if="!form.errors.functional_position" class="mt-1.5 text-xs font-medium" :class="form.type === 'Dosen' ? 'text-primary' : 'text-gray-500'">
                            <span v-if="form.type === 'Dosen'">Wajib memilih Prodi. Pilihan ini akan otomatis memposisikan Dosen ke dalam kelompok prodinya di UI Publik.</span>
                            <span v-else>Keterangan jabatan utama di kartu profil depan.</span>
                        </p>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Jabatan Struktural</label>
                    <div>
                        <select v-if="!isCustomPosition" v-model="form.structural_position" @change="handleStructuralChange"
                            class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white"
                            :class="form.errors.structural_position ? 'border-red-500 bg-red-50' : ''">
                            <option value="">-- Tidak Ada / Kosong --</option>
                            <option v-for="pos in predefinedPositions" :key="pos" :value="pos">{{ pos }}</option>
                            <option value="lainnya" class="font-bold text-primary">➜ Lainnya (Ketik Manual)...</option>
                        </select>

                        <div v-else class="flex gap-2">
                            <input v-model="form.structural_position" type="text" placeholder="Ketik jabatan struktural lengkap..." 
                                class="block w-full rounded-lg transition-colors border-gray-300 focus:border-primary focus:ring-primary bg-white shadow-sm"
                                :class="form.errors.structural_position ? 'border-red-500 bg-red-50' : ''" autofocus>
                            <button type="button" @click="cancelCustomPosition" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-bold shadow-sm transition-colors flex-shrink-0">
                                Batal
                            </button>
                        </div>

                        <InputError :message="form.errors.structural_position" />
                        <p class="mt-1.5 text-xs text-gray-500 font-medium">
                            <span v-if="!isCustomPosition">Opsi pimpinan prodi dan jurusan diambil dari database. Pilih "Lainnya" untuk mengetik secara manual.</span>
                            <span v-else class="text-primary font-bold">Mode Ketik Manual.</span>
                            Sistem akan otomatis menolak jika jabatan pimpinan sudah terisi orang lain.
                        </p>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Foto Diri Formal</label>
                    <div class="bg-gray-50 p-4 sm:p-5 rounded-lg border border-gray-200">
                        <p class="text-xs text-primary font-bold mb-3">Disarankan ada agar profil tidak terlihat kosong. Jika dikosongkan, sistem akan menampilkan placeholder "Foto Belum Tersedia".</p>
                        
                        <label class="block text-sm text-gray-800 mb-1 font-bold" :class="{'opacity-50': form.image_url}">Opsi 1: Upload File Gambar</label>
                        <div class="relative flex items-center w-full rounded-md border bg-white shadow-sm px-4 py-2 mb-4 transition" 
                             :class="[form.errors.image ? 'border-red-500 bg-red-50' : 'border-gray-300', form.image_url ? 'bg-gray-100' : 'hover:bg-gray-50']">
                            <PaperClipIcon :class="form.errors.image ? 'text-red-400' : 'text-gray-400'" class="h-5 w-5 flex-shrink-0" />
                            <span class="ml-3 text-sm truncate flex-1" :class="form.errors.image ? 'text-red-700' : 'text-gray-500'">
                              {{ form.image ? form.image.name : 'Klik di sini untuk memilih file gambar dari perangkat...' }}
                            </span>
                            
                            <button v-if="form.image" type="button" @click.prevent="clearImage" class="ml-2 p-1 text-red-500 hover:bg-red-50 rounded-md relative z-10 flex-shrink-0" title="Batal Pilih File">
                                <XMarkIcon class="w-5 h-5"/>
                            </button>

                            <input ref="fileInput" type="file" accept="image/*" @change="handleImageChange" 
                                class="absolute inset-0 w-full h-full opacity-0" 
                                :class="{'hidden': form.image, 'cursor-pointer': !form.image_url, 'cursor-not-allowed pointer-events-none': form.image_url}" 
                                :disabled="!!form.image_url" />
                        </div>
                        <InputError :message="form.errors.image" class="mb-4" />

                        <label class="block text-sm text-gray-800 mb-1 font-bold mt-4" :class="{'opacity-50': form.image}">Opsi 2: Link Google Drive</label>
                        <input type="url" v-model="form.image_url" :disabled="form.image !== null" placeholder="https://drive.google.com/file/d/..." 
                            class="block w-full rounded-md transition-colors text-sm disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed"
                            :class="form.errors.image_url ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50' : 'border-gray-300 focus:border-primary focus:ring-primary bg-white'">
                        <InputError :message="form.errors.image_url" />
                        <p v-if="!form.errors.image_url" class="mt-2 text-xs text-gray-500 italic">
                            Gunakan opsi ini jika foto disimpan di GDrive. 
                            <br/><span v-if="form.image" class="text-red-500 font-bold mt-1 inline-block">🔒 Opsi Link Drive dinonaktifkan karena Anda telah memilih file upload (Opsi 1).</span>
                            <span v-else-if="form.image_url" class="text-blue-500 font-bold mt-1 inline-block">🔒 Area Upload (Opsi 1) otomatis dinonaktifkan karena Anda telah memasukkan link GDrive.</span>
                        </p>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Bidang Keahlian</label>
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-3">Opsional. Bidang keahlian yang relevan dengan bidang studi dosen.</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.expertise" :key="index" class="flex gap-2 items-start">
                                <div class="w-full">
                                    <input v-model="form.expertise[index]" type="text" placeholder="Contoh: Artificial Intelligence" 
                                        class="block w-full rounded-lg transition-colors text-sm"
                                        :class="form.errors[`expertise.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                                    <InputError :message="form.errors[`expertise.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('expertise', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('expertise')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah Keahlian</button>
                        </div>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Riwayat Pendidikan Terakhir</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3">Idealnya diisi sebagai pelengkap informasi akademik (S1/S2/S3).</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.education_history" :key="index" class="flex gap-2 items-start">
                                <div class="w-full">
                                    <textarea v-model="form.education_history[index]" rows="2" placeholder="Contoh: S1 Teknik Elektro, Universitas Brawijaya" 
                                        class="block w-full rounded-lg transition-colors text-sm"
                                        :class="form.errors[`education_history.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                                    <InputError :message="form.errors[`education_history.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('education_history', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('education_history')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah Pendidikan</button>
                        </div>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Sertifikasi Kompetensi</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3">Opsional. Sertifikat profesi atau kompetensi pendukung (khususnya Tendik/Dosen praktisi).</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.competency_certification" :key="index" class="flex gap-2 items-start">
                                <div class="w-full">
                                    <textarea v-model="form.competency_certification[index]" rows="2" placeholder="Contoh: Sertifikasi Asesor Kompetensi BNSP (2022)" 
                                        class="block w-full rounded-lg transition-colors text-sm"
                                        :class="form.errors[`competency_certification.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                                    <InputError :message="form.errors[`competency_certification.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('competency_certification', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('competency_certification')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah Sertifikasi</button>
                        </div>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Riwayat Penelitian</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3">Opsional. Judul riset atau jurnal yang pernah dikerjakan dosen.</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.research_history" :key="index" class="flex gap-2 items-start">
                                <div class="w-full">
                                    <textarea v-model="form.research_history[index]" rows="2" placeholder="Contoh: Optimasi Sistem menggunakan Metode X (2021)" 
                                        class="block w-full rounded-lg transition-colors text-sm"
                                        :class="form.errors[`research_history.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                                    <InputError :message="form.errors[`research_history.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('research_history', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('research_history')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah Penelitian</button>
                        </div>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Riwayat Pengabdian Masyarakat</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3">Opsional. Judul kegiatan pengabdian kepada masyarakat (PKM).</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.community_service_history" :key="index" class="flex gap-2 items-start">
                                <div class="w-full">
                                    <textarea v-model="form.community_service_history[index]" rows="2" placeholder="Contoh: Pelatihan Komputer untuk UMKM Desa X (2022)" 
                                        class="block w-full rounded-lg transition-colors text-sm"
                                        :class="form.errors[`community_service_history.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                                    <InputError :message="form.errors[`community_service_history.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('community_service_history', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('community_service_history')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah PKM</button>
                        </div>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Pengalaman Kerja</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3">Opsional. Pengalaman profesional atau organisasi di luar ITK.</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.work_experience" :key="index" class="flex gap-2 items-start">
                                <div class="w-full">
                                    <textarea v-model="form.work_experience[index]" rows="2" placeholder="Contoh: 2018 - 2020: System Analyst di PT. XYZ" 
                                        class="block w-full rounded-lg transition-colors text-sm"
                                        :class="form.errors[`work_experience.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                                    <InputError :message="form.errors[`work_experience.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('work_experience', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('work_experience')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah Pengalaman</button>
                        </div>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Penghargaan / Awards</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3">Opsional. Prestasi atau penghargaan yang pernah diraih.</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.awards" :key="index" class="flex gap-2 items-start">
                                <div class="w-full">
                                    <textarea v-model="form.awards[index]" rows="2" placeholder="Contoh: Dosen Berprestasi ITK Tahun 2021" 
                                        class="block w-full rounded-lg transition-colors text-sm"
                                        :class="form.errors[`awards.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'"></textarea>
                                    <InputError :message="form.errors[`awards.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('awards', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('awards')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah Penghargaan</button>
                        </div>
                    </div>

                    <label class="md:pt-2 text-sm font-bold text-gray-800">Profil Akademik</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3 font-medium">Opsional. Link seperti <span class="text-blue-600 font-bold">LinkedIn</span>, <span class="text-blue-500 font-bold">Google Scholar</span>, atau atau <span class="text-orange-500 font-bold">Scopus</span>.</p>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.academic_profiles" :key="index" class="flex gap-2 items-start relative">
                                <div class="relative w-full">
                                    <LinkIcon class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" />
                                    <input v-model="form.academic_profiles[index]" type="url" placeholder="Contoh: https://scholar.google.com/..." 
                                        class="block w-full pl-10 rounded-lg transition-colors text-sm"
                                        :class="form.errors[`academic_profiles.${index}`] ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'">
                                    <InputError :message="form.errors[`academic_profiles.${index}`]" />
                                </div>
                                <button type="button" @click="removeArrayItem('academic_profiles', index)" class="p-2 sm:p-2.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0 mt-0.5"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('academic_profiles')" class="flex items-center gap-1 text-sm font-bold text-primary hover:text-primary-hover transition-colors"><PlusIcon class="w-4 h-4 stroke-2"/> Tambah Link Profil</button>
                        </div>
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.staff.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <DocumentCheckIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>