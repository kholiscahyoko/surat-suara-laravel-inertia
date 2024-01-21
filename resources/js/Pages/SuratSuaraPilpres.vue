<template>
    <Head>
        <title>Capres dan Cawapres</title>
        <meta name="description" content="DPD Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Surat Suara Capres dan Cawapres
    </h1>
    <SuratSuaraPilpres />
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraPilpres from '../Shared/SuratSuaraPilpres.vue';

onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-gray-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-gray-600', 'to-white');
})

</script>