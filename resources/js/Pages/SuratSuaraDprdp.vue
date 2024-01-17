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
import SuratSuaraContentDprdp from '../Shared/SuratSuaraContentDprdp.vue';

defineProps({
    'partais' : Object,
    'dapil' : Object,
});
</script>