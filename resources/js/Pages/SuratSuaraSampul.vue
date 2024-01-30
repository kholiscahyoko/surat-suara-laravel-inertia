<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4">
        Surat Suara Wilayah
    </h1>
    <h2 class="text-xl font-bold tracking-tight text-gray-900 mb-4">
        {{ label_wilayah }}
    </h2>
    <div class="lg:text-lg md:text-md sm:text-sm text-xs text-center font-bold tracking-tight text-gray-900 mb-4">
        ( Klik / sentuh surat suara untuk membuka )
    </div>
    <div class="flex flex-wrap justify-center">
        <SuratSuaraSampul :surat_suara="null" :jenis="`pilpres`"/>
        <SuratSuaraSampul v-if="dpd" :surat_suara="dpd" :jenis="`dpd`"/>
        <SuratSuaraSampul v-if="dpr" :surat_suara="dpr" :jenis="`dpr`"/>
        <SuratSuaraSampul v-if="dprdp" :surat_suara="dprdp" :jenis="`dprd-provinsi`"/>
        <SuratSuaraSampul v-if="dprdk" :surat_suara="dprdk" :jenis="`dprd-kabkota`"/>
    </div>
</template>
<script setup>
import SuratSuaraSampul from '../Shared/SuratSuaraSampul.vue';

defineProps({
    'dprdk' : Object,
    'dprdp' : Object,
    'dpr' : Object,
    'dpd' : Object,
    'label_wilayah' : String,
});
</script>