<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4">
        Real Count Wilayah
    </h1>
    <h2 class="text-xl font-bold tracking-tight text-gray-900 mb-4">
        {{ label_wilayah }}
    </h2>
    <div class="mt-2 mb-2">
        Cari Real Count Wilayah Lain <a :href="$setUrl('/wilayah')" class="text-indigo-600 font-semibold hover:text-indigo-900">disini</a>
    </div>
    <div class="lg:text-lg md:text-md sm:text-sm text-xs text-center font-bold tracking-tight text-gray-900 mb-4">
        ( Klik / sentuh untuk membuka )
    </div>
    <div class="flex flex-wrap justify-center">
        <RealCountSampul :surat_suara="null" :jenis="`pilpres`"/>
        <RealCountSampul v-if="dpd" :surat_suara="dpd" :jenis="`dpd`"/>
        <RealCountSampul v-if="dpr" :surat_suara="dpr" :jenis="`dpr`"/>
        <RealCountSampul v-if="dprdp" :surat_suara="dprdp" :jenis="`dprd-provinsi`"/>
        <RealCountSampul v-if="dprdk" :surat_suara="dprdk" :jenis="`dprd-kabkota`"/>
    </div>
</template>
<script setup>
import RealCountSampul from '../Shared/RealCountSampul.vue';

defineProps({
    'dprdk' : Object,
    'dprdp' : Object,
    'dpr' : Object,
    'dpd' : Object,
    'label_wilayah' : String,
});
</script>