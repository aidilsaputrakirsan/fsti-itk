<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  backgroundImage: {
    type: String,
    required: true,
  }
});

const bannerStyle = computed(() => {
  return {
    backgroundImage: `url('${props.backgroundImage}')`
  };
});
</script>

<template>
  <div
    class="relative w-full bg-cover bg-center flex items-center justify-center shadow-sm mt-2 transition-all duration-300 h-56 sm:h-64 md:h-72 lg:h-80"
    :style="bannerStyle"
  >
    <div class="absolute inset-0 bg-[#2F4DD3] opacity-60"></div>

    <div class="relative z-10 mt-10 md:mt-12 text-center px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
      <h1
        class="text-white font-optimus uppercase tracking-wider text-shadow-custom text-stroke-custom transition-all duration-300 leading-tight text-3xl sm:text-4xl md:text-5xl lg:text-6xl md:whitespace-nowrap"
      >
        {{ title }}
      </h1>
    </div>
  </div>
</template>

<style scoped>
.text-stroke-custom {
  -webkit-text-stroke: 1px #2F4DD3;
  color: white;
}
.text-shadow-custom {
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
}
</style>