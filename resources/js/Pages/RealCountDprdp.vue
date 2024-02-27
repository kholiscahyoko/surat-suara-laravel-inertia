<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Hasil Hitung Suara DPRD Provinsi
    </h1>
    <RealCountDprdp :data="data" :master_partai="master_partai" :master_calon="master_calon" :dapil="dapil" :calon="calon" />
</template>
<script setup>
import RealCountDprdp from '../Shared/RealCountDprdp.vue';

let props = defineProps({
    data : Object,
    master_partai : Object,
    master_calon : Object,
    dapil: Object,
    calon: Object,
});

</script>