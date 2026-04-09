<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen items-center justify-center relative bg-slate-100 font-public-sans">
        <div class="absolute inset-0 z-0">
            <img 
                src="/images/background-banner.png" 
                alt="Background FSTI ITK" 
                class="w-full h-full object-cover opacity-20" 
            />
            <div class="absolute inset-0 bg-gradient-to-b from-primary/10 to-slate-100/95 mix-blend-multiply"></div>
        </div>

        <div class="relative z-10 w-full max-w-md px-8 py-10 bg-white shadow-2xl rounded-2xl border-t-4 border-primary">
            <div class="mb-8 text-center flex flex-col items-center">
                <Link href="/" class="block mb-4">
                    <img 
                        src="/images/logofsti.png" 
                        alt="Logo FSTI ITK" 
                        class="h-24 w-auto object-contain transition-transform duration-300 hover:scale-105 drop-shadow-sm" 
                    />
                </Link>
                <h2 class="text-xl font-bold text-gray-900 font-optimus tracking-wide text-center leading-snug">
                    FAKULTAS SAINS DAN<br/>TEKNOLOGI INFORMASI
                </h2>
                <p class="text-xs text-gray-500 mt-2 tracking-widest uppercase font-semibold">
                    Institut Teknologi Kalimantan
                </p>
            </div>

            <slot />
        </div>
    </div>
</template>