<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Hasil Hitung Suara Dewan Perwakilan Rakyat
    </h1>
    <RealCountDpr :higher_data="higher_data" :lower_data="lower_data" :master_partai="master_partai" :master_calon="master_calon" :dapil="dapil" :calon="calon" />
</template>
<script setup>
import RealCountDpr from '../Shared/RealCountDpr.vue';

let props = defineProps({
    higher_data : Object,
    lower_data : Object,
    master_partai : Object,
    master_calon : Object,
    dapil: Object,
    calon: Object,
});

</script>