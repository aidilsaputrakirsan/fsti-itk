<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { ChevronDown } from 'lucide-vue-next';

const page = usePage();
const currentLocale = computed(() => page.props.locale);
const isOpen = ref(false);

const languages = {
    id: { label: 'ID', name: 'Indonesia', flag: 'https://flagcdn.com/w40/id.png' },
    en: { label: 'EN', name: 'English', flag: 'https://flagcdn.com/w40/gb.png' }
};

const switchLang = (lang) => {
    isOpen.value = false;
    // Force reload via simple visit to ensure backend session updates
    window.location.href = route('lang.switch', lang);
};

// Close dropdown when clicking outside
const closeDropdown = (e) => {
    if (!e.target.closest('.language-switcher')) {
        isOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener('click', closeDropdown);
});

onUnmounted(() => {
    window.removeEventListener('click', closeDropdown);
});
</script>

<template>
    <div class="relative language-switcher">
        <!-- Button Trigger -->
        <button 
            @click.stop="isOpen = !isOpen"
            class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-white/20 hover:bg-white/30 text-white transition-all duration-200 border border-white/30 backdrop-blur-sm"
        >
            <img 
                :src="languages[currentLocale]?.flag || languages.id.flag" 
                alt="Flag" 
                class="w-5 h-3.5 object-cover rounded-sm shadow-sm"
            >
            <span class="text-sm font-semibold tracking-wide">
                {{ languages[currentLocale]?.label || 'ID' }}
            </span>
            <ChevronDown 
                class="w-4 h-4 transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }"
            />
        </button>

        <!-- Dropdown Menu -->
        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div 
                v-if="isOpen"
                class="absolute right-0 mt-2 w-40 origin-top-right bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden z-[100]"
            >
                <div class="py-1">
                    <button
                        v-for="(lang, key) in languages"
                        :key="key"
                        @click="switchLang(key)"
                        class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#133E87] transition-colors"
                        :class="{ 'bg-blue-50 text-[#133E87] font-semibold': currentLocale === key }"
                    >
                        <img 
                            :src="lang.flag" 
                            :alt="lang.name" 
                            class="w-5 h-3.5 object-cover rounded-sm border border-gray-200 mr-3 shadow-sm group-hover:scale-110 transition-transform"
                        >
                        {{ lang.name }}
                    </button>
                </div>
            </div>
        </transition>
    </div>
</template>
