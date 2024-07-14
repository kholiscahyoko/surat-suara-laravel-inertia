<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4">
        Surat Suara Wilayah
    </h1>
    <h2 class="text-xl font-bold tracking-tight text-gray-900 mb-4">
        {{ label_wilayah }}
    </h2>
    <div class="mt-2 mb-2">
        Cari Surat Suara Wilayah Lain <a :href="$setUrl('/wilayah')" class="text-indigo-600 font-semibold hover:text-indigo-900">disini</a>
    </div>
    <div class="lg:text-lg md:text-md sm:text-sm text-xs text-center font-bold tracking-tight text-gray-900 mb-4">
        ( Klik / sentuh surat suara untuk membuka )
    </div>
    <div class="flex flex-wrap justify-center">
        <SquareAds1 />
        <SuratSuaraSampul :surat_suara="null" :jenis="`pilpres`"/>
        <SuratSuaraSampul v-if="dpd" :surat_suara="dpd" :jenis="`dpd`"/>
        <SuratSuaraSampul v-if="dpr" :surat_suara="dpr" :jenis="`dpr`"/>
        <SuratSuaraSampul v-if="dprdp" :surat_suara="dprdp" :jenis="`dprd-provinsi`"/>
        <SuratSuaraSampul v-if="dprdk" :surat_suara="dprdk" :jenis="`dprd-kabkota`"/>
    </div>
    <Donations />
</template>
<script setup>
import SquareAds1 from '../Components/SquareAds1.vue';
import SuratSuaraSampul from '../Shared/SuratSuaraSampul.vue';
import Donations from '../Components/Donations.vue';

defineProps({
    'dprdk' : Object,
    'dprdp' : Object,
    'dpr' : Object,
    'dpd' : Object,
    'label_wilayah' : String,
});
</script>