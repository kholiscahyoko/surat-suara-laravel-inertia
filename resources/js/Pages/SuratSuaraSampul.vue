<template>
    <Head>
        <title>Surat Suara Wilayah</title>
        <meta name="description" content="Surat Suara Wilayah Information" head-key="meta-description">
    </Head>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Surat Suara Wilayah
    </h1>
    <div class="flex flex-wrap justify-center">
        <SuratSuaraSampul :surat_suara="null" :jenis="`pilpres`"/>
        <SuratSuaraSampul v-if="dpd" :surat_suara="dpd" :jenis="`dpd`"/>
        <SuratSuaraSampul v-if="dpr" :surat_suara="dpr" :jenis="`dpr`"/>
        <SuratSuaraSampul v-if="dprdp" :surat_suara="dprdp" :jenis="`dprdp`"/>
        <SuratSuaraSampul v-if="dprdk" :surat_suara="dprdk" :jenis="`dprdk`"/>
    </div>
</template>
<script setup>
import SuratSuaraSampul from '../Shared/SuratSuaraSampul.vue';

defineProps({
    'dprdk' : Object,
    'dprdp' : Object,
    'dpr' : Object,
    'dpd' : Object
});
</script>