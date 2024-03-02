<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Calon DPRD Kabupaten/Kota Dapil {{ dapil?.nama_dapil }} terpilih sementara ini
    </h1>
    <CalonLolosDprdk :data="data" :dapil="dapil" :kursi_dapil="kursi_dapil" :master_partai="master_partai" />
</template>
<script setup>
import CalonLolosDprdk from '../Shared/CalonLolosDprdk.vue';

let props = defineProps({
    data : Object,
    dapil: Object,
    kursi_dapil: Object,
    master_partai: Object
});

</script>