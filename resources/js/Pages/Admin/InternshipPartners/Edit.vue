<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import InternshipPartnerForm, { type InternshipPartnerFormData } from '@/Components/InternshipPartnerForm.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    partner: {
        id: number;
        name: string;
        business_field: string;
        location: string;
        type: string;
        study_program_ids: number[];
        website: string | null;
        is_active: boolean;
        logo_url: string | null;
    };
    studyPrograms: { id: number; name: string; degree: string }[];
    types: Record<string, string>;
    businessFieldSuggestions: string[];
    locationSuggestions: string[];
}>();

const form = useForm<InternshipPartnerFormData>({
    name: props.partner.name,
    business_field: props.partner.business_field,
    location: props.partner.location,
    type: props.partner.type,
    study_program_ids: [...props.partner.study_program_ids],
    website: props.partner.website ?? '',
    is_active: props.partner.is_active,
    logo: null,
    remove_logo: false,
    // Upload file wajib lewat POST, Laravel membacanya sebagai PUT dari _method.
    _method: 'put',
});

const submit = () => form.post(route('admin.internship-partners.update', props.partner.id), { forceFormData: true });
</script>

<template>
    <div>
        <Head title="Edit Mitra KP/Magang" />

        <div class="mb-8">
            <Link :href="route('admin.internship-partners.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Edit Mitra KP/Magang</h1>
            <p class="mt-1 text-gray-600">Perbarui data <span class="font-semibold text-gray-800">{{ partner.name }}</span>.</p>
        </div>

        <InternshipPartnerForm
            :form="form"
            :study-programs="studyPrograms"
            :types="types"
            :business-field-suggestions="businessFieldSuggestions"
            :location-suggestions="locationSuggestions"
            :current-logo-url="partner.logo_url"
            submit-label="Simpan Perubahan"
            @submit="submit"
        />
    </div>
</template>
