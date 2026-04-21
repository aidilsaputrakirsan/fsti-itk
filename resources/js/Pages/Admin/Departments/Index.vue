<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PlusIcon, PencilSquareIcon, TrashIcon, ExclamationTriangleIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    departments: any[];
}>();

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);
const flashError = computed(() => (page.props as any).flash?.error);

watch([flashSuccess, flashError], ([successMsg, errorMsg]) => {
    if (successMsg) {
        notificationMessage.value = successMsg as string;
        showNotification.value = true;
        setTimeout(() => showNotification.value = false, 3000);
    } else if (errorMsg) {
        notificationMessage.value = errorMsg as string;
        showNotification.value = true;
        setTimeout(() => showNotification.value = false, 3000);
    }
}, { immediate: true });

const isFormModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref<number | null>(null);

const form = useForm({
    name: '',
});

const openCreateModal = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.clearErrors();
    isFormModalOpen.value = true;
};

const openEditModal = (department: any) => {
    isEditing.value = true;
    editingId.value = department.id;
    form.name = department.name;
    form.clearErrors();
    isFormModalOpen.value = true;
};

const closeFormModal = () => {
    isFormModalOpen.value = false;
};

const submitForm = () => {
    if (isEditing.value) {
form.put(route('admin.departments.update', editingId.value as number), {            onSuccess: () => closeFormModal(),
        });
    } else {
        form.post(route('admin.departments.store'), {
            onSuccess: () => closeFormModal(),
        });
    }
};

const isDeleteModalOpen = ref(false);
const itemToDelete = ref<any | null>(null);

const openDeleteModal = (department: any) => {
    itemToDelete.value = department;
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    itemToDelete.value = null;
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        form.delete(route('admin.departments.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};
</script>

<template>
    <div>
        <Head title="Kelola Jurusan" />

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Jurusan Induk</h1>
                <p class="mt-1 text-gray-600">Manajemen daftar jurusan yang membawahi program studi.</p>
            </div>
            <button @click="openCreateModal" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors flex-shrink-0">
                <PlusIcon class="h-5 w-5 stroke-2" /> Tambah Jurusan
            </button>
        </div>

        <div class="bg-white shadow-sm p-4 sm:p-6 rounded-xl border border-gray-100 overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 hidden sm:block">Daftar Jurusan</h3>
            
            <div class="admin-table-container overflow-x-auto w-full">
                <table class="w-full min-w-[600px]">
                    <thead>
                        <tr>
                            <th scope="col" class="w-16 text-center">No</th>
                            <th scope="col">Nama Jurusan</th>
                            <th scope="col" class="text-center w-32">Total Prodi</th>
                            <th scope="col" class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="departments.length > 0" v-for="(dept, index) in departments" :key="dept.id">
                            <td class="text-center font-medium text-gray-500">{{ index + 1 }}</td>
                            <td><div class="font-bold text-gray-900 leading-snug">{{ dept.name }}</div></td>
                            <td class="text-center">
                                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">
                                    {{ dept.study_programs_count }} Prodi
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <button @click="openEditModal(dept)" class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors">
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </button>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(dept)" type="button" class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors">
                                        <TrashIcon class="h-4 w-4" /> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="4" class="py-8 text-center text-gray-500 font-medium">Belum ada data jurusan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="isFormModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeFormModal">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl transform transition-all scale-100">
                <h2 class="text-xl font-bold text-gray-900 mb-4">{{ isEditing ? 'Edit Jurusan' : 'Tambah Jurusan' }}</h2>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Jurusan <span class="text-red-500">*</span></label>
                        <input v-model="form.name" type="text" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary py-2.5" placeholder="Cth: Sains dan Analitika Data">
                        <InputError :message="form.errors.name" class="mt-1" />
                    </div>
                    <div class="mt-8 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <button type="button" @click="closeFormModal" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto">Batal</button>
                        <button type="submit" :disabled="form.processing" class="rounded-lg bg-primary px-6 py-2.5 font-bold text-white hover:bg-primary-hover disabled:opacity-50 transition-colors w-full sm:w-auto">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeDeleteModal">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 sm:p-8 shadow-2xl transform transition-all scale-100">
                <div class="flex flex-col items-center text-center">
                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                        <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Hapus Jurusan?</h2>
                    <p class="mt-2 text-gray-600 text-center">
                        Apakah Anda yakin ingin menghapus <br>
                        <span class="font-bold text-gray-900 mt-1 line-clamp-2">"{{ itemToDelete?.name }}"</span>?
                    </p>
                </div>
                <div class="mt-8 flex flex-col-reverse sm:flex-row justify-center gap-3">
                    <button @click="closeDeleteModal" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-50 transition-colors w-full sm:w-auto">Batal</button>
                    <button @click="confirmDelete" :disabled="form.processing" class="rounded-lg bg-red-600 px-6 py-2.5 font-bold text-white hover:bg-red-700 disabled:opacity-50 transition-colors w-full sm:w-auto">Ya, Hapus</button>
                </div>
            </div>
        </div>

        <div v-if="showNotification" class="fixed top-5 right-5 sm:top-8 sm:right-8 z-50">
            <div class="flex items-center gap-3 rounded-xl px-5 py-4 text-white shadow-xl" :class="flashError ? 'bg-red-600' : 'bg-green-600'">
                <CheckCircleIcon v-if="!flashError" class="h-6 w-6" />
                <ExclamationTriangleIcon v-else class="h-6 w-6" />
                <p class="font-bold text-sm tracking-wide">{{ notificationMessage }}</p>
            </div>
        </div>
    </div>
</template>