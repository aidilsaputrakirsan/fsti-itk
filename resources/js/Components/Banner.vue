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
    class="relative h-64 md:h-72 w-full bg-cover bg-center flex items-center justify-center shadow-sm mt-2"
    :style="bannerStyle"
  >
    <div class="absolute inset-0 bg-[#2F4DD3] opacity-60"></div>

    <div class="relative z-10 mt-10 text-center px-4">
      <h1
        class="text-white text-4xl sm:text-5xl md:text-6xl font-optimus uppercase tracking-wider text-shadow-custom text-stroke-custom"
      >
        {{ title }}
      </h1>
    </div>
  </div>
</template>

<style scoped>
/* Menyesuaikan text-stroke dengan warna biru ITK */
.text-stroke-custom {
  -webkit-text-stroke: 1px #2F4DD3;
  color: white;
}
/* Menambahkan bayangan untuk efek kedalaman dan kemudahan membaca */
.text-shadow-custom {
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
}
</style>