<script setup lang="ts">
import { ExclamationCircleIcon } from '@heroicons/vue/24/outline';

defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-if="message" class="mt-2 flex items-center gap-2 text-red-700 bg-red-100 p-2.5 rounded-lg border border-red-200 animate-pulse">
        <ExclamationCircleIcon class="h-5 w-5 flex-shrink-0" />
        <span class="text-xs font-bold tracking-wide">{{ message }}</span>
    </div>
</template>