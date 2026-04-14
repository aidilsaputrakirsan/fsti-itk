<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';

const props = defineProps<{
    categories: Array<{ id: number, name: string }>;
}>();

const form = useForm({
    respondent_name: '',
    respondent_email: '',
    respondent_type: '',
    service_category: '',
    rating: 5,
    feedback: ''
});

const isSubmitted = ref(false);

const submit = () => {
    form.clearErrors();
    let hasError = false;

    if (!form.respondent_name) {
        form.setError('respondent_name', 'Nama lengkap wajib diisi.');
        hasError = true;
    }
    if (!form.respondent_email) {
        form.setError('respondent_email', 'Email aktif wajib diisi.');
        hasError = true;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.respondent_email)) {
        form.setError('respondent_email', 'Format email tidak valid.');
        hasError = true;
    }
    if (!form.respondent_type) {
        form.setError('respondent_type', 'Kategori responden wajib dipilih.');
        hasError = true;
    }
    if (!form.service_category) {
        form.setError('service_category', 'Aspek penilaian wajib dipilih.');
        hasError = true;
    }
    if (!form.rating) {
        form.setError('rating', 'Penilaian wajib diberikan.');
        hasError = true;
    }
    if (!form.feedback) {
        form.setError('feedback', 'Masukan tambahan wajib diisi.');
        hasError = true;
    }

    if (hasError) return;

    form.post(route('satisfaction-surveys.store'), {
        preserveScroll: true,
        onSuccess: () => {
            isSubmitted.value = true;
            form.reset();
        }
    });
};

const isTypeOpen = ref(false);
const isCategoryOpen = ref(false);

const typeBtnRef = ref<HTMLButtonElement | null>(null);
const categoryBtnRef = ref<HTMLButtonElement | null>(null);

const typeDropdownStyle = ref({});
const categoryDropdownStyle = ref({});

const toggleDropdown = (type: 'type' | 'category') => {
    const refs = { type: typeBtnRef, category: categoryBtnRef };
    const isOpenRefs = { type: isTypeOpen, category: isCategoryOpen };
    const styleRefs = { type: typeDropdownStyle, category: categoryDropdownStyle };

    Object.keys(isOpenRefs).forEach(key => {
        if (key !== type) isOpenRefs[key as keyof typeof isOpenRefs].value = false;
    });

    const isOpen = isOpenRefs[type];
    if (isOpen.value) {
        isOpen.value = false;
    } else {
        const button = refs[type].value;
        if (button) {
            const rect = button.getBoundingClientRect();
            styleRefs[type].value = {
                position: 'absolute',
                top: `${rect.bottom + window.scrollY + 6}px`, 
                left: `${rect.left}px`,
                width: `${rect.width}px`,
            };
        }
        isOpen.value = true;
    }
};

const selectOption = (type: 'type' | 'category', value: string) => {
    if (type === 'type') {
        form.respondent_type = value;
        isTypeOpen.value = false;
    } else if (type === 'category') {
        form.service_category = value;
        isCategoryOpen.value = false;
    }
};

const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as Node;
    const check = (btnRef: typeof typeBtnRef, menuId: string, isOpenRef: typeof isTypeOpen) => {
        const menu = document.getElementById(menuId);
        if (btnRef.value && !btnRef.value.contains(target) && menu && !menu.contains(target)) {
            isOpenRef.value = false;
        }
    };
    check(typeBtnRef, 'type-dropdown-menu', isTypeOpen);
    check(categoryBtnRef, 'category-dropdown-menu', isCategoryOpen);
};

onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside);
});

const respondentTypes = [
    'Mahasiswa', 
    'Dosen', 
    'Tenaga Kependidikan', 
    'Alumni', 
    'Masyarakat Umum'
];
</script>

<template>
    <PublicLayout>
        <Head title="Survei Kepuasan" />
        <Banner
            title="Survei Kepuasan"
            subtitle="Bantu kami tingkatkan kualitas layanan informasi dan Zona Integritas FSTI ITK"
            background-image="/images/background-banner.png"
        />

        <div class="relative bg-white py-12 md:py-16 overflow-hidden font-public-sans">
            <div class="absolute top-0 left-0 w-72 h-72 bg-primary opacity-10 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-800 opacity-10 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl relative z-10">
                
                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100 backdrop-blur-sm" data-aos="fade-up">
                    
                    <template v-if="!isSubmitted">
                        <div class="bg-primary px-6 py-10 text-center relative overflow-hidden">
                            <div class="absolute -top-16 -right-10 w-48 h-48 rounded-full border-[20px] border-white/10"></div>
                            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            
                            <div class="relative z-10">
                                <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-white text-[10px] font-public-sans font-bold tracking-widest mb-3 backdrop-blur-md border border-white/20">
                                    ZONA INTEGRITAS FSTI
                                </span>
                                <h2 class="text-2xl md:text-3xl font-optimus font-bold text-white mb-2 drop-shadow-md">Beri Kami Nilai</h2>
                                <p class="text-white/90 text-sm max-w-xl mx-auto leading-relaxed font-public-sans font-medium">
                                    Masukan Anda sangat berarti untuk membangun FSTI yang lebih transparan dan komunikatif. Yuk, isi survei singkat ini!
                                </p>
                            </div>
                        </div>

                        <div class="p-6 md:p-10">
                            <div class="mb-10 bg-blue-50 border border-blue-100 p-4 rounded-xl flex items-start shadow-sm">
                                <div class="bg-primary p-1.5 rounded-full mr-3 flex-shrink-0 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <p class="text-xs text-gray-700 leading-relaxed font-public-sans font-semibold">
                                    Mohon lengkapi semua kolom di bawah ya. Jangan khawatir, identitas Anda dijamin kerahasiaannya.
                                </p>
                            </div>

                            <form @submit.prevent="submit" novalidate class="space-y-10">
                                <section>
                                    <div class="flex items-center mb-6">
                                        <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm mr-3 shadow-md shadow-primary/20">01</div>
                                        <h3 class="text-xl font-optimus font-bold text-primary">Informasi Data Diri</h3>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:ml-12">
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-public-sans font-bold text-gray-700 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                            <input v-model="form.respondent_name" type="text" placeholder="Masukkan nama Anda" 
                                                class="w-full text-sm font-medium rounded-xl py-3.5 px-4 transition-all duration-300 shadow-inner"
                                                :class="form.errors.respondent_name ? 'border-red-500 bg-red-50 text-red-900 placeholder-red-400 focus:ring-red-500 focus:border-red-500' : 'border-transparent bg-slate-100 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20'"
                                            >
                                            <InputError :message="form.errors.respondent_name" />
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-public-sans font-bold text-gray-700 ml-1">Email Aktif <span class="text-red-500">*</span></label>
                                            <input v-model="form.respondent_email" type="email" placeholder="contoh@email.com" 
                                                class="w-full text-sm font-medium rounded-xl py-3.5 px-4 transition-all duration-300 shadow-inner"
                                                :class="form.errors.respondent_email ? 'border-red-500 bg-red-50 text-red-900 placeholder-red-400 focus:ring-red-500 focus:border-red-500' : 'border-transparent bg-slate-100 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20'"
                                            >
                                            <InputError :message="form.errors.respondent_email" />
                                        </div>
                                        <div class="md:col-span-2 space-y-1.5 relative">
                                            <label class="block text-xs font-public-sans font-bold text-gray-700 ml-1">Kategori Anda <span class="text-red-500">*</span></label>
                                            <button ref="typeBtnRef" @click="toggleDropdown('type')" type="button" 
                                                class="w-full text-sm rounded-xl py-3.5 px-4 transition-all duration-300 shadow-inner font-public-sans flex items-center justify-between text-left" 
                                                :class="[
                                                    form.respondent_type ? 'text-gray-900 font-bold' : 'text-gray-400 font-medium',
                                                    form.errors.respondent_type ? 'border border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500' : 'border border-transparent bg-slate-100 hover:bg-gray-100 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20'
                                                ]">
                                                <span>{{ form.respondent_type || 'Pilih Kategori Responden' }}</span>
                                                <ChevronDown class="w-4 h-4 text-gray-500 transition-transform" :class="{'rotate-180': isTypeOpen}" />
                                            </button>
                                            <InputError :message="form.errors.respondent_type" />
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <div class="flex items-center mb-6">
                                        <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm mr-3 shadow-md shadow-primary/20">02</div>
                                        <h3 class="text-xl font-optimus font-bold text-primary">Penilaian Layanan</h3>
                                    </div>

                                    <div class="space-y-8 md:ml-12">
                                        <div class="space-y-1.5 relative">
                                            <label class="block text-xs font-public-sans font-bold text-gray-700 ml-1">Fokus yang Dinilai <span class="text-red-500">*</span></label>
                                            <button ref="categoryBtnRef" @click="toggleDropdown('category')" type="button" 
                                                class="w-full text-sm rounded-xl py-3.5 px-4 transition-all duration-300 shadow-inner font-public-sans flex items-center justify-between text-left" 
                                                :class="[
                                                    form.service_category ? 'text-gray-900 font-bold' : 'text-gray-400 font-medium',
                                                    form.errors.service_category ? 'border border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500' : 'border border-transparent bg-slate-100 hover:bg-gray-100 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20'
                                                ]">
                                                <span>{{ form.service_category || 'Pilih Aspek Penilaian' }}</span>
                                                <ChevronDown class="w-4 h-4 text-gray-500 transition-transform" :class="{'rotate-180': isCategoryOpen}" />
                                            </button>
                                            <InputError :message="form.errors.service_category" />
                                        </div>

                                        <div class="bg-white p-6 rounded-2xl border shadow-sm relative z-0" :class="form.errors.rating ? 'border-red-500 bg-red-50/30' : 'border-gray-200'">
                                            <label class="block font-optimus font-bold text-center text-primary text-lg mb-8">Seberapa puas Anda terhadap hal ini? <span class="text-red-500">*</span></label>
                                            
                                            <div class="relative max-w-[260px] sm:max-w-xs mx-auto">
                                                <div class="absolute top-1/2 left-0 w-full h-1.5 bg-gray-200 -translate-y-1/2 rounded-full -z-10"></div>
                                                <div class="absolute top-1/2 left-0 h-1.5 bg-primary -translate-y-1/2 rounded-full -z-10 transition-all duration-500" :style="`width: ${(form.rating - 1) * 25}%`"></div>

                                                <div class="flex justify-between items-center relative">
                                                    <label v-for="i in 5" :key="i" class="cursor-pointer text-center group">
                                                        <input type="radio" v-model="form.rating" :value="i" class="hidden">
                                                        <div 
                                                            class="w-10 h-10 sm:w-12 sm:h-12 mx-auto flex items-center justify-center rounded-full border-2 transition-all duration-300 relative bg-white"
                                                            :class="form.rating >= i ? 'border-primary shadow-md transform scale-110' : 'border-gray-300 group-hover:border-primary/50'"
                                                        >
                                                            <div 
                                                                class="w-full h-full rounded-full flex items-center justify-center transition-all duration-300"
                                                                :class="form.rating >= i ? 'bg-primary text-white scale-100' : 'bg-transparent text-gray-600 scale-90'"
                                                            >
                                                                <span class="text-lg font-bold">{{ i }}</span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-between max-w-[260px] sm:max-w-xs mx-auto mt-5">
                                                <span class="text-[10px] font-public-sans font-bold uppercase tracking-widest transition-colors" :class="form.rating <= 2 ? 'text-red-500' : 'text-gray-400'">Kurang</span>
                                                <span class="text-[10px] font-public-sans font-bold uppercase tracking-widest transition-colors" :class="form.rating >= 4 ? 'text-green-600' : 'text-gray-400'">Puas</span>
                                            </div>
                                            <InputError :message="form.errors.rating" class="text-center mt-4" />
                                        </div>

                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-public-sans font-bold text-gray-700 ml-1">Masukan Tambahan <span class="text-red-500">*</span></label>
                                            <textarea v-model="form.feedback" rows="4" 
                                                class="w-full text-sm font-medium rounded-2xl py-4 px-4 transition-all duration-300 shadow-inner resize-none" 
                                                :class="form.errors.feedback ? 'border-red-500 bg-red-50 text-red-900 placeholder-red-400 focus:ring-red-500 focus:border-red-500' : 'border-transparent bg-slate-100 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20'"
                                                placeholder="Tuliskan saran atau pengalaman Anda secara singkat..."></textarea>
                                            <InputError :message="form.errors.feedback" />
                                        </div>
                                    </div>
                                </section>

                                <div class="pt-4 md:ml-12">
                                    <button 
                                        type="submit" 
                                        :disabled="form.processing"
                                        class="relative w-full overflow-hidden bg-primary text-white font-public-sans font-bold text-sm md:text-base py-4 rounded-xl shadow-lg hover:bg-blue-800 hover:shadow-primary/20 transform hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-70 disabled:cursor-not-allowed group"
                                    >
                                        <div class="absolute top-0 -inset-full h-full w-1/2 z-5 block transform -skew-x-12 bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 group-hover:animate-shine"></div>
                                        <span class="relative z-10 flex items-center justify-center gap-2">
                                            <svg v-if="form.processing" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            {{ form.processing ? 'MEMPROSES DATA...' : 'KIRIM PENILAIAN' }}
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </template>

                    <template v-else>
                        <div class="p-10 md:p-20 text-center bg-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full mix-blend-multiply filter blur-3xl opacity-60 -translate-y-1/2 translate-x-1/4"></div>
                            <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/5 rounded-full mix-blend-multiply filter blur-3xl opacity-60 translate-y-1/2 -translate-x-1/4"></div>

                            <div class="relative z-10 flex flex-col items-center">
                                <div class="inline-flex items-center justify-center w-24 h-24 bg-primary rounded-full mb-6 shadow-lg shadow-primary/20 transform scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-3xl md:text-4xl font-optimus font-bold text-primary mb-4">Evaluasi Berhasil Dikirim!</h3>
                                <p class="text-gray-600 text-base md:text-lg mb-10 max-w-md mx-auto font-public-sans leading-relaxed">
                                    Terima kasih atas kontribusi Anda dalam mewujudkan keterbukaan informasi di lingkungan FSTI ITK.
                                </p>
                                <button @click="isSubmitted = false" class="px-10 py-3.5 rounded-xl border-2 border-primary text-primary font-public-sans font-bold hover:bg-primary hover:text-white transform hover:-translate-y-0.5 transition-all duration-300 text-sm">
                                    Kirim Masukan Lain
                                </button>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </PublicLayout>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-150" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-100" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isTypeOpen" id="type-dropdown-menu" :style="typeDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-2xl border border-gray-200 py-2 overflow-hidden">
                <a v-for="t in respondentTypes" :key="t" @click="selectOption('type', t)" class="block px-5 py-3 text-sm text-gray-800 font-bold hover:bg-slate-100 hover:text-primary font-public-sans cursor-pointer transition-colors">{{ t }}</a>
            </div>
        </transition>
    </Teleport>

    <Teleport to="body">
        <transition enter-active-class="transition ease-out duration-150" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-100" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <div v-if="isCategoryOpen" id="category-dropdown-menu" :style="categoryDropdownStyle" class="z-[9999] bg-white rounded-xl shadow-2xl border border-gray-200 py-2 overflow-hidden">
                <a v-for="c in props.categories" :key="c.id" @click="selectOption('category', c.name)" class="block px-5 py-3 text-sm text-gray-800 font-bold hover:bg-slate-100 hover:text-primary font-public-sans cursor-pointer transition-colors">
                    {{ c.name }}
                </a>
                
                <a v-if="!props.categories || props.categories.length === 0" class="block px-5 py-3 text-sm text-gray-400 italic font-public-sans cursor-not-allowed">
                    Belum ada aspek tersedia
                </a>
            </div>
        </transition>
    </Teleport>
</template>

<style scoped>
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(20px, -30px) scale(1.05); }
  66% { transform: translate(-10px, 10px) scale(0.95); }
  100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob { animation: blob 8s infinite; }
.animation-delay-2000 { animation-delay: 2s; }
@keyframes shine { 100% { left: 125%; } }
.animate-shine { animation: shine 1s; }

input:focus, textarea:focus, button:focus { outline: none; }
</style>