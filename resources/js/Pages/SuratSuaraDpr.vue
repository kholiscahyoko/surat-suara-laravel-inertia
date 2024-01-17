<template>
    <Head>
        <title>Calon DPR RI</title>
        <meta name="description" content="DPD Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Calon DPR RI
    </h1>
    <SuratSuaraContentDpr :partais="partais" :dapil="dapil"/>
</template>
<script setup>
import SuratSuaraContentDpr from '../Shared/SuratSuaraContentDpr.vue';

defineProps({
    'partais' : Object,
    'dapil' : Object,
});
</script>