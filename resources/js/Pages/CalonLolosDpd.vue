<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Calon DPD Provinsi {{ dapil.nama_dapil }} yang lolos sementara ini
    </h1>
    <CalonLolosDpd :data="data" :dapil="dapil" />
</template>
<script setup>
import CalonLolosDpd from '../Shared/CalonLolosDpd.vue';

let props = defineProps({
    data : Object,
    dapil: Object
});

</script>