<script setup lang="ts">
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue'; 
</script>

<template>
  <div class="bg-white font-sans antialiased overflow-x-hidden">
    <Navbar />

    <main>
      <slot />
    </main>

     <Footer />
  </div>
</template>