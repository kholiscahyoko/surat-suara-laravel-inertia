<template>
    <Head>
        <title>Calon DPRD Kabupaten - Kota</title>
        <meta name="description" content="DPD Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Calon DPRD Kabupaten / Kota
    </h1>
    <SuratSuaraContentDprdk :partais="partais" :dapil="dapil" :calon_id="calon_id"/>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraContentDprdk from '../Shared/SuratSuaraContentDprdk.vue';

defineProps({
    'partais' : Object,
    'dapil' : Object,
    'calon_id' : String,
});

onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-green-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-green-600', 'to-white');
})

</script>