<script setup>
import { ref } from 'vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { ArrowLeftIcon, PencilSquareIcon, PaperClipIcon, XMarkIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    partner: Object,
    posts: Array
});

const fileInput = ref(null);

const initialActivities = (props.partner.activities || []).map(act => {
    if (typeof act === 'string') {
        return { name: act, post_id: '', post_slug: '' };
    }
    return {
        name: act.name,
        post_id: act.post_id || '',
        post_slug: act.post_slug || ''
    };
});

const form = useForm({
    name: props.partner.name,
    activities: initialActivities.length > 0 ? initialActivities : [{ name: '', post_id: '', post_slug: '' }],
    logo: null,
    _method: 'put', 
});

const handleLogoChange = (event) => {
    const target = event.target;
    if (target.files && target.files[0]) {
        form.logo = target.files[0];
    } else {
        form.logo = null;
    }
};

const clearLogo = () => {
    form.logo = null;
    if (fileInput.value) fileInput.value.value = '';
};

const addActivity = () => {
    form.activities.push({ name: '', post_id: '', post_slug: '' });
};

const removeActivity = (index) => {
    form.activities.splice(index, 1);
};

const updateActivitySlug = (activity) => {
    if (!activity.post_id) {
        activity.post_slug = '';
        return;
    }
    const selectedPost = props.posts.find(p => p.id === activity.post_id);
    activity.post_slug = selectedPost ? selectedPost.slug : '';
};

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.name) {
        form.setError('name', 'Kolom nama institusi wajib diisi.');
        hasError = true;
    }

    if (form.logo) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(form.logo.type)) {
            form.setError('logo', 'Format file harus JPG, PNG, atau WEBP.');
            hasError = true;
        } else if (form.logo.size > 2 * 1024 * 1024) {
            form.setError('logo', 'Ukuran file gambar maksimal 2MB.');
            hasError = true;
        }
    }

    if (hasError) return;
    form.post(route('admin.partners.update', props.partner.id));
};
</script>

<template>
    <div>
        <Head :title="'Edit Kerjasama: ' + props.partner.name" />
        <div class="mb-8">
            <Link :href="route('admin.partners.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Edit Data Kerjasama</h1>
            <p class="mt-1 text-gray-600">Perbarui informasi institusi mitra dan bentuk kolaborasi kerjasama.</p>
        </div>

        <div class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent="submit" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Nama Institusi / Mitra <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.name" type="text" placeholder="Contoh: PT Telkom Indonesia" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.name" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Ganti Logo Instansi</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3 font-medium">Opsional. Biarkan kosong jika tidak mengubah logo. Maksimal 2MB.</p>
                        <div class="flex flex-col sm:flex-row gap-6 items-start">
                            <div v-if="props.partner.logo" class="shrink-0 flex flex-col items-center">
                                <p class="text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest text-center">Logo Saat Ini</p>
                                <div class="h-20 w-32 bg-white rounded-lg border border-gray-200 flex items-center justify-center p-2 shadow-sm">
                                    <img :src="`/storage/${props.partner.logo}`" class="h-full w-full object-contain mix-blend-multiply" />
                                </div>
                            </div>
                            
                            <div class="w-full space-y-3 min-w-0">
                                <label class="block text-[10px] font-extrabold text-primary mb-1.5 uppercase tracking-widest">Upload File Gambar Baru</label>
                                <div class="relative flex items-center w-full rounded-lg border bg-white shadow-sm px-4 py-2.5 hover:bg-gray-50 transition" :class="form.errors.logo ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                                    <PaperClipIcon :class="form.errors.logo ? 'text-red-400' : 'text-gray-400'" class="h-5 w-5 flex-shrink-0" />
                                    <span class="ml-3 text-sm truncate flex-1 font-medium" :class="form.errors.logo ? 'text-red-700' : 'text-gray-500'">
                                        {{ form.logo ? form.logo.name : 'Pilih file dari perangkat...' }}
                                    </span>
                                    <button v-if="form.logo" type="button" @click.prevent="clearLogo" class="ml-2 p-1 text-red-500 hover:bg-red-50 rounded-md relative z-10 flex-shrink-0" title="Batal Pilih File">
                                        <XMarkIcon class="w-5 h-5"/>
                                    </button>
                                    <input ref="fileInput" type="file" accept="image/png, image/jpeg, image/webp" @change="handleLogoChange" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :class="{'hidden': form.logo}" />
                                </div>
                                <InputError :message="form.errors.logo" />
                            </div>
                        </div>
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Daftar Kegiatan</label>
                    <div>
                        <p class="text-xs text-gray-500 mb-3 font-medium">Tambahkan rincian kegiatan. Jika ada berita yang berkaitan, Anda dapat memilihnya dari daftar dropdown (opsional).</p>
                        
                        <div class="space-y-3">
                            <div v-for="(activity, index) in form.activities" :key="index" class="flex flex-col sm:flex-row gap-2 items-start bg-gray-50 p-3 rounded-xl border border-gray-200">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 flex-grow w-full">
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-600 mb-1 uppercase">Nama Kegiatan <span class="text-red-500">*</span></label>
                                        <input v-model="activity.name" type="text" placeholder="Cth: Penelitian Bersama" class="block w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary text-sm py-2" required>
                                        <InputError v-if="form.errors[`activities.${index}.name`]" :message="form.errors[`activities.${index}.name`]" class="mt-1" />
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-600 mb-1 uppercase">Tautkan ke Berita (Opsional)</label>
                                        <select v-model="activity.post_id" @change="updateActivitySlug(activity)" class="block w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary text-sm py-2 text-gray-700">
                                            <option value="">-- Tidak Ada Berita Terkait --</option>
                                            <option v-for="post in posts" :key="post.id" :value="post.id">{{ post.title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" @click="removeActivity(index)" class="mt-5 p-2 text-red-500 hover:bg-red-100 rounded-lg border border-transparent hover:border-red-200 transition-colors shrink-0" title="Hapus Kegiatan">
                                    <TrashIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <button type="button" @click="addActivity" class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-primary hover:text-primary-hover bg-blue-50 px-4 py-2 rounded-lg transition-colors">
                            <PlusIcon class="w-4 h-4" stroke-width="2.5" /> Tambah Kegiatan
                        </button>
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.partners.index')" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                        <PencilSquareIcon class="h-5 w-5 stroke-2" />
                        {{ form.processing ? 'Menyimpan...' : 'Perbarui Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>