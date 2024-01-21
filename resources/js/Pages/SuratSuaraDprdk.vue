<template>
    <Head>
        <title>Calon DPRD Kabupaten - Kota</title>
        <meta name="description" content="DPD Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Calon DPRD Kabupaten / Kota
    </h1>
    <SuratSuaraContentDprdk :partais="partais" :dapil="dapil"/>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraContentDprdk from '../Shared/SuratSuaraContentDprdk.vue';

defineProps({
    'partais' : Object,
    'dapil' : Object,
});

onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-green-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-green-600', 'to-white');
})

</script>