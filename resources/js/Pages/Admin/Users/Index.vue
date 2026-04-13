<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router, usePage, Head } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import { 
    MagnifyingGlassIcon, 
    PencilSquareIcon, 
    TrashIcon, 
    UserPlusIcon,
    CheckCircleIcon,
    ExclamationTriangleIcon
} from '@heroicons/vue/24/outline';
import debounce from 'lodash/debounce';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    users: {
        data: Array<{
            id: number;
            name: string;
            email: string;
            is_superadmin: boolean;
            created_at: string;
        }>;
        links: Array<any>;
    };
    filters: {
        search: string;
    };
    auth: {
        user: {
            id: number;
            name: string;
            is_superadmin: boolean;
        };
        can_delete: boolean;
    };
}>();

const search = ref(props.filters.search);
watch(
    search,
    debounce((value) => {
        router.get(
            route('admin.users.index'),
            { search: value },
            { preserveState: true, replace: true }
        );
    }, 300)
);

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => { showNotification.value = false; }, 3000); 
    }
}, { immediate: true });

const isModalOpen = ref(false);
const itemToDelete = ref<any>(null);

const openDeleteModal = (user: any) => {
    itemToDelete.value = user;
    isModalOpen.value = true;
};

const closeDeleteModal = () => {
    isModalOpen.value = false;
    itemToDelete.value = null;
};

const confirmDelete = () => {
    if (itemToDelete.value) {
        router.delete(route('admin.users.destroy', itemToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};
</script>

<template>
    <div>
        <Head title="Kelola Akun Admin" />
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Akun Admin</h1>
                <p class="mt-1 text-gray-600">Daftar akun admin yang memiliki akses ke dashboard</p>
            </div>
            <Link
                :href="route('admin.users.create')"
                class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors"
                title="Tambah Admin Baru"
            >
                <UserPlusIcon class="h-5 w-5" />
                Tambah Admin
            </Link>
        </div>

        <div class="mb-6 flex items-center gap-4">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input
                    v-model="search"
                    type="text"
                    placeholder="Cari nama atau email..."
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 focus:border-primary focus:ring-primary shadow-sm transition-colors"
                />
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-xl border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Admin</h3>
            
            <div class="admin-table-container overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Tanggal Dibuat</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="font-bold text-gray-900">{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-3 py-1 text-xs font-bold tracking-wide',
                                        user.is_superadmin
                                            ? 'bg-purple-100 text-purple-800'
                                            : 'bg-primary/10 text-primary'
                                    ]"
                                >
                                    {{ user.is_superadmin ? 'Super Admin' : 'Admin' }}
                                </span>
                            </td>
                            <td>
                                {{ new Date(user.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) }}
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-3">
                                    <Link
                                        :href="route('admin.users.edit', user.id)"
                                        class="flex items-center gap-1 text-primary hover:text-primary-hover font-semibold transition-colors"
                                    >
                                        <PencilSquareIcon class="h-4 w-4" /> Edit
                                    </Link>
                                    
                                    <template v-if="props.auth.can_delete && !user.is_superadmin && user.id !== props.auth.user.id">
                                        <span class="text-gray-300">|</span>
                                        <button
                                            @click="openDeleteModal(user)"
                                            class="flex items-center gap-1 text-red-600 hover:text-red-800 font-semibold transition-colors"
                                        >
                                            <TrashIcon class="h-4 w-4" /> Hapus
                                        </button>
                                    </template>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="users.data.length === 0">
                            <td colspan="5" class="py-8 text-center text-gray-500 font-medium">
                                Tidak ada data admin ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="users.links.length > 3" class="mt-6 flex items-center justify-between">
                <p class="text-sm text-gray-600">Menampilkan hasil akun admin</p>
                <div class="flex items-center gap-1.5">
                    <Link
                        v-for="(link, key) in users.links"
                        :key="key"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        :class="[
                            'px-3.5 py-1.5 rounded-lg border text-sm font-medium transition-colors',
                            link.active ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50 hover:text-primary',
                            !link.url && 'opacity-50 bg-gray-50 cursor-not-allowed hover:bg-gray-50'
                        ]"
                    />
                </div>
            </div>
        </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity" @click.self="closeDeleteModal">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl transform transition-all scale-100">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-600" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Hapus Akun Admin</h2>
                <p class="mt-2 text-gray-600">
                    Apakah Anda yakin ingin menghapus akun <br>
                    <span class="font-bold text-gray-900">"{{ itemToDelete?.name }}"</span>?<br>
                    Aksi ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="mt-8 flex justify-center gap-3">
                <button @click="closeDeleteModal" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2.5 font-bold text-white hover:bg-red-700 transition-colors shadow-sm">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <transition
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="showNotification" class="fixed top-8 right-8 z-50">
            <div class="flex items-center gap-3 rounded-xl bg-green-600 px-5 py-4 text-white shadow-xl">
                <CheckCircleIcon class="h-6 w-6" />
                <p class="font-bold text-sm tracking-wide">{{ notificationMessage }}</p>
            </div>
        </div>
    </transition>
</template>