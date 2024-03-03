<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Calon DPR RI Dapil {{ dapil?.nama_dapil }} terpilih sementara ini
    </h1>
    <CalonLolosDpr :data="data" :dapil="dapil" :kursi_dapil="kursi_dapil" :master_partai="master_partai" :nasional="nasional" />
</template>
<script setup>
import CalonLolosDpr from '../Shared/CalonLolosDpr.vue';

let props = defineProps({
    data : Object,
    dapil: Object,
    kursi_dapil: Object,
    master_partai: Object,
    nasional: Object,
});

</script>