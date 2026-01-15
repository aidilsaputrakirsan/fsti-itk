<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { MagnifyingGlassIcon, PencilSquareIcon, TrashIcon, UserPlusIcon } from '@heroicons/vue/24/outline';
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

const deleteUser = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus akun admin ini? Tindakan ini tidak dapat dibatalkan.')) {
        router.delete(route('admin.users.destroy', id));
    }
};
</script>

<template>
    <div>
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Akun Admin</h1>
                <p class="mt-1 text-black">Daftar akun admin yang memiliki akses ke dashboard</p>
            </div>
            <Link
                :href="route('admin.users.create')"
                class="inline-flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-white hover:bg-opacity-90 transition-colors"
                title="Tambah Admin Baru"
            >
                <UserPlusIcon class="h-5 w-5" />
                Tambah Admin
            </Link>
        </div>

        <div class="mb-6">
            <div class="relative max-w-md">
                <MagnifyingGlassIcon class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input
                    v-model="search"
                    type="text"
                    placeholder="Cari nama atau email..."
                    class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500"
                />
            </div>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-sm">
            <table class="w-full whitespace-nowrap text-left text-sm">
                <thead class="bg-gray-50 text-gray-900 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ user.name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ user.email }}</td>
                        <td class="px-6 py-4">
                            <span
                                :class="[
                                    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                    user.is_superadmin
                                        ? 'bg-purple-100 text-purple-800'
                                        : 'bg-blue-100 text-blue-800'
                                ]"
                            >
                                {{ user.is_superadmin ? 'Super Admin' : 'Admin' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ new Date(user.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <Link
                                    :href="route('admin.users.edit', user.id)"
                                    class="rounded p-2 text-blue-600 hover:bg-blue-50"
                                    title="Edit Akun"
                                >
                                    <PencilSquareIcon class="h-5 w-5" />
                                </Link>
                                
                                <button
                                    v-if="props.auth.can_delete && !user.is_superadmin && user.id !== props.auth.user.id"
                                    @click="deleteUser(user.id)"
                                    class="rounded p-2 text-red-600 hover:bg-red-50"
                                    title="Hapus Akun"
                                >
                                    <TrashIcon class="h-5 w-5" />
                                </button>
                                <span v-else class="h-9 w-9 block"></span> <!-- Spacer if delete hidden -->
                            </div>
                        </td>
                    </tr>
                    <tr v-if="users.data.length === 0">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data admin ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div v-if="users.links.length > 3" class="mt-6 flex justify-center gap-2">
            <Link
                v-for="(link, key) in users.links"
                :key="key"
                :href="link.url ?? '#'"
                v-html="link.label"
                :class="[
                    'px-3 py-1 rounded text-sm',
                    link.active ? 'bg-[#4682A9] text-white' : 'bg-white text-gray-700 hover:bg-gray-100',
                    !link.url && 'opacity-50 cursor-not-allowed'
                ]"
            />
        </div>
    </div>
</template>
