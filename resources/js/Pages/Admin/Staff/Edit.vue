<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    ArrowLeftIcon, 
    PaperClipIcon,
    TrashIcon,
    PlusIcon,
    PencilSquareIcon
} from '@heroicons/vue/24/outline';
import { computed } from 'vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    staff: any;
}>();

// 1. Definisikan Interface eksplisit untuk mencegah TS kebingungan (excessively deep)
interface StaffFormData {
    _method: string;
    name: string;
    nip: string;
    type: string;
    structural_position: string;
    functional_position: string;
    image_url: string;
    image: File | null;
    is_active: boolean;
    education_history: string[];
    expertise: string[];
    competency_certification: string[];
    research_history: string[];
    community_service_history: string[];
    work_experience: string[];
    awards: string[];
    academic_profiles: string[];
}

// 2. Sematkan tipe <StaffFormData> ke useForm
const form = useForm<StaffFormData>({
    _method: 'PUT',
    name: props.staff.name || '',
    nip: props.staff.nip || '',
    type: props.staff.type || 'Dosen',
    structural_position: props.staff.structural_position || '',
    functional_position: props.staff.functional_position || '',
    image_url: props.staff.image_url || '',
    image: null,
    is_active: Boolean(props.staff.is_active ?? true),
    
    // Hilangkan casting "as string[]" karena TS sudah tahu tipenya dari Interface
    education_history: props.staff.education_history || [],
    expertise: props.staff.expertise || [],
    competency_certification: props.staff.competency_certification || [],
    research_history: props.staff.research_history || [],
    community_service_history: props.staff.community_service_history || [],
    work_experience: props.staff.work_experience || [],
    awards: props.staff.awards || [],
    academic_profiles: props.staff.academic_profiles || [],
});

type ArrayFields = 'education_history' | 'expertise' | 'competency_certification' | 'research_history' | 'community_service_history' | 'work_experience' | 'awards' | 'academic_profiles';

const addArrayItem = (field: ArrayFields) => { 
    form[field].push(''); 
};

const removeArrayItem = (field: ArrayFields, index: number | string) => { 
    const idx = typeof index === 'string' ? parseInt(index, 10) : index;
    form[field].splice(idx, 1); 
};

const fileNameDisplay = computed(() => {
    if (form.image instanceof File) {
        return form.image.name;
    }
    return 'Pilih file gambar baru jika ingin mengganti...';
});

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
    } else {
        form.image = null;
    }
};

const submit = () => {
    form.post(route('admin.staff.update', props.staff.id));
};
</script>

<template>
    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-black">Edit Civitas</h1>
            <p class="mt-1 text-black">Perbarui profil {{ staff.name }}</p>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-x-8 gap-y-8">
                    
                    <label class="pt-2 text-sm font-semibold text-black">Nama Lengkap & Gelar *</label>
                    <div>
                        <input v-model="form.name" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
                    </div>
                    
                    <label class="pt-2 text-sm font-semibold text-black">NIP / NIPH / NIDN</label>
                    <div>
                        <input v-model="form.nip" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Tipe Civitas *</label>
                    <div>
                        <select v-model="form.type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="Dosen">Dosen</option>
                            <option value="Tendik">Tenaga Kependidikan</option>
                        </select>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Status Visibilitas</label>
                    <div>
                        <select v-model="form.is_active" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option :value="true">Aktif (Ditampilkan)</option>
                            <option :value="false">Nonaktif (Disembunyikan / Cuti)</option>
                        </select>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Jabatan Struktural</label>
                    <div>
                        <input v-model="form.structural_position" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Jabatan Fungsional</label>
                    <div>
                        <input v-model="form.functional_position" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Foto Profil</label>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="mb-4" v-if="staff.display_image">
                            <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                            <img :src="staff.display_image" alt="Profil Staff" class="h-32 w-32 object-cover rounded-lg border border-gray-300">
                        </div>

                        <label class="block text-sm text-gray-700 mb-1 font-medium">Opsi 1: Upload File Gambar Baru</label>
                        <div class="relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2 mb-4 hover:bg-gray-50 transition">
                            <PaperClipIcon class="h-5 w-5 text-gray-400" />
                            <span class="ml-3 text-sm text-gray-500 truncate">
                              {{ fileNameDisplay }}
                            </span>
                            <input type="file" accept="image/*" @change="handleImageChange" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        </div>
                        <p v-if="form.errors.image" class="mb-4 text-sm text-red-600">{{ form.errors.image }}</p>

                        <label class="block text-sm text-gray-700 mb-1 font-medium">Opsi 2: Ganti Link Google Drive</label>
                        <input type="url" v-model="form.image_url" placeholder="https://drive.google.com/file/d/..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <p class="mt-2 text-xs text-gray-500 italic">Kosongkan/abaikan form ini jika tidak ingin mengubah foto profil.</p>
                        <p v-if="form.errors.image_url" class="mt-2 text-sm text-red-600">{{ form.errors.image_url }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Riwayat Pendidikan</label>
                    <div>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.education_history" :key="index" class="flex gap-2">
                                <input v-model="form.education_history[index]" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <button type="button" @click="removeArrayItem('education_history', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('education_history')" class="flex items-center gap-1 text-sm font-medium text-[#4682A9] hover:underline"><PlusIcon class="w-4 h-4"/> Tambah Riwayat Pendidikan</button>
                        </div>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Bidang Keahlian</label>
                    <div>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.expertise" :key="index" class="flex gap-2">
                                <input v-model="form.expertise[index]" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <button type="button" @click="removeArrayItem('expertise', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('expertise')" class="flex items-center gap-1 text-sm font-medium text-[#4682A9] hover:underline"><PlusIcon class="w-4 h-4"/> Tambah Keahlian</button>
                        </div>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Pengalaman Kerja</label>
                    <div>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.work_experience" :key="index" class="flex gap-2 items-start">
                                <textarea v-model="form.work_experience[index]" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                                <button type="button" @click="removeArrayItem('work_experience', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('work_experience')" class="flex items-center gap-1 text-sm font-medium text-[#4682A9] hover:underline"><PlusIcon class="w-4 h-4"/> Tambah Pengalaman</button>
                        </div>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Penghargaan / Awards</label>
                    <div>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.awards" :key="index" class="flex gap-2">
                                <input v-model="form.awards[index]" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <button type="button" @click="removeArrayItem('awards', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('awards')" class="flex items-center gap-1 text-sm font-medium text-[#4682A9] hover:underline"><PlusIcon class="w-4 h-4"/> Tambah Penghargaan</button>
                        </div>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Riwayat Penelitian</label>
                    <div>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.research_history" :key="index" class="flex gap-2 items-start">
                                <textarea v-model="form.research_history[index]" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                                <button type="button" @click="removeArrayItem('research_history', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('research_history')" class="flex items-center gap-1 text-sm font-medium text-[#4682A9] hover:underline"><PlusIcon class="w-4 h-4"/> Tambah Penelitian</button>
                        </div>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Link Profil Akademik</label>
                    <div>
                        <div class="space-y-3">
                            <div v-for="(item, index) in form.academic_profiles" :key="index" class="flex gap-2">
                                <input v-model="form.academic_profiles[index]" type="url" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <button type="button" @click="removeArrayItem('academic_profiles', index)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 flex-shrink-0"><TrashIcon class="w-5 h-5"/></button>
                            </div>
                            <button type="button" @click="addArrayItem('academic_profiles')" class="flex items-center gap-1 text-sm font-medium text-[#4682A9] hover:underline"><PlusIcon class="w-4 h-4"/> Tambah Link Akademik</button>
                        </div>
                    </div>

                </div>

                <div class="mt-12 flex items-center justify-between border-t border-gray-100 pt-6">
                    <Link :href="route('admin.staff.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        <ArrowLeftIcon class="h-5 w-5" />
                        Kembali
                    </Link>

                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 disabled:opacity-50">
                        <PencilSquareIcon class="h-5 w-5" />
                        {{ form.processing ? 'Menyimpan...' : 'Perbarui Civitas' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>