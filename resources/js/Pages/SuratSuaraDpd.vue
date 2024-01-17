<template>
    <Head>
        <title>Calon DPD RI</title>
        <meta name="description" content="DPD Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Calon DPD RI
    </h1>
    <SuratSuaraContentDpd :calons="calons" :dapil="dapil"/>
</template>
<script setup>
import SuratSuaraContentDpd from '../Shared/SuratSuaraContentDpd.vue';

defineProps({
    'calons' : Object,
    'dapil' : Object,
});
</script>