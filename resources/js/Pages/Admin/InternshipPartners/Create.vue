<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import InternshipPartnerForm, { type InternshipPartnerFormData } from '@/Components/InternshipPartnerForm.vue';

defineOptions({ layout: AdminLayout });

defineProps<{
    studyPrograms: { id: number; name: string; degree: string }[];
    types: Record<string, string>;
    businessFieldSuggestions: string[];
    locationSuggestions: string[];
}>();

const form = useForm<InternshipPartnerFormData>({
    name: '',
    business_field: '',
    location: '',
    type: 'kp_magang',
    study_program_ids: [],
    website: '',
    is_active: true,
    logo: null,
});

const submit = () => form.post(route('admin.internship-partners.store'), { forceFormData: true });
</script>

<template>
    <div>
        <Head title="Tambah Mitra KP/Magang" />

        <div class="mb-8">
            <Link :href="route('admin.internship-partners.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Mitra KP/Magang</h1>
            <p class="mt-1 text-gray-600">Tambahkan perusahaan atau instansi tempat mahasiswa FSTI pernah KP atau magang.</p>
        </div>

        <InternshipPartnerForm
            :form="form"
            :study-programs="studyPrograms"
            :types="types"
            :business-field-suggestions="businessFieldSuggestions"
            :location-suggestions="locationSuggestions"
            @submit="submit"
        />
    </div>
</template>
