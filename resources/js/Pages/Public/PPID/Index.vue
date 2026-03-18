<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// DATA DINAMIS 1: Alur Layanan / Tata Cara
const alurLayanan = ref([
    {
        id: 1,
        title: 'Pengajuan Permohonan',
        description: 'Pemohon mengisi formulir dan melampirkan identitas.'
    },
    {
        id: 2,
        title: 'Pencatatan Data',
        description: 'Petugas mencatat data identitas pemohon dan memverifikasi jenis informasi publik yang diminta.'
    },
    {
        id: 3,
        title: 'Tanggapan PPID',
        description: 'Petugas memberikan jawaban sesuai persetujuan PPID, atau memberikan penjelasan jika informasi dikecualikan.'
    }
]);

// DATA DINAMIS 2: Daftar Layanan & Formulir
const daftarLayanan = ref([
  {
    id: 1,
    title: 'Formulir Permohonan Informasi Publik',
    description: 'Ajukan permohonan informasi publik secara resmi kepada PPID Fakultas Sains dan Teknologi Informasi.',
    actionText: 'Isi Formulir',
    actionLink: 'https://s.itk.ac.id/permintaanformfsti', 
    icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>'
  },
  {
    id: 2,
    title: 'Formulir Pengajuan Keberatan',
    description: 'Ajukan keberatan atas tanggapan layanan informasi publik yang telah diberikan sebelumnya.',
    actionText: 'Isi Formulir',
    actionLink: 'https://docs.google.com/forms/d/e/1FAIpQLSefIA7eJNmNHt0YXzWaWyLdp4zJUulojXUmh7xlVN-MQxZLlw/viewform', 
    icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>'
  }
]);

const getIcon = (jenis) => {
    const icons = {
        'Berkala': '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>',
        'Setiap Saat': '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>',
        'Serta Merta': '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" /></svg>'
    };
    return icons[jenis] || icons['Berkala']; 
};
</script>

<template>
    <PublicLayout>
        <Head title="PPID" />
        
        <Banner
            title="PPID - FSTI ITK"
            subtitle="PEJABAT PENGELOLA INFORMASI DAN DOKUMENTASI"
            background-image="/images/background-banner.png"
        />

        <section class="bg-white pt-12 pb-6 font-public-sans">
            <div class="relative py-8 md:py-10 overflow-hidden">
                <div class="absolute inset-y-0 left-0 w-[95%] bg-primary/10 rounded-r-[4rem] md:rounded-r-[6rem] z-0"></div>
                <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-8">
                        <div class="md:w-1/5 flex-shrink-0">
                            <div class="w-12 h-1 bg-primary mb-3"></div>
                            <h2 class="text-3xl md:text-4xl font-optimus font-bold text-primary leading-tight uppercase">
                                Tentang<br />PPID
                            </h2>
                        </div>
                        <div class="md:w-4/5 md:pl-6 md:border-l-2 border-primary/30">
                            <p class="text-base md:text-lg text-primary font-medium leading-relaxed text-justify m-0">
                                Dalam rangka pelaksanaan keterbukaan informasi publik di lingkungan Institut Teknologi Kalimantan, Tim Pejabat Pengelola Informasi dan Dokumentasi (PPID) tingkat Fakultas dibentuk. Pembentukan ini bertujuan untuk mempermudah pengelolaan dan pelayanan informasi kepada masyarakat sesuai dengan ketentuan peraturan perundang-undangan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

      <section class="bg-white pb-16 pt-8 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-primary">Daftar Informasi Publik</h2>
                    <p class="mt-3 text-gray-600 font-medium">Katalog informasi yang tersedia di Fakultas Sains dan Teknologi Informasi</p>
                </div>

                <div class="flex flex-wrap justify-center gap-8 max-w-6xl mx-auto px-4">
                    <Link 
                        v-for="info in $page.props.jenisInformasi" 
                        :key="info.jenis"
                        :href="`/ppid/informasi/${info.slug}`"
                        class="bg-white p-8 rounded-2xl shadow-sm border-t-4 border-primary hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 text-center group flex flex-col h-full w-full md:w-[calc(50%-2rem)] max-w-[420px]"
                    >
                        <div 
                            class="flex items-center justify-center w-20 h-20 bg-primary/50 rounded-full mx-auto mb-6 text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300" 
                            v-html="getIcon(info.jenis)">
                        </div>
                        
                        <h3 class="text-xl font-bold text-primary mb-4 uppercase">Informasi {{ info.jenis }}</h3>
                        
                        <p class="text-gray-600 leading-relaxed flex-grow text-[15px]">
                            Kumpulan informasi publik yang masuk ke dalam klasifikasi {{ info.jenis }} di lingkungan Fakultas Sains dan Teknologi Informasi.
                        </p>
                        
                        <div class="flex items-center justify-center gap-3 mt-6 mb-8">
                            <span class="text-xs font-bold bg-primary/20 text-primary px-3 py-1.5 rounded-md">
                                {{ info.total_kategori }} Kategori
                            </span>
                            <span class="text-xs font-bold bg-primary/10 text-primary px-3 py-1.5 rounded-md">
                                {{ info.total_dokumen }} Dokumen
                            </span>
                        </div>

                        <div class="mt-auto border-t border-gray-100 pt-6">
                            <span class="inline-flex items-center justify-center w-full px-5 py-2.5 bg-gray-50 text-primary border border-gray-200 font-bold text-sm rounded-lg group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all duration-300">
                                Lihat Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <section class="bg-white py-16 md:py-24 font-public-sans">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-primary">Layanan & Tata Cara</h2>
                    <p class="mt-3 text-gray-600 font-medium">SOP Pengelolaan Informasi Publik dan Akses Formulir Layanan</p>
                </div>

                <div class="max-w-5xl mx-auto mb-20">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-start relative">
                        <div class="hidden md:block absolute top-8 left-0 w-full h-1 bg-primary z-0"></div>
                        <div 
                            v-for="(alur, index) in alurLayanan" 
                            :key="alur.id"
                            class="flex flex-col items-center text-center p-4 w-full md:w-1/3 z-10"
                            :class="{ 'mt-8 md:mt-0': index > 0 }"
                        >
                            <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold mb-6 border-4 border-white shadow-md relative z-10">
                                {{ index + 1 }}
                            </div>
                            <h4 class="font-bold text-primary text-lg mb-3">{{ alur.title }}</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ alur.description }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto px-4">
                    <div 
                        v-for="layanan in daftarLayanan" 
                        :key="layanan.id"
                        class="bg-white border border-gray-200 p-8 rounded-xl shadow-sm hover:border-primary hover:shadow-md transition-all flex flex-col items-center text-center"
                    >
                        <div class="p-4 bg-blue-50 text-primary rounded-full mb-5" v-html="layanan.icon"></div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ layanan.title }}</h3>
                        <p class="text-gray-500 text-sm mb-8 flex-grow leading-relaxed">{{ layanan.description }}</p>
                        <a 
                            :href="layanan.actionLink"
                            target="_blank"
                            class="w-full text-center py-3 px-6 bg-primary text-white hover:bg-primary-hover font-semibold rounded-lg shadow-sm transition-colors"
                        >
                            {{ layanan.actionText }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>