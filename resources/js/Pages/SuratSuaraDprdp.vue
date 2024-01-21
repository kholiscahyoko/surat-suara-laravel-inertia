<template>
    <Head>
        <title>Calon DPRD Provinsi</title>
        <meta name="description" content="DPD Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Calon DPRD Provinsi
    </h1>
    <SuratSuaraContentDprdp :partais="partais" :dapil="dapil"/>
</template>
<script setup>
import { onMounted, onUnmounted } from 'vue';
import SuratSuaraContentDprdp from '../Shared/SuratSuaraContentDprdp.vue';

defineProps({
    'partais' : Object,
    'dapil' : Object,
});

onMounted(() => {
  document.body.classList.add('bg-gradient-to-tl', 'from-blue-600', 'to-white');
})
onUnmounted(() => {
  document.body.classList.remove('bg-gradient-to-tl', 'from-blue-600', 'to-white');
})

</script>