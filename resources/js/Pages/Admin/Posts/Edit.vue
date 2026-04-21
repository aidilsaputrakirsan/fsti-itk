<script setup lang="ts">
import { onBeforeUnmount, onUnmounted, ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { 
    PaperClipIcon,
    ArrowUturnLeftIcon,
    ArrowUturnRightIcon,
    LinkIcon,
    ArrowLeftIcon,
    XMarkIcon,
    PaperAirplaneIcon,
} from '@heroicons/vue/24/outline';
import InputError from '@/Components/InputError.vue';

import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TiptapLink from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    post?: any;
    data?: any;
    categories: any[];
}>();

const dataPost = props.post || props.data || {};

interface PostFormData {
    _method: string;
    title: string;
    content: string;
    post_category_id: string | number;
    status: string;
    image: File | null;
}

const form = useForm<PostFormData>({
    _method: 'PUT',
    title: dataPost.title || '',
    content: dataPost.content || '',
    post_category_id: dataPost.post_category_id || '',
    status: dataPost.status || 'Draft',
    image: null,
});

const showLinkModal = ref(false);
const linkUrlInput = ref('');

const editor = useEditor({
    content: form.content,
    extensions: [
        StarterKit,
        Underline,
        TiptapLink.configure({ 
            openOnClick: false,
            HTMLAttributes: {
                target: '_blank',
                rel: 'noopener noreferrer',
                class: 'text-blue-600 underline hover:text-blue-800 break-words'
            },
        }),
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
    ],
    onUpdate: ({ editor }) => {
        form.content = editor.getHTML();
    },
    editorProps: {
        attributes: {
            class: 'prose max-w-none w-full rounded-b-lg border border-t-0 border-gray-300 bg-white focus:border-primary focus:ring-primary p-5 min-h-[300px] text-sm text-gray-900',
        },
    },
});

const imagePreview = ref<string | null>(dataPost.image_url ?? null);
const temporaryImageUrl = ref<string | null>(null);
const showImageModal = ref(false);

const fileNameDisplay = computed(() => {
    if (form.image instanceof File) {
        return form.image.name;
    }
    return 'Pilih gambar baru (opsional, maks. 2 MB)';
});

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        const file = target.files[0];
        form.image = file;

        if (temporaryImageUrl.value) {
            URL.revokeObjectURL(temporaryImageUrl.value);
        }
        
        const newUrl = URL.createObjectURL(file);
        imagePreview.value = newUrl;
        temporaryImageUrl.value = newUrl;
    }
};

const applyFormat = (format: string, options?: any) => {
    if (!editor.value) return;
    const chain = editor.value.chain().focus();
    (chain as any)[format](options).run();
};

const openLinkModal = () => {
    if (!editor.value) return;
    linkUrlInput.value = editor.value.getAttributes('link').href || '';
    showLinkModal.value = true;
};

const closeLinkModal = () => {
    showLinkModal.value = false;
    linkUrlInput.value = '';
};

const applyLink = () => {
    if (!editor.value) return;

    if (linkUrlInput.value === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run();
    } else {
        let finalUrl = linkUrlInput.value;
        if (!/^https?:\/\//i.test(finalUrl)) {
            finalUrl = 'https://' + finalUrl;
        }

        const { from, to } = editor.value.state.selection;
        if (from === to) {
            editor.value.chain().focus().insertContent(`<a href="${finalUrl}">${finalUrl}</a>`).run();
        } else {
            editor.value.chain().focus().extendMarkRange('link').setLink({ href: finalUrl }).run();
        }
    }
    closeLinkModal();
};

const openImageModal = () => {
    if (imagePreview.value) {
        showImageModal.value = true;
    }
};

const closeImageModal = () => {
    showImageModal.value = false;
};

onBeforeUnmount(() => {
    editor.value?.destroy();
});

onUnmounted(() => {
    if (temporaryImageUrl.value) {
        URL.revokeObjectURL(temporaryImageUrl.value);
    }
});

const validateForm = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.title) {
        form.setError('title', 'Judul berita wajib diisi.');
        hasError = true;
    }

    if (!form.content || form.content === '<p></p>') {
        form.setError('content', 'Isi konten berita wajib diisi.');
        hasError = true;
    }

    if (!form.post_category_id) {
        form.setError('post_category_id', 'Kategori berita wajib dipilih.');
        hasError = true;
    }

    if (form.image) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!allowedTypes.includes(form.image.type)) {
            form.setError('image', 'Format file harus JPG, PNG, atau WEBP.');
            hasError = true;
        } else if (form.image.size > 2 * 1024 * 1024) {
            form.setError('image', 'Ukuran file tidak boleh lebih dari 2 MB.');
            hasError = true;
        }
    }

    return !hasError;
};

const submit = () => {
    if (!validateForm()) return;
    const targetUrl: string = route('admin.posts.update', dataPost.id);
    form.post(targetUrl);
};
</script>

<template>
    <div>
        <Head :title="'Edit Berita: ' + (dataPost.title || '')" />

        <div class="mb-8">
            <Link :href="route('admin.posts.index')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition-colors shadow-sm w-fit mb-6">
                <ArrowLeftIcon class="h-4 w-4 stroke-2" /> Kembali ke Daftar
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Edit Berita</h1>
            <p class="mt-1 text-gray-600">Perbarui detail konten berita website FSTI ITK.</p>
        </div>

        <div v-if="dataPost.id" class="bg-white shadow-sm p-5 sm:p-8 rounded-xl border-t-4 border-primary">
            <form @submit.prevent novalidate>
                <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-6 md:gap-y-8">
                    
                    <label class="md:pt-3 text-sm font-bold text-gray-800">Judul Berita <span class="text-red-600">*</span></label>
                    <div>
                        <input v-model="form.title" type="text" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.title ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                        <InputError :message="form.errors.title" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Isi Konten Berita <span class="text-red-600">*</span></label>
                    <div class="w-full">
                        <div v-if="editor" class="flex flex-wrap items-center gap-1 border border-gray-300 rounded-t-lg bg-gray-100 p-2 text-gray-700">
                            <button @click="applyFormat('toggleBold')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('bold') }" class="toolbar-button">
                                <span class="font-bold">B</span>
                            </button>
                            <button @click="applyFormat('toggleItalic')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('italic') }" class="toolbar-button">
                                <span class="italic">I</span>
                            </button>
                            <button @click="applyFormat('toggleUnderline')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('underline') }" class="toolbar-button">
                                <span class="underline">U</span>
                            </button>
                            <button @click="applyFormat('toggleStrike')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('strike') }" class="toolbar-button">
                                <span class="line-through">S</span>
                            </button>
                            
                            <button @click="openLinkModal" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('link') }" class="toolbar-button">
                                <LinkIcon class="h-4 w-4" />
                            </button>

                            <div class="toolbar-divider"></div>
                            <button @click="applyFormat('toggleHeading', { level: 2 })" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('heading', { level: 2 }) }" class="toolbar-button">
                                <span class="text-xs font-bold">H2</span>
                            </button>
                            <button @click="applyFormat('toggleHeading', { level: 3 })" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('heading', { level: 3 }) }" class="toolbar-button">
                                <span class="text-xs font-bold">H3</span>
                            </button>
                            <button @click="applyFormat('toggleBlockquote')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('blockquote') }" class="toolbar-button">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.983 3v7.391c0 2.908-2.353 5.261-5.261 5.261v3.65c4.894 0 8.87-3.977 8.87-8.87V3h-3.609zM21.017 3v7.391c0 2.908-2.353 5.261-5.261 5.261v3.65c4.894 0 8.87-3.977 8.87-8.87V3h-3.609z"/></svg>
                            </button>
                            <div class="toolbar-divider"></div>
                            <button @click="applyFormat('toggleBulletList')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('bulletList') }" class="toolbar-button">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h2v2H4V4zm4 0h12v2H8V4zM4 11h2v2H4v-2zm4 0h12v2H8v-2zm-4 7h2v2H4v-2zm4 0h12v2H8v-2z"/></svg>
                            </button>
                            <button @click="applyFormat('toggleOrderedList')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive('orderedList') }" class="toolbar-button">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5.83 4.242H8v2H4.5V4.742l1.33-.5zM4.5 11h3.5v2H4.5v-2zm0 7h3.5v2H4.5v-2zM9.5 4h10v2h-10V4zm0 7h10v2h-10v-2zm0 7h10v2h-10v-2zM4.03 4.9v.8L2.5 7H4.5V9H1V4h1.5v.9l1.53-1.8z"/></svg>
                            </button>
                            <div class="toolbar-divider"></div>
                            <button @click="applyFormat('setTextAlign', 'left')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive({ textAlign: 'left' }) }" class="toolbar-button">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm0 7h12v2H3v-2zm0 7h18v2H3v-2z"/></svg>
                            </button>
                            <button @click="applyFormat('setTextAlign', 'center')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive({ textAlign: 'center' }) }" class="toolbar-button">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm3 7h12v2H6v-2zm-3 7h18v2H3v-2z"/></svg>
                            </button>
                            <button @click="applyFormat('setTextAlign', 'right')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive({ textAlign: 'right' }) }" class="toolbar-button">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm9 7h9v2h-9v-2zm-9 7h18v2H3v-2z"/></svg>
                            </button>
                            <button @click="applyFormat('setTextAlign', 'justify')" type="button" :class="{ 'bg-gray-300 text-gray-900': editor.isActive({ textAlign: 'justify' }) }" class="toolbar-button">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm0 5h18v2H3V9zm0 5h18v2H3v-2zm0 5h18v2H3v-2z"/></svg>
                            </button>
                            <div class="toolbar-divider"></div>
                            <button @click="applyFormat('undo')" type="button" :disabled="!editor.can().undo()" class="toolbar-button">
                                <ArrowUturnLeftIcon class="h-4 w-4"/>
                            </button>
                            <button @click="applyFormat('redo')" type="button" :disabled="!editor.can().redo()" class="toolbar-button">
                                <ArrowUturnRightIcon class="h-4 w-4"/>
                            </button>
                        </div>
                        <EditorContent :editor="editor" />
                        <InputError :message="form.errors.content" class="mt-2" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Kategori <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.post_category_id" 
                            class="block w-full rounded-lg transition-colors py-3"
                            :class="form.errors.post_category_id ? 'border-red-500 focus:border-red-500 focus:ring-red-500 bg-red-50 text-red-900' : 'border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white'" 
                            required>
                            <option value="" disabled>Pilih kategori berita</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.post_category_id" />
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Status Publikasi <span class="text-red-600">*</span></label>
                    <div>
                        <select v-model="form.status" 
                            class="block w-full rounded-lg transition-colors py-3 border-gray-300 focus:border-primary focus:ring-primary bg-gray-50 focus:bg-white" 
                            required>
                            <option value="Draft">Draft</option>
                            <option value="Terbitkan">Terbitkan</option>
                        </select>
                    </div>

                    <label class="md:pt-3 text-sm font-bold text-gray-800">Gambar Cover <span class="text-red-600">*</span></label>
                    <div>
                        <div v-if="imagePreview" class="mb-4">
                            <img 
                                :src="imagePreview" 
                                alt="Preview Gambar" 
                                class="w-48 h-auto rounded-lg object-cover cursor-pointer hover:opacity-80 transition-opacity border border-gray-200"
                                @click="openImageModal"
                            >
                        </div>
                        <div class="relative flex items-center w-full rounded-lg border border-gray-300 bg-gray-50 hover:bg-white focus-within:bg-white focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-colors shadow-sm px-4 py-3 cursor-pointer">
                            <PaperClipIcon class="h-5 w-5 text-gray-400 flex-shrink-0" />
                            <span class="ml-3 text-sm truncate" :class="{'text-gray-400': !form.image, 'text-gray-900 font-medium': form.image}">
                                {{ fileNameDisplay }}
                            </span>
                            <input
                                type="file"
                                accept="image/*"
                                @change="handleImageChange"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            />
                        </div>
                        <p class="mt-2 text-[11px] text-gray-500 font-medium">Format yang didukung: JPG, PNG, WEBP. Ukuran maksimal 2 MB. Kosongkan jika tidak ingin mengubah.</p>
                        <InputError :message="form.errors.image" />
                    </div>

                </div>

                <div class="mt-12 flex flex-col-reverse md:flex-row items-center justify-between gap-4 border-t border-gray-100 pt-6">
                    <Link :href="route('admin.posts.index')" class="w-full md:w-auto text-center rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </Link>
                    <div class="flex flex-col sm:flex-row w-full md:w-auto gap-3">
                        <button @click="submit" type="button" :disabled="form.processing" class="w-full sm:w-auto flex items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-primary-hover transition-colors disabled:opacity-50">
                            <PaperAirplaneIcon class="h-5 w-5 stroke-2" />
                            Perbarui Berita
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Teleport to="body">
        <div v-if="showLinkModal" @keydown.escape="closeLinkModal" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative" @click.stop>
                <button @click="closeLinkModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <XMarkIcon class="h-5 w-5 stroke-2" />
                </button>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tambahkan Tautan (Link)</h3>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat URL</label>
                    <input v-model="linkUrlInput" @keyup.enter="applyLink" type="url" placeholder="https://itk.ac.id" 
                        class="block w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary py-2.5 shadow-sm">
                </div>
                <div class="flex justify-end gap-3">
                    <button @click="closeLinkModal" type="button" class="px-5 py-2.5 text-sm font-bold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                    <button @click="applyLink" type="button" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-lg hover:bg-primary-hover transition-colors">Terapkan</button>
                </div>
            </div>
        </div>
    </Teleport>

    <Teleport to="body">
        <div v-if="showImageModal" @keydown.escape="closeImageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity">
            <div class="relative w-full max-w-4xl max-h-[90vh]" @click.stop>
                <img :src="imagePreview!" alt="Preview Gambar Penuh" class="w-full h-full object-contain rounded-lg shadow-2xl">
                <button @click="closeImageModal" class="absolute -top-3 -right-3 bg-white rounded-full p-2 text-gray-800 hover:bg-gray-200 transition-colors shadow-xl">
                    <XMarkIcon class="h-6 w-6 stroke-2" />
                </button>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.ProseMirror { outline: none; }
.toolbar-button { display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 4px; transition: background-color 0.2s; }
.toolbar-button:hover { background-color: #e5e7eb; }
.toolbar-button.is-active { background-color: #d1d5db; color: #111827; }
.toolbar-divider { width: 1px; background-color: #d1d5db; margin-left: 4px; margin-right: 4px; align-self: stretch; height: 24px; }

:deep(.prose) {
    word-break: break-word;
    overflow-wrap: break-word;
}
:deep(.prose a) {
    color: #2563eb !important;
    text-decoration: underline !important;
    word-break: break-word;
}
</style>