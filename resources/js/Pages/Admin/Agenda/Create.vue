<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, CheckIcon } from '@heroicons/vue/24/outline';

defineOptions({ layout: AdminLayout });

const form = useForm({
    title: '',
    organizer: '',
    start_date: '',
    end_date: '',
    location: '',
    description: '',
});

const submit = () => {
    form.post(route('admin.agenda-fakultas.store'));
};
</script>

<template>
    <Head title="Tambah Agenda Fakultas" />

    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-black">Tambah Agenda</h1>
            <p class="mt-1 text-black">Tambahkan data jadwal resmi, akademik, dan institusi FSTI</p>
        </div>

        <div class="bg-white shadow-sm p-8 rounded-lg">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-[150px_1fr] gap-x-8 gap-y-8">
                    
                    <label class="pt-2 text-sm font-semibold text-black">Judul Agenda *</label>
                    <div>
                        <input v-model="form.title" type="text" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" placeholder="Masukkan judul agenda">
                        <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Penyelenggara</label>
                    <div>
                        <input v-model="form.organizer" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" placeholder="Contoh: FSTI ITK, Prodi Sistem Informasi">
                        <p v-if="form.errors.organizer" class="mt-2 text-sm text-red-600">{{ form.errors.organizer }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Lokasi / Tempat</label>
                    <div>
                        <input v-model="form.location" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" placeholder="Contoh: Auditorium Kampus">
                        <p v-if="form.errors.location" class="mt-2 text-sm text-red-600">{{ form.errors.location }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Tanggal Mulai *</label>
                    <div>
                        <input v-model="form.start_date" type="date" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        <p v-if="form.errors.start_date" class="mt-2 text-sm text-red-600">{{ form.errors.start_date }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Tanggal Selesai</label>
                    <div>
                        <input v-model="form.end_date" type="date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                        <p class="mt-1 text-xs text-gray-500">Opsional. Isi jika agenda berlangsung lebih dari satu hari.</p>
                        <p v-if="form.errors.end_date" class="mt-2 text-sm text-red-600">{{ form.errors.end_date }}</p>
                    </div>

                    <label class="pt-2 text-sm font-semibold text-black">Deskripsi Singkat</label>
                    <div>
                        <textarea v-model="form.description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" placeholder="Keterangan singkat mengenai agenda..."></textarea>
                        <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">{{ form.errors.description }}</p>
                    </div>

                </div>

                <div class="mt-12 flex items-center justify-between">
                    <Link :href="route('admin.agenda-fakultas.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        <ArrowLeftIcon class="h-5 w-5" /> Kembali
                    </Link>
                    <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-primary px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-hover disabled:opacity-50">
                        <CheckIcon class="h-5 w-5" /> Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>